<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\EnseignantMatiereClasse;
use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Matiere;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'matricule',
        'nom',
        'prenom',
        'genre',
        'date_naissance',
        'lieu_naissance',
        'telephone',
        'email',
        'adresse',
        'specialite',
        'photo',
        'statut',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'statut' => 'boolean',
    ];

    protected $appends = [
        'nom_complet',
        'age',
    ];

    /**
     * Relation avec l'utilisateur associé
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les matières et classes
     */
    public function enseignantMatiereClasses(): HasMany
    {
        return $this->hasMany(EnseignantMatiereClasse::class);
    }

    /**
     * Alias pour la relation
     */
    public function matiereClasses(): HasMany
    {
        return $this->enseignantMatiereClasses();
    }

    /**
     * Récupérer les classes enseignées par cet enseignant
     */
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'enseignant_matiere_classes', 'enseignant_id', 'classe_id')
                    ->withPivot('matiere_id', 'annee_scolaire_id')
                    ->withTimestamps();
    }

    /**
     * Récupérer les matières enseignées par cet enseignant
     */
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'enseignant_matiere_classes', 'enseignant_id', 'matiere_id')
                    ->withPivot('classe_id', 'annee_scolaire_id')
                    ->withTimestamps();
    }

    /**
     * Relation avec les évaluations créées par cet enseignant
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * ✅ AJOUT: Accesseur pour le nom complet
     */
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * ✅ AJOUT: Accesseur pour l'âge
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_naissance?->age;
    }

    /**
     * ✅ AJOUT: Accesseur pour le nombre de classes enseignées
     */
    public function getNombreClassesAttribute(): int
    {
        return $this->enseignantMatiereClasses()
            ->distinct('classe_id')
            ->count('classe_id');
    }

    /**
     * ✅ AJOUT: Accesseur pour le nombre de matières enseignées
     */
    public function getNombreMatieresAttribute(): int
    {
        return $this->enseignantMatiereClasses()
            ->distinct('matiere_id')
            ->count('matiere_id');
    }

    /**
     * ✅ AJOUT: Scope pour filtrer les enseignants actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('statut', true);
    }

    /**
     * ✅ AJOUT: Scope pour filtrer par spécialité
     */
    public function scopeDeSpecialite($query, $specialite)
    {
        return $query->where('specialite', $specialite);
    }

    /**
     * ✅ AJOUT: Générer un matricule unique
     */
    public static function genererMatricule($nom)
    {
        $annee = date('Y');
        $premiereLettre = strtoupper(substr($nom, 0, 1));
        
        $dernier = self::whereYear('created_at', $annee)
                       ->orderBy('id', 'desc')
                       ->first();
        
        if ($dernier && $dernier->matricule) {
            $dernierNumero = intval(substr($dernier->matricule, -4));
            $nouveauNumero = str_pad($dernierNumero + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nouveauNumero = '0001';
        }
        
        return 'ENS' . $annee . $premiereLettre . $nouveauNumero;
    }
}