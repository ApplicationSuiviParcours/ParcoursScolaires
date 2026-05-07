<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignant;
use App\Models\AnneeScolaire;

/**
 * @property int $id
 * @property int $classe_id
 * @property int $matiere_id
 * @property int $enseignant_id
 * @property int $annee_scolaire_id
 * @property int $jour
 * @property string $heure_debut
 * @property string $heure_fin
 * @property string|null $salle
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Classe $classe
 * @property-read \App\Models\Matiere $matiere
 * @property-read \App\Models\Enseignant $enseignant
 * @property-read \App\Models\AnneeScolaire $anneeScolaire
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|EmploiDuTemps query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmploiDuTemps where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|EmploiDuTemps whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|EmploiDuTemps orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|EmploiDuTemps with($relations)
 * @method static \Illuminate\Database\Eloquent\Collection|static[] get($columns = ['*'])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \App\Models\EmploiDuTemps|null find($id, $columns = ['*'])
 * @method static \App\Models\EmploiDuTemps findOrFail($id, $columns = ['*'])
 * @method static \App\Models\EmploiDuTemps|null first($columns = ['*'])
 * @method static \App\Models\EmploiDuTemps firstOrFail($columns = ['*'])
 * @method static \App\Models\EmploiDuTemps create(array $attributes = [])
 * @method bool delete()
 * @method bool update(array $attributes = [], array $options = [])
 * @method int count()
 * @method bool exists()
 * @method static \Illuminate\Database\Eloquent\Builder|EmploiDuTemps has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class EmploiDuTemps extends Model
{
    use HasFactory;

    protected $fillable = [
        'classe_id',
        'matiere_id',
        'enseignant_id', // <-- ajouter ici
        'annee_scolaire_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'salle',
    ];

    protected $casts = [
        'jour' => 'integer',
        // On retire les casts datetime car ils ajoutent la date du jour (2026-...) 
        // ce qui casse les substr(0,5) dans les vues et l'app mobile
        'heure_debut' => 'string',
        'heure_fin' => 'string',
    ];

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

    // **Relation avec l'enseignant**
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
}
