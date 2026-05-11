<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\AnneeScolaire;
use App\Models\Inscription;
use App\Models\Reinscription;
use App\Models\Eleve;
use App\Models\ClasseMatiere;
use App\Models\EmploiDuTemps;
use App\Models\Evaluation;
use App\Models\Enseignant;
use App\Models\Matiere;

/**
 * @property int $id
 * @property string $nom
 * @property string $niveau
 * @property string|null $serie
 * @property int $capacite
 * @property int $annee_scolaire_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read string $nom_complet
 * @property-read int $nombre_eleves_actuels
 * @property-read bool $est_pleine
 * @property-read int $places_disponibles
 * @property-read float $taux_occupation
 * @property-read array $stats
 * 
 * @property-read \App\Models\AnneeScolaire $anneeScolaire
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Eleve[] $eleves
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Eleve[] $elevesDirects
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inscription[] $inscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reinscription[] $reinscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ClasseMatiere[] $matieres
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EmploiDuTemps[] $emploisDuTemps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Evaluation[] $evaluations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EnseignantMatiereClasse[] $enseignantMatiereClasses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Enseignant[] $enseignants
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Matiere[] $matieresEnseignees
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Classe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereDate(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereMonth(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereYear(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Classe orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Classe latest($column = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe with($relations)
 * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \App\Models\Classe|null find($id, $columns = ['*'])
 * @method static \App\Models\Classe findOrFail($id, $columns = ['*'])
 * @method static \App\Models\Classe create(array $attributes = [])
 * @method static \Illuminate\Database\Eloquent\Collection|static[] all($columns = ['*'])
 * @method bool delete()
 * @method bool update(array $attributes = [], array $options = [])
 * @method int count()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Classe has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * @method bool exists()
 * @method \App\Models\Classe|null first($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Classe pourAnneeScolaire($anneeScolaireId)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe deNiveau($niveau)
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'niveau',
        'serie',
        'capacite',
        'annee_scolaire_id',
    ];

    /**
     * Relation avec l'année scolaire
     */
    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    /**
     * Relation avec les élèves via les inscriptions (RECOMMANDÉ)
     */
    public function eleves(): BelongsToMany
    {
        return $this->belongsToMany(Eleve::class, 'inscriptions', 'classe_id', 'eleve_id')
                    ->withPivot(['annee_scolaire_id', 'date_inscription', 'statut'])
                    ->withTimestamps();
    }

    /**
     * Relation directe avec les élèves (ANCIENNE MÉTHODE)
     * À GARDER TEMPORAIREMENT si certains élèves ont encore classe_id
     */
    public function elevesDirects(): HasMany
    {
        return $this->hasMany(Eleve::class, 'classe_id');
    }

    /**
     * Relation avec les inscriptions
     */
    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class, 'classe_id');
    }

    /**
     * Récupère les inscriptions actives de la classe
     */
    public function inscriptionsActives()
    {
        return $this->inscriptions()->whereIn('statut', ['inscrit', 'active', '1', 1, true]);
    }

    /**
     * Récupère les élèves actuellement inscrits dans cette classe
     */
    public function elevesActuels()
    {
        return $this->belongsToMany(Eleve::class, 'inscriptions', 'classe_id', 'eleve_id')
                    ->wherePivot('statut', true)
                    ->withPivot(['annee_scolaire_id', 'date_inscription'])
                    ->withTimestamps();
    }

    /**
     * Compte le nombre d'élèves actuellement inscrits
     */
    public function getNombreElevesActuelsAttribute(): int
    {
        return $this->inscriptions()->whereIn('statut', ['inscrit', 'active', '1', 1, true])->count();
    }

    /**
     * Vérifie si la classe a atteint sa capacité maximale
     */
    public function getEstPleineAttribute(): bool
    {
        return $this->nombre_eleves_actuels >= $this->capacite;
    }

    /**
     * Récupère le nombre de places disponibles
     */
    public function getPlacesDisponiblesAttribute(): int
    {
        return max(0, $this->capacite - $this->nombre_eleves_actuels);
    }

    /**
     * Taux d'occupation de la classe (pourcentage)
     */
    public function getTauxOccupationAttribute(): float
    {
        if ($this->capacite <= 0) {
            return 0;
        }
        return round(($this->nombre_eleves_actuels / $this->capacite) * 100, 2);
    }

    public function reinscriptions(): HasMany
    {
        return $this->hasMany(Reinscription::class);
    }

    public function matieres(): HasMany
    {
        return $this->hasMany(ClasseMatiere::class);
    }

    public function emploisDuTemps(): HasMany
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Relation avec les enseignants-matières (table pivot)
     */
    public function enseignantMatiereClasses(): HasMany
    {
        return $this->hasMany(EnseignantMatiereClasse::class);
    }

    /**
     * Relation avec les enseignants via la table pivot
     */
    public function enseignants(): BelongsToMany
    {
        return $this->belongsToMany(Enseignant::class, 'enseignant_matiere_classes')
                    ->withPivot('matiere_id', 'annee_scolaire_id')
                    ->withTimestamps();
    }

    /**
     * Relation avec les matières via la table pivot
     */
    public function matieresEnseignees(): BelongsToMany
    {
        return $this->belongsToMany(Matiere::class, 'enseignant_matiere_classes')
                    ->withPivot('enseignant_id', 'annee_scolaire_id')
                    ->withTimestamps();
    }

    /**
     * Scope pour filtrer les classes par année scolaire
     */
    public function scopePourAnneeScolaire($query, $anneeScolaireId)
    {
        return $query->where('annee_scolaire_id', $anneeScolaireId);
    }

    /**
     * Scope pour filtrer les classes par niveau
     */
    public function scopeDeNiveau($query, $niveau)
    {
        return $query->where('niveau', $niveau);
    }

    /**
     * Retourne le nom complet de la classe.
     * Le champ 'nom' contient déjà le nom complet (ex: "6ème A").
     * Cette propriété est conservée pour la compatibilité.
     */
    public function getNomCompletAttribute(): string
    {
        return $this->nom;
    }

    /**
     * Vérifie si la classe a des places disponibles
     */
    public function hasPlacesDisponibles(): bool
    {
        return $this->places_disponibles > 0;
    }

    /**
     * Récupère les statistiques complètes de la classe
     */
    public function getStatsAttribute(): array
    {
        $inscriptionsActives = $this->inscriptions()->whereIn('statut', ['inscrit', 'active', '1', 1, true])->count();
        
        return [
            'total_eleves' => $inscriptionsActives,
            'capacite' => $this->capacite,
            'places_disponibles' => $this->capacite - $inscriptionsActives,
            'taux_occupation' => $this->capacite > 0 
                ? round(($inscriptionsActives / $this->capacite) * 100, 2) 
                : 0,
            'matieres_count' => $this->matieres()->count(),
            'emplois_count' => $this->emploisDuTemps()->count(),
        ];
    }

    /**
     * Boot du modèle pour les événements
     */
    protected static function boot()
    {
        parent::boot();

        // Avant la suppression, vérifier s'il y a des inscriptions
        static::deleting(function ($classe) {
            if ($classe->inscriptions()->exists()) {
                throw new \Exception('Impossible de supprimer une classe qui a des inscriptions.');
            }
        });
    }
}