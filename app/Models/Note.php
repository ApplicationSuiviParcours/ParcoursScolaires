<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Eleve;
use App\Models\Evaluation;
use App\Models\Bulletin;

/**
 * @property int $id
 * @property int $eleve_id
 * @property int $evaluation_id
 * @property float $note
 * @property string|null $observation
 * @property int|null $bulletin_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read bool $est_reussite
 * @property-read string $couleur
 * @property-read string $appreciation_auto
 * @property-read \App\Models\Matiere|null $matiere
 * @property-read string $matiere_nom
 * @property-read float $coefficient
 * @property-read \Carbon\Carbon|null $date_evaluation
 * @property-read string $type_evaluation
 * @property-read bool $est_dans_bulletin
 * 
 * @property-read \App\Models\Eleve $eleve
 * @property-read \App\Models\Evaluation $evaluation
 * @property-read \App\Models\Bulletin|null $bulletin
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bulletin[] $bulletins
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|Note where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Note orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Note with($relations)
 * @method static \Illuminate\Database\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \App\Models\Note|null find($id, $columns = ['*'])
 * @method static \App\Models\Note findOrFail($id, $columns = ['*'])
 * @method static \App\Models\Note|null first($columns = ['*'])
 * @method static \App\Models\Note firstOrFail($columns = ['*'])
 * @method static \App\Models\Note create(array $attributes = [])
 * @method bool delete()
 * @method bool update(array $attributes = [], array $options = [])
 * @method int count()
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Note has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * @method bool exists()
 * @method static \Illuminate\Database\Eloquent\Builder|Note forEleve($eleveId)
 * @method static \Illuminate\Database\Eloquent\Builder|Note forMatiere($matiereId)
 * @method static \Illuminate\Database\Eloquent\Builder|Note forPeriode($periode)
 * @method static \Illuminate\Database\Eloquent\Builder|Note recentes($limit = 10)
 * @method static \Illuminate\Database\Eloquent\Builder|Note reussites()
 * @method static \Illuminate\Database\Eloquent\Builder|Note echecs()
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'evaluation_id',
        'note',
        'observation',
        'bulletin_id', // Ajouté si vous utilisez la relation directe
    ];

    protected $casts = [
        'note' => 'float',
    ];

    /**
     * Relation avec l'élève
     */
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    /**
     * Relation avec l'évaluation
     */
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluation::class);
    }

    /**
     * Relation directe avec le bulletin (si vous avez bulletin_id dans notes)
     */
    public function bulletin(): BelongsTo
    {
        return $this->belongsTo(Bulletin::class);
    }

    /**
     * Relation many-to-many avec les bulletins via table pivot (si vous utilisez bulletin_note)
     */
    public function bulletins(): BelongsToMany
    {
        return $this->belongsToMany(Bulletin::class, 'bulletin_note')
                    ->withPivot('coefficient', 'appreciation', 'rang_matiere')
                    ->withTimestamps();
    }

    /**
     * Vérifier si la note est une réussite (>= 10)
     */
    public function getEstReussiteAttribute(): bool
    {
        return $this->note >= 10;
    }

    /**
     * Obtenir la couleur associée à la note
     */
    public function getCouleurAttribute(): string
    {
        if ($this->note >= 16) {
            return 'green';
        } elseif ($this->note >= 14) {
            return 'blue';
        } elseif ($this->note >= 10) {
            return 'yellow';
        } else {
            return 'red';
        }
    }

    /**
     * Obtenir l'appréciation en fonction de la note
     */
    public function getAppreciationAutoAttribute(): string
    {
        if ($this->note >= 18) {
            return 'Excellent';
        } elseif ($this->note >= 16) {
            return 'Très bien';
        } elseif ($this->note >= 14) {
            return 'Bien';
        } elseif ($this->note >= 12) {
            return 'Assez bien';
        } elseif ($this->note >= 10) {
            return 'Passable';
        } elseif ($this->note >= 8) {
            return 'Insuffisant';
        } elseif ($this->note >= 5) {
            return 'Faible';
        } else {
            return 'Très faible';
        }
    }

    /**
     * Scope pour filtrer les notes par élève
     */
    public function scopeForEleve($query, $eleveId)
    {
        return $query->where('eleve_id', $eleveId);
    }

    /**
     * Scope pour filtrer les notes par matière
     */
    public function scopeForMatiere($query, $matiereId)
    {
        return $query->whereHas('evaluation', function($q) use ($matiereId) {
            $q->where('matiere_id', $matiereId);
        });
    }

    /**
     * Scope pour filtrer les notes par période
     */
    public function scopeForPeriode($query, $periode)
    {
        return $query->whereHas('evaluation', function($q) use ($periode) {
            $q->where('periode', $periode);
        });
    }

    /**
     * Scope pour les notes récentes
     */
    public function scopeRecentes($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Scope pour les notes de réussite (>= 10)
     */
    public function scopeReussites($query)
    {
        return $query->where('note', '>=', 10);
    }

    /**
     * Scope pour les notes d'échec (< 10)
     */
    public function scopeEchecs($query)
    {
        return $query->where('note', '<', 10);
    }

    /**
     * Calculer la moyenne des notes de la collection
     */
    public static function moyenne($notes)
    {
        return $notes->avg('note');
    }

    /**
     * Obtenir la matière associée via l'évaluation
     */
    public function getMatiereAttribute()
    {
        return $this->evaluation->matiere ?? null;
    }

    /**
     * Obtenir le nom de la matière
     */
    public function getMatiereNomAttribute(): string
    {
        return $this->evaluation->matiere->nom ?? 'Matière inconnue';
    }

    /**
     * Obtenir le coefficient de l'évaluation
     */
    public function getCoefficientAttribute(): float
    {
        return $this->evaluation->coefficient ?? 1;
    }

    /**
     * Obtenir la date de l'évaluation
     */
    public function getDateEvaluationAttribute()
    {
        return $this->evaluation->date_evaluation ?? null;
    }

    /**
     * Obtenir le type d'évaluation
     */
    public function getTypeEvaluationAttribute(): string
    {
        return $this->evaluation->type ?? 'Évaluation';
    }

    /**
     * Vérifier si la note est utilisée dans un bulletin
     */
    public function getEstDansBulletinAttribute(): bool
    {
        // Si vous utilisez la relation directe
        if ($this->bulletin_id) {
            return true;
        }
        
        // Si vous utilisez la relation many-to-many
        return $this->bulletins()->exists();
    }
}