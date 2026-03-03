<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Eleve;
use Illuminate\Support\Str;

class ParentEleve extends Model
{
    use HasFactory;

    protected $table = 'parent_eleves';

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'genre',
        'profession',
        'telephone',
        'email',
        'adresse',
        'photo',
        'date_naissance',
        'lieu_naissance',
        'statut',
        'notes',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'statut' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'full_name',
        'initiales',
        'enfants_count', // ← AJOUT: Pour avoir le nombre d'enfants directement
    ];

    /**
     * Relation avec l'utilisateur (compte de connexion)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les élèves (enfants)
     */
    public function eleves(): BelongsToMany
    {
        return $this->belongsToMany(Eleve::class, 'eleve_parents', 'parent_eleve_id', 'eleve_id')
                    ->using(EleveParent::class)
                    ->withPivot('lien_parental')
                    ->withTimestamps();
    }

    /**
     * ✅ AJOUT: Vérifier si le parent a un compte utilisateur
     */
    public function hasUserAccount(): bool
    {
        return !is_null($this->user_id);
    }

    /**
     * ✅ AJOUT: Getter pour le nombre d'enfants
     */
    public function getEnfantsCountAttribute(): int
    {
        return $this->eleves()->count();
    }

    /**
     * Scope pour les parents actifs
     */
    public function scopeActif($query)
    {
        return $query->where('statut', true);
    }

    /**
     * Scope pour les parents inactifs
     */
    public function scopeInactif($query)
    {
        return $query->where('statut', false);
    }

    /**
     * Scope pour rechercher un parent
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('telephone', 'like', "%{$search}%");
        });
    }

    /**
     * Obtenir le nom complet
     */
    public function getFullNameAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Obtenir les initiales
     */
    public function getInitialesAttribute(): string
    {
        return strtoupper(substr($this->prenom, 0, 1) . substr($this->nom, 0, 1));
    }

    /**
     * Obtenir le genre en texte
     */
    public function getGenreTextAttribute(): string
    {
        return match($this->genre) {
            'm' => 'Masculin',
            'f' => 'Féminin',
            default => 'Non spécifié',
        };
    }

    /**
     * Obtenir la couleur de fond pour l'avatar
     */
    public function getAvatarColorAttribute(): string
    {
        $colors = [
            'bg-blue-500',
            'bg-green-500',
            'bg-yellow-500',
            'bg-red-500',
            'bg-purple-500',
            'bg-pink-500',
            'bg-indigo-500',
        ];
        
        return $colors[crc32($this->id ?? $this->nom) % count($colors)];
    }

    /**
     * Obtenir la liste des enfants avec leur classe
     */
    public function getEnfantsAvecClasseAttribute()
    {
        return $this->eleves()->with('inscriptions.classe')->get();
    }

    /**
     * Activer le parent
     */
    public function activer(): bool
    {
        return $this->update(['statut' => true]);
    }

    /**
     * Désactiver le parent
     */
    public function desactiver(): bool
    {
        return $this->update(['statut' => false]);
    }

    /**
     * Boot du modèle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($parent) {
            if ($parent->email) {
                $existing = self::where('email', $parent->email)->exists();
                if ($existing) {
                    throw new \Exception('Un parent avec cet email existe déjà.');
                }
            }
        });

        static::deleting(function ($parent) {
            if ($parent->eleves()->exists()) {
                throw new \Exception('Impossible de supprimer un parent qui a des enfants.');
            }
        });
    }
}