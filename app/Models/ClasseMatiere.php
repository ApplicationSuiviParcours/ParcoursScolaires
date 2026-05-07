<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Classe;
use App\Models\Matiere;

/**
 * @property int $id
 * @property int $classe_id
 * @property int $matiere_id
 * @property float $coefficient
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Classe $classe
 * @property-read \App\Models\Matiere $matiere
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ClasseMatiere query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClasseMatiere where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|ClasseMatiere whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|ClasseMatiere whereNotIn(string $column, $values, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|ClasseMatiere whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|ClasseMatiere whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|ClasseMatiere with($relations)
 * @method static \Illuminate\Database\Eloquent\Builder|ClasseMatiere orderBy($column, $direction = 'asc')
 * @method static \App\Models\ClasseMatiere|null find($id, $columns = ['*'])
 * @method static \App\Models\ClasseMatiere findOrFail($id, $columns = ['*'])
 * @method static \App\Models\ClasseMatiere create(array $attributes = [])
 * @method bool delete()
 * @method bool update(array $attributes = [], array $options = [])
 * @method int count()
 * @method bool exists()
 * @method float avg($column)
 * @method float sum($column)
 * @method mixed max($column)
 * @method mixed min($column)
 * @method \Illuminate\Support\Collection pluck($column, $key = null)
 * @method static \Illuminate\Database\Eloquent\Builder|ClasseMatiere has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class ClasseMatiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'classe_id',
        'matiere_id',
        'coefficient',
    ];

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }
}
