<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Evaluation;
use App\Models\EmploiDuTemps;

/**
 * @property int $id
 * @property string $nom
 * @property \Carbon\Carbon $date_debut
 * @property \Carbon\Carbon $date_fin
 * @property bool $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read string $display_name
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Classe[] $classes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inscription[] $inscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Evaluation[] $evaluations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EmploiDuTemps[] $emploiDuTemps
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire whereDate(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire whereMonth(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire whereYear(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire latest($column = null)
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire with($relations)
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \App\Models\AnneeScolaire|null find($id, $columns = ['*'])
 * @method static \App\Models\AnneeScolaire findOrFail($id, $columns = ['*'])
 * @method static \App\Models\AnneeScolaire|null first($columns = ['*'])
 * @method static \App\Models\AnneeScolaire firstOrFail($columns = ['*'])
 * @method static \App\Models\AnneeScolaire create(array $attributes = [])
 * @method bool delete()
 * @method bool update(array $attributes = [], array $options = [])
 * @method int count()
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * @method bool exists()
 * @method static \Illuminate\Database\Eloquent\Builder|AnneeScolaire active()
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class AnneeScolaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin',
        'active',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'active' => 'boolean',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function emploiDuTemps(): HasMany
    {
        return $this->hasMany(EmploiDuTemps::class);
    }


     /**
     * Scope pour récupérer l'année active
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Accesseur pour l'affichage
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->nom . ($this->active ? ' (En cours)' : '');
    }

    /**
     * Vérifie si une date est dans cette année scolaire
     */
    public function containsDate($date): bool
    {
        $date = \Carbon\Carbon::parse($date);
        return $date->between($this->date_debut, $this->date_fin);
    }
}
