<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use App\Models\Note;
use App\Models\Enseignant;

/**
 * @property int $id
 * @property int $enseignant_id
 * @property int $classe_id
 * @property int $matiere_id
 * @property int $annee_scolaire_id
 * @property string $type
 * @property string $nom
 * @property string|null $description
 * @property \Carbon\Carbon $date_evaluation
 * @property float $coefficient
 * @property float $bareme
 * @property string $periode
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read string $date_formatted
 * 
 * @property-read \App\Models\Enseignant $enseignant
 * @property-read \App\Models\Classe $classe
 * @property-read \App\Models\Matiere $matiere
 * @property-read \App\Models\AnneeScolaire $anneeScolaire
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Note[] $notes
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation orderBy($column, $direction = 'asc')
 * @method static \App\Models\Evaluation|null find($id, $columns = ['*'])
 * @method static \App\Models\Evaluation findOrFail($id, $columns = ['*'])
 * @method static \App\Models\Evaluation create(array $attributes = [])
 * @method bool delete()
 * @method bool update(array $attributes = [], array $options = [])
 * @method int count()
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereDate(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereMonth(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation whereYear(string $column, $value, string $boolean = 'and')
 * @method bool exists()
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation forEnseignant($enseignantId)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation forPeriode($periode)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation forClasse($classeId)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation forMatiere($matiereId)
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation upcoming()
 * @method static \Illuminate\Database\Eloquent\Builder|Evaluation past()
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'enseignant_id',
        'classe_id',
        'matiere_id',
        'annee_scolaire_id',
        'type',
        'nom',
        'description',
        'date_evaluation',
        'coefficient',
        'bareme',
        'periode',
    ];

    protected $casts = [
        'date_evaluation' => 'date',
        'bareme' => 'float',
        'coefficient' => 'float',
    ];

    /**
     * Alias pour satisfaire la demande de casting du champ 'date'
     */
    public function getDateAttribute()
    {
        return $this->date_evaluation;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date_evaluation'] = $value;
    }

    /**
     * Accesseur pour le statut de l'évaluation
     */
    public function getStatutAttribute(): string
    {
        return $this->date_evaluation->isFuture() ? 'À venir' : 'Passée';
    }

    /**
     * Relation avec l'enseignant qui a créé l'évaluation
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }


    public function getDateFormattedAttribute()
    {
        return $this->date_evaluation ? $this->date_evaluation->format('d/m/Y') : 'Date non définie';
    }

    /**
     * Scope pour filtrer les évaluations par enseignant
     */
    public function scopeForEnseignant($query, $enseignantId)
    {
        return $query->where('enseignant_id', $enseignantId);
    }

    /**
     * Scope pour filtrer les évaluations par période
     */
    public function scopeForPeriode($query, $periode)
    {
        return $query->where('periode', $periode);
    }

    /**
     * Scope pour filtrer les évaluations par classe
     */
    public function scopeForClasse($query, $classeId)
    {
        return $query->where('classe_id', $classeId);
    }

    /**
     * Scope pour filtrer les évaluations par matière
     */
    public function scopeForMatiere($query, $matiereId)
    {
        return $query->where('matiere_id', $matiereId);
    }

    /**
     * Scope pour les évaluations à venir
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date_evaluation', '>=', today());
    }

    /**
     * Scope pour les évaluations passées
     */
    public function scopePast($query)
    {
        return $query->where('date_evaluation', '<', today());
    }

    /**
     * Vérifie si l'évaluation a des notes saisies
     */
    public function hasNotes(): bool
    {
        return $this->notes()->exists();
    }

    /**
     * Calcule la moyenne des notes pour cette évaluation
     * Corrigé pour utiliser la bonne colonne (note au lieu de valeur)
     */
    public function moyenne(): ?float
    {
        // Vérifier d'abord le nom de la colonne dans votre table notes
        // Si c'est 'note' au lieu de 'valeur'
        return $this->notes()->avg('note'); // Changé de 'valeur' à 'note'
    }

    /**
     * Calcule le taux de réussite (nombre de notes >= 10)
     * Corrigé pour utiliser la bonne colonne
     */
    public function tauxReussite(): float
    {
        $totalNotes = $this->notes()->count();
        if ($totalNotes === 0) {
            return 0;
        }

        // Vérifier d'abord le nom de la colonne dans votre table notes
        $notesReussites = $this->notes()->where('note', '>=', 10)->count(); // Changé de 'valeur' à 'note'
        return ($notesReussites / $totalNotes) * 100;
    }

    /**
     * Types d'évaluation autorisés pour les administrateurs
     */
    public static function getTypesForAdmin(): array
    {
        return [
            'devoir' => 'Devoir',
            'examen' => 'Examen',
            'test' => 'Test',
            'projet' => 'Projet',
            'autre' => 'Autre',
        ];
    }

    /**
     * Types d'évaluation autorisés pour les enseignants
     */
    public static function getTypesForEnseignant(): array
    {
        return [
            'devoir' => 'Devoir',
            'examen' => 'Examen',
            'interrogation' => 'Interrogation',
            'projet' => 'Projet',
        ];
    }

    /**
     * Couleurs Tailwind associées à chaque type d'évaluation (pour les badges)
     */
    public static function getTypeColors(): array
    {
        return [
            'devoir' => 'from-blue-100 to-blue-200 bg-blue-100 text-blue-800',
            'examen' => 'from-red-100 to-red-200 bg-red-100 text-red-800',
            'test' => 'from-green-100 to-green-200 bg-green-100 text-green-800',
            'interrogation' => 'from-yellow-100 to-yellow-200 bg-yellow-100 text-yellow-800',
            'projet' => 'from-purple-100 to-purple-200 bg-purple-100 text-purple-800',
            'autre' => 'from-gray-100 to-gray-200 bg-gray-100 text-gray-800',
        ];
    }

    /**
     * Émojis associés à chaque type d'évaluation (pour l'affichage esthétique)
     */
    public static function getTypeEmojis(): array
    {
        return [
            'devoir' => '📝',
            'examen' => '📋',
            'test' => '✏️',
            'interrogation' => '❓',
            'projet' => '🎯',
            'autre' => '🔖',
        ];
    }
}
