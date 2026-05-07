<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\AnneeScolaire;

/**
 * @property int $id
 * @property int $eleve_id
 * @property int|null $matiere_id
 * @property \Carbon\Carbon $date_absence
 * @property \Carbon\Carbon|null $heure_debut
 * @property \Carbon\Carbon|null $heure_fin
 * @property string|null $motif
 * @property string|null $motif_justification
 * @property string|null $justificatif_path
 * @property int|null $nombre_heures
 * @property int|null $duree_jours
 * @property string|null $observation
 * @property bool $justifiee
 * @property int|null $annee_scolaire_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Eleve $eleve
 * @property-read \App\Models\Matiere|null $matiere
 * @property-read \App\Models\AnneeScolaire|null $anneeScolaire
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Absence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereDate(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereMonth(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereYear(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Absence orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \App\Models\Absence|null find($id, $columns = ['*'])
 * @method static \App\Models\Absence findOrFail($id, $columns = ['*'])
 * @method static \App\Models\Absence|null first($columns = ['*'])
 * @method static \App\Models\Absence firstOrFail($columns = ['*'])
 * @method static \App\Models\Absence create(array $attributes = [])
 * @method bool delete()
 * @method bool update(array $attributes = [], array $options = [])
 * @method int count()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Absence has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * @method bool exists()
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'matiere_id',
        'date_absence',
        'heure_debut',
        'heure_fin',
        'motif',
        'motif_justification',
        'justificatif_path',
        'nombre_heures',
        'duree_jours',
        'observation',
        'justifiee',
        'annee_scolaire_id',
    ];

    protected $casts = [
        'date_absence' => 'datetime',
        'heure_debut' => 'datetime',
        'heure_fin' => 'datetime',
        'justifiee' => 'boolean',
        'duree_jours' => 'integer',
    ];

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }
}