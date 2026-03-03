<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot; // ← IMPORTANT: Utiliser Pivot au lieu de Model
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Eleve;
use App\Models\ParentEleve;

class EleveParent extends Pivot // ← CORRECTION: extends Pivot au lieu de Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'eleve_parents';

    /**
     * Indique si le modèle doit être horodaté.
     *
     * @var bool
     */
    public $timestamps = true; // ← AJOUT: Important pour les pivots

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'eleve_id',
        'parent_eleve_id',
        'lien_parental',
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Les attributs à ajouter aux tableaux JSON.
     *
     * @var array
     */
    protected $appends = [
        'lien_parental_libelle', // ← CORRECTION: Retirer nom_complet_relation qui peut causer des problèmes
    ];

    /**
     * Obtient l'élève associé à cette relation.
     */
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class, 'eleve_id');
    }

    /**
     * Obtient le parent associé à cette relation.
     */
    public function parentEleve(): BelongsTo
    {
        return $this->belongsTo(ParentEleve::class, 'parent_eleve_id');
    }

    /**
     * Libellé du lien parental en français
     */
    public function getLienParentalLibelleAttribute(): string
    {
        $liens = [
            'pere' => 'Père',
            'mere' => 'Mère',
            'tuteur' => 'Tuteur légal',
            'grand_parent' => 'Grand-parent',
            'oncle' => 'Oncle',
            'tante' => 'Tante',
            'frere' => 'Frère',
            'soeur' => 'Soeur',
            'autre' => 'Autre',
        ];

        return $liens[$this->lien_parental] ?? ucfirst($this->lien_parental);
    }

    /**
     * Scope pour filtrer par élève
     */
    public function scopePourEleve($query, $eleveId)
    {
        return $query->where('eleve_id', $eleveId);
    }

    /**
     * Scope pour filtrer par parent
     */
    public function scopePourParent($query, $parentId)
    {
        return $query->where('parent_eleve_id', $parentId);
    }

    /**
     * Scope pour filtrer par lien parental
     */
    public function scopeAvecLien($query, $lien)
    {
        return $query->where('lien_parental', $lien);
    }

    /**
     * Scope pour filtrer les relations actives (élève inscrit)
     */
    public function scopeAvecEleveActif($query)
    {
        return $query->whereHas('eleve', function($q) {
            $q->where('statut', true);
        });
    }

    /**
     * Vérifie si une relation existe déjà
     */
    public static function relationExiste($eleveId, $parentId): bool
    {
        return self::where('eleve_id', $eleveId)
                   ->where('parent_eleve_id', $parentId)
                   ->exists();
    }

    /**
     * Récupère tous les parents d'un élève avec leurs liens
     */
    public static function getParentsParEleve($eleveId)
    {
        return self::with('parentEleve')
                   ->where('eleve_id', $eleveId)
                   ->get()
                   ->map(function($relation) {
                       return [
                           'parent' => $relation->parentEleve,
                           'lien' => $relation->lien_parental,
                           'lien_libelle' => $relation->lien_parental_libelle,
                       ];
                   });
    }

    /**
     * Récupère tous les élèves d'un parent avec leurs liens
     */
    public static function getElevesParParent($parentId)
    {
        return self::with('eleve')
                   ->where('parent_eleve_id', $parentId)
                   ->get()
                   ->map(function($relation) {
                       return [
                           'eleve' => $relation->eleve,
                           'lien' => $relation->lien_parental,
                           'lien_libelle' => $relation->lien_parental_libelle,
                       ];
                   });
    }

    /**
     * Boot du modèle pour les événements
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($eleveParent) {
            if (self::relationExiste($eleveParent->eleve_id, $eleveParent->parent_eleve_id)) {
                throw new \Exception('Cette relation élève-parent existe déjà.');
            }
        });
    }
}