<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Inscription;
use App\Models\Reinscription;
use App\Models\Absence;
use App\Models\Note;
use App\Models\Bulletin;
use App\Models\ParentEleve;
use App\Models\User;
use App\Models\Classe;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // 'classe_id', // Commenté car utilisation du système d'inscriptions
        'matricule',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'genre',
        'adresse',
        'telephone',
        'email',
        'photo',
        'date_inscription',
        'statut',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_inscription' => 'date',
        'statut' => 'boolean',
    ];

    protected $appends = [
        'classe_actuelle', // ✅ AJOUT: Pour rendre l'accesseur disponible dans les vues
        'est_inscrit',     // ✅ AJOUT: Pour vérifier rapidement le statut d'inscription
        'nom_complet',      // ✅ AJOUT: Pour obtenir le nom complet facilement
    ];

    /**
     * Relation avec les inscriptions
     */
    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    /**
     * Relation directe avec la classe via l'inscription active
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Alias pour obtenir la classe actuelle (via inscription active)
     */
    public function getClasseRelationAttribute()
    {
        return $this->classe_actuelle;
    }

    /**
     * ✅ AMÉLIORATION: Récupère la classe actuelle de l'élève via la dernière inscription active
     */
    public function getClasseActuelleAttribute()
    {
        $inscriptionActive = $this->inscriptions()
            ->where('statut', true)
            ->with('classe')
            ->latest()
            ->first();
            
        return $inscriptionActive?->classe;
    }

    /**
     * Récupère toutes les classes où l'élève a été inscrit
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class, 'inscriptions')
                    ->withPivot(['annee_scolaire_id', 'date_inscription', 'statut', 'observation'])
                    ->withTimestamps();
    }

    /**
     * ✅ AJOUT: Récupère l'inscription active de l'élève
     */
    public function inscriptionActive()
    {
        return $this->hasOne(Inscription::class)
                    ->where('statut', true)
                    ->with('classe', 'anneeScolaire')
                    ->latest();
    }

    /**
     * ✅ AJOUT: Récupère toutes les inscriptions actives (normalement une seule)
     */
    public function inscriptionsActives()
    {
        return $this->inscriptions()->where('statut', true);
    }

    public function reinscriptions(): HasMany
    {
        return $this->hasMany(Reinscription::class);
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function bulletins(): HasMany
    {
        return $this->hasMany(Bulletin::class);
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(ParentEleve::class, 'eleve_parents', 'eleve_id', 'parent_eleve_id')
                    ->withPivot('lien_parental')
                    ->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ✅ AJOUT: Vérifie si l'élève a un compte utilisateur
     */
    public function getHasUserAttribute(): bool
    {
        return !is_null($this->user_id);
    }

    /**
     * ✅ AJOUT: Récupère le nom complet de l'élève
     */
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * ✅ AJOUT: Vérifie si l'élève a une inscription active
     */
    public function getEstInscritAttribute(): bool
    {
        return $this->inscriptions()
                    ->where('statut', true)
                    ->exists();
    }

    /**
     * ✅ AJOUT: Récupère le nombre total d'absences de l'élève
     */
    public function getTotalAbsencesAttribute(): int
    {
        return $this->absences()->count();
    }

    /**
     * ✅ AJOUT: Récupère la moyenne générale de l'élève
     */
    public function getMoyenneGeneraleAttribute(): ?float
    {
        $moyenne = $this->notes()->avg('note');
        return $moyenne ? round($moyenne, 2) : null;
    }

    /**
     * Scope pour filtrer les élèves par classe (via les inscriptions)
     */
    public function scopeInscritDansClasse($query, $classeId)
    {
        return $query->whereHas('inscriptions', function($q) use ($classeId) {
            $q->where('classe_id', $classeId)
              ->where('statut', true);
        });
    }

    /**
     * Scope pour filtrer les élèves par année scolaire
     */
    public function scopeInscritDansAnneeScolaire($query, $anneeScolaireId)
    {
        return $query->whereHas('inscriptions', function($q) use ($anneeScolaireId) {
            $q->where('annee_scolaire_id', $anneeScolaireId);
        });
    }

    /**
     * Scope pour filtrer les élèves par statut (actif/inactif)
     */
    public function scopeActifs($query)
    {
        return $query->where('statut', true);
    }

    /**
     * Scope pour filtrer les élèves par genre
     */
    public function scopeDeGenre($query, $genre)
    {
        return $query->where('genre', $genre);
    }

    /**
     * ✅ AJOUT: Récupère le nombre total d'élèves par classe (pour les statistiques)
     */
    public static function getStatsParClasse($anneeScolaireId = null)
    {
        $query = Inscription::query();
        
        if ($anneeScolaireId) {
            $query->where('annee_scolaire_id', $anneeScolaireId);
        }
        
        return $query->where('statut', true)
                    ->selectRaw('classe_id, count(*) as total')
                    ->groupBy('classe_id')
                    ->with('classe')
                    ->get();
    }

    /**
     * ✅ AMÉLIORATION: Génère un matricule unique pour l'élève
     * Format: AAAA + Première lettre du nom + Numéro séquentiel (4 chiffres)
     */
    public static function genererMatricule($nom)
    {
        $annee = date('Y');
        $premiereLettre = strtoupper(substr(trim($nom), 0, 1));
        
        // Vérifier que la première lettre est valide
        if (!preg_match('/[A-Z]/', $premiereLettre)) {
            $premiereLettre = 'X';
        }
        
        $dernier = self::whereYear('created_at', $annee)
                       ->where('matricule', 'like', $annee . '%')
                       ->orderBy('matricule', 'desc')
                       ->first();
        
        if ($dernier && $dernier->matricule) {
            $dernierNumero = intval(substr($dernier->matricule, -4));
            $nouveauNumero = str_pad($dernierNumero + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nouveauNumero = '0001';
        }
        
        $matricule = $annee . $premiereLettre . $nouveauNumero;
        
        // Vérifier l'unicité
        $tentatives = 0;
        while (self::where('matricule', $matricule)->exists() && $tentatives < 100) {
            $nouveauNumero = str_pad(intval($nouveauNumero) + 1, 4, '0', STR_PAD_LEFT);
            $matricule = $annee . $premiereLettre . $nouveauNumero;
            $tentatives++;
        }
        
        return $matricule;
    }

    /**
     * ✅ AJOUT: Vérifie si l'email est unique (sauf pour l'élève actuel)
     */
    public static function isEmailUnique($email, $excludeId = null)
    {
        $query = self::where('email', $email);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return !$query->exists();
    }

    /**
     * ✅ AJOUT: Boot du modèle pour les événements
     */
    protected static function boot()
    {
        parent::boot();

        // Avant la création, générer automatiquement le matricule si non fourni
        static::creating(function ($eleve) {
            if (empty($eleve->matricule)) {
                $eleve->matricule = self::genererMatricule($eleve->nom);
            }
        });

        // Avant la suppression, vérifier les contraintes
        static::deleting(function ($eleve) {
            // Note: Les inscriptions et autres relations sont gérées dans le contrôleur
            // Mais on peut ajouter une vérification ici
            if ($eleve->inscriptions()->exists()) {
                throw new \Exception('Supprimez d\'abord les inscriptions de l\'élève.');
            }
        });
    }

    /**
     * ✅ AJOUT: Récupère l'âge de l'élève
     */
    public function getAgeAttribute(): int
    {
        return $this->date_naissance->age;
    }

    /**
     * ✅ AJOUT: Formate la date de naissance
     */
    public function getDateNaissanceFormateeAttribute(): string
    {
        return $this->date_naissance->format('d/m/Y');
    }

    /**
     * ✅ AJOUT: Récupère les statistiques complètes de l'élève
     */
    public function getStatsAttribute(): array
    {
        return [
            'age' => $this->age,
            'moyenne' => $this->moyenne_generale,
            'total_absences' => $this->total_absences,
            'total_notes' => $this->notes()->count(),
            'total_bulletins' => $this->bulletins()->count(),
            'total_inscriptions' => $this->inscriptions()->count(),
            'est_inscrit' => $this->est_inscrit,
            'classe_actuelle' => $this->classe_actuelle?->nom_complet ?? null,
        ];
    }

    /**
     * ✅ AJOUT: Récupère l'historique des classes avec années
     */
    public function getHistoriqueClassesAttribute()
    {
        return $this->inscriptions()
                    ->with('classe', 'anneeScolaire')
                    ->orderBy('date_inscription', 'desc')
                    ->get()
                    ->map(function($inscription) {
                        return [
                            'classe' => $inscription->classe,
                            'annee_scolaire' => $inscription->anneeScolaire,
                            'date_inscription' => $inscription->date_inscription,
                            'statut' => $inscription->statut,
                            'observation' => $inscription->observation,
                        ];
                    });
    }
}