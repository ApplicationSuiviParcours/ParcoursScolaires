<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Classe;  
use App\Models\AnneeScolaire;

/**
 * @property int $id
 * @property int $enseignant_id
 * @property int $matiere_id
 * @property int $classe_id
 * @property int $annee_scolaire_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Enseignant $enseignant
 * @property-read \App\Models\Matiere $matiere
 * @property-read \App\Models\Classe $classe
 * @property-read \App\Models\AnneeScolaire $anneeScolaire
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse with($relations)
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse orderBy($column, $direction = 'asc')
 * @method static \App\Models\EnseignantMatiereClasse|null find($id, $columns = ['*'])
 * @method static \App\Models\EnseignantMatiereClasse findOrFail($id, $columns = ['*'])
 * @method static \App\Models\EnseignantMatiereClasse create(array $attributes = [])
 * @method bool delete()
 * @method bool update(array $attributes = [], array $options = [])
 * @method int count()
 * @method bool exists()
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse distinct($column = null)
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse select($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|EnseignantMatiereClasse groupBy(...$groups)
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class EnseignantMatiereClasse extends Model
{
    use HasFactory;

    protected $table = 'enseignant_matiere_classe';

    protected $fillable = [
        'enseignant_id',
        'matiere_id',
        'classe_id',
        'annee_scolaire_id',
    ];

    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }
}
