<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany; // ✅ AJOUT
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles; // Utilisation du trait Spatie pour les rôles


    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active', // On garde is_active pour le statut du compte
        'photo', // Ajout du champ photo
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
   protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
    'is_active' => 'boolean',
    'last_login_at' => 'datetime', // Déjà présent normalement
];

    /**
     * Les attributs qui doivent être ajoutés aux tableaux.
     *
     * @var array
     */
    protected $appends = [
        'role_names',
        'is_admin',
        'is_enseignant',
        'is_eleve',
        'is_parent',
        'photo_url', // Ajout de l'accesseur pour l'URL de la photo
        'initials', // Ajout des initiales pour l'avatar par défaut
    ];



    /**
     * Récupère le libellé du rôle de l'utilisateur
     *
     * @return string
     */
    public function getRoleLibelle(): string
    {
        // Récupère le premier rôle de l'utilisateur
        $role = $this->roles->first();

        if (!$role) {
            return 'Aucun rôle';
        }

        // Vous pouvez personnaliser les libellés ici
        return match($role->name) {
            'administrateur' => 'Administrateur',
            'enseignant' => 'Enseignant',
            'eleve' => 'Élève',
            'parent' => 'Parent',
            default => ucfirst($role->name)
        };
    }

    /**
     * Récupère tous les rôles de l'utilisateur sous forme de libellés
     *
     * @return string
     */
    public function getRolesLibelles(): string
    {
        $roles = $this->roles->map(function($role) {
            return match($role->name) {
                'administrateur' => 'Administrateur',
                'enseignant' => 'Enseignant',
                'eleve' => 'Élève',
                'parent' => 'Parent',
                default => ucfirst($role->name)
            };
        });

        return $roles->implode(', ');
    }




    // RELATIONS AJOUTÉES

    /**
     * Relation avec les notifications personnalisées
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Relation avec les notifications non lues
     */
    public function unreadNotifications(): HasMany
    {
        return $this->notifications()->where('read', false);
    }

    /**
     * Relation avec les logs d'activité
     */
    // public function activityLogs(): HasMany
    // {
    //     return $this->hasMany(ActivityLog::class);
    // }

    // ✅ FIN DES RELATIONS AJOUTÉES

    /**
     * Relation avec l'élève associé (si l'utilisateur est un élève)
     */
    public function eleve(): HasOne
    {
        return $this->hasOne(Eleve::class);
    }

    /**
     * Relation avec l'enseignant associé (si l'utilisateur est un enseignant)
     */
    public function enseignant(): HasOne
    {
        return $this->hasOne(Enseignant::class);
    }

    /**
     * Relation avec le parent associé (si l'utilisateur est un parent)
     */
    public function parentEleve(): HasOne
    {
        return $this->hasOne(ParentEleve::class);
    }

    /**
     * Scope pour filtrer les utilisateurs actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour filtrer les utilisateurs inactifs
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope pour rechercher des utilisateurs
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    /**
     * Vérifie si l'utilisateur est un administrateur
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('administrateur');
    }

    /**
     * Vérifie si l'utilisateur est un enseignant
     */
    public function isEnseignant(): bool
    {
        return $this->hasRole('enseignant');
    }

    /**
     * Vérifie si l'utilisateur est un élève
     */
    public function isEleve(): bool
    {
        return $this->hasRole('eleve');
    }

    /**
     * Vérifie si l'utilisateur est un parent
     */
    public function isParent(): bool
    {
        return $this->hasRole('parent');
    }

    /**
     * Vérifie si l'utilisateur a plusieurs rôles
     */
    public function hasMultipleRoles(): bool
    {
        return $this->roles()->count() > 1;
    }

    /**
     * Obtient le rôle principal de l'utilisateur
     */
    public function getPrimaryRoleAttribute(): ?string
    {
        return $this->roles->first()?->name;
    }

    /**
     * Obtient la liste des noms de rôles
     */
    public function getRoleNamesAttribute(): string
    {
        return $this->roles->pluck('name')->implode(', ');
    }

    /**
     * Obtient le type de profil associé
     */
    public function getProfileTypeAttribute(): ?string
    {
        if ($this->isAdmin()) return 'admin';
        if ($this->isEnseignant()) return 'enseignant';
        if ($this->isEleve()) return 'eleve';
        if ($this->isParent()) return 'parent';
        return null;
    }

    /**
     * Obtient le profil associé
     */
    public function getProfileAttribute()
    {
        return match(true) {
            $this->isAdmin() => null, // Les admins n'ont pas de profil spécifique
            $this->isEnseignant() => $this->enseignant,
            $this->isEleve() => $this->eleve,
            $this->isParent() => $this->parentEleve,
            default => null,
        };
    }

    /**
     * Obtient le nom complet formaté
     */
    public function getFormattedNameAttribute(): string
    {
        return $this->name;
    }

    /**
     * Active le compte utilisateur
     */
    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    /**
     * Désactive le compte utilisateur
     */
    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }

    /**
     * Vérifie si le compte peut être activé
     */
    public function canBeActivated(): bool
    {
        return !$this->is_active;
    }

    /**
     * Vérifie si le compte peut être désactivé
     */
    public function canBeDeactivated(): bool
    {
        // Empêcher la désactivation du dernier administrateur
        if ($this->isAdmin() && User::role('administrateur')->count() === 1) {
            return false;
        }
        return $this->is_active;
    }

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        // Événement avant la suppression
        static::deleting(function ($user) {
            // Empêcher la suppression du dernier administrateur
            if ($user->isAdmin() && User::role('administrateur')->count() === 1) {
                throw new \Exception('Impossible de supprimer le dernier administrateur.');
            }

            // Supprimer la photo du stockage quand l'utilisateur est supprimé
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
        });

        // Événement avant la mise à jour
        static::updating(function ($user) {
            // Si la photo est modifiée, supprimer l'ancienne
            if ($user->isDirty('photo') && $user->getOriginal('photo')) {
                Storage::disk('public')->delete($user->getOriginal('photo'));
            }
        });
    }

    /**
     * Get the photo URL attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }

        // Avatar par défaut avec les initiales via UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) .
               '&color=7F9CF5&background=EBF4FF&bold=true&size=100&length=2';
    }

    /**
     * Get the initials attribute.
     *
     * @return string
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';

        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }

        return substr($initials, 0, 2); // Maximum 2 caractères
    }

    /**
     * Vérifie si l'utilisateur a une photo
     *
     * @return bool
     */
    public function hasPhoto(): bool
    {
        return !is_null($this->photo);
    }

    /**
     * Supprime la photo de l'utilisateur
     *
     * @return bool
     */
    public function deletePhoto(): bool
    {
        if ($this->photo) {
            Storage::disk('public')->delete($this->photo);
            return $this->update(['photo' => null]);
        }

        return false;
    }
}
