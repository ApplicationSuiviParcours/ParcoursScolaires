<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;

/**
 * @property int $id
 * @property int $eleve_id
 * @property int $classe_id
 * @property int $annee_scolaire_id
 * @property \Carbon\Carbon $date_reinscription
 * @property string $statut
 * @property string|null $observation
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Eleve $eleve
 * @property-read \App\Models\Classe $classe
 * @property-read \App\Models\AnneeScolaire $anneeScolaire
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Reinscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reinscription where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Reinscription whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Reinscription orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Reinscription with($relations)
 * @method static \App\Models\Reinscription|null find($id, $columns = ['*'])
 * @method static \App\Models\Reinscription findOrFail($id, $columns = ['*'])
 * @method static \App\Models\Reinscription create(array $attributes = [])
 * @method bool delete()
 * @method bool update(array $attributes = [], array $options = [])
 * @method int count()
 * @method static \Illuminate\Database\Eloquent\Builder|Reinscription whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Reinscription whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Reinscription has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * @method bool exists()
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class Reinscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'classe_id',
        'annee_scolaire_id',
        'date_reinscription',
        'statut',
        'observation',
        'est_redoublant',
    ];

    protected $casts = [
        'date_reinscription' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const STATUTS = [
        'en_attente' => 'En attente',
        'confirmee' => 'Confirmée',
        'annulee' => 'Annulée',
    ];

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    public function getStatutBadgeAttribute(): string
    {
        return match($this->statut) {
            'confirmee' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Confirmée</span>',
            'en_attente' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">En attente</span>',
            'annulee' => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Annulée</span>',
            default => '<span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Inconnu</span>',
        };
    }
}