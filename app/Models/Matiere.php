<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ClasseMatiere;
use App\Models\Evaluation;
use App\Models\Absence;
use App\Models\EmploiDuTemps;
use App\Models\EnseignantMatiereClasse;

/**
 * @property int $id
 * @property string $nom
 * @property string|null $code
 * @property string|null $description
 * @property float $coefficient
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ClasseMatiere[] $classeMatieres
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Evaluation[] $evaluations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Absence[] $absences
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EmploiDuTemps[] $emploiDuTemps
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EnseignantMatiereClasse[] $enseignantMatiereClasses
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere query()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere create(array $attributes = [])
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class Matiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'code',
        'description',
        'coefficient',
    ];

    public function classeMatieres(): HasMany
    {
        return $this->hasMany(ClasseMatiere::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function emploiDuTemps(): HasMany
    {
        return $this->hasMany(EmploiDuTemps::class);
    }

    public function enseignantMatiereClasses(): HasMany
    {
        return $this->hasMany(EnseignantMatiereClasse::class);
    }
}
