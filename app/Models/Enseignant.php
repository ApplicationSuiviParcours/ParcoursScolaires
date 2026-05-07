<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\EnseignantMatiereClasse;
use App\Models\Evaluation;
use App\Models\Classe;
use App\Models\Matiere;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $matricule
 * @property string $nom
 * @property string $prenom
 * @property string $genre
 * @property \Carbon\Carbon|null $date_naissance
 * @property string|null $lieu_naissance
 * @property string|null $telephone
 * @property string|null $email
 * @property string|null $adresse
 * @property string|null $specialite
 * @property string|null $photo
 * @property bool $statut
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read string $nom_complet
 * @property-read int|null $age
 * @property-read string $photo_url
 * @property-read int $nombre_classes
 * @property-read int $nombre_matieres
 * 
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EnseignantMatiereClasse[] $enseignantMatiereClasses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Classe[] $classes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Matiere[] $matieres
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Evaluation[] $evaluations
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant whereDate(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant whereMonth(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant whereYear(string $column, $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant whereIn(string $column, $values, string $boolean = 'and', bool $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \App\Models\Enseignant|null find($id, $columns = ['*'])
 * @method static \App\Models\Enseignant findOrFail($id, $columns = ['*'])
 * @method static \App\Models\Enseignant|null first($columns = ['*'])
 * @method static \App\Models\Enseignant firstOrFail($columns = ['*'])
 * @method static \App\Models\Enseignant create(array $attributes = [])
 * @method bool delete()
 * @method bool update(array $attributes = [], array $options = [])
 * @method int count()
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant whereNull($column, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant whereNotNull($column, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant has($relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
 * @method bool exists()
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant actifs()
 * @method static \Illuminate\Database\Eloquent\Builder|Enseignant deSpecialite($specialite)
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'matricule',
        'nom',
        'prenom',
        'genre',
        'date_naissance',
        'lieu_naissance',
        'telephone',
        'email',
        'adresse',
        'specialite',
        'photo',
        'statut',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'statut' => 'boolean',
    ];

    protected $appends = [
        'nom_complet',
        'age',
        'photo_url',
    ];

    /**
     * Relation avec l'utilisateur associé
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec les matières et classes
     */
    public function enseignantMatiereClasses(): HasMany
    {
        return $this->hasMany(EnseignantMatiereClasse::class);
    }

    /**
     * Alias pour la relation
     */
    public function matiereClasses(): HasMany
    {
        return $this->enseignantMatiereClasses();
    }

    /**
     * Récupérer les classes enseignées par cet enseignant
     */
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'enseignant_matiere_classes', 'enseignant_id', 'classe_id')
                    ->withPivot('matiere_id', 'annee_scolaire_id')
                    ->withTimestamps();
    }

    /**
     * Récupérer les matières enseignées par cet enseignant
     */
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'enseignant_matiere_classes', 'enseignant_id', 'matiere_id')
                    ->withPivot('classe_id', 'annee_scolaire_id')
                    ->withTimestamps();
    }

    /**
     * Relation avec les évaluations créées par cet enseignant
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * ✅ AJOUT: Accesseur pour le nom complet
     */
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * ✅ AJOUT: Accesseur pour l'âge
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_naissance?->age;
    }

    /**
     * ✅ AJOUT: Accesseur pour le nombre de classes enseignées
     */
    public function getNombreClassesAttribute(): int
    {
        return $this->enseignantMatiereClasses()
            ->distinct('classe_id')
            ->count('classe_id');
    }

    /**
     * ✅ AJOUT: Accesseur pour le nombre de matières enseignées
     */
    public function getNombreMatieresAttribute(): int
    {
        return $this->enseignantMatiereClasses()
            ->distinct('matiere_id')
            ->count('matiere_id');
    }

    /**
     * ✅ AJOUT: Scope pour filtrer les enseignants actifs
     */
    public function scopeActifs($query)
    {
        return $query->whereIn('statut', ['inscrit', 'active', '1', 1, true]);
    }

    /**
     * ✅ AJOUT: Scope pour filtrer par spécialité
     */
    public function scopeDeSpecialite($query, $specialite)
    {
        return $query->where('specialite', $specialite);
    }

    /**
     * ✅ AJOUT: Générer un matricule unique
     */
    public static function genererMatricule($nom)
    {
        $annee = date('Y');
        $premiereLettre = strtoupper(substr($nom, 0, 1));
        
        $dernier = self::whereYear('created_at', $annee)
                       ->orderBy('id', 'desc')
                       ->first();
        
        if ($dernier && $dernier->matricule) {
            $dernierNumero = intval(substr($dernier->matricule, -4));
            $nouveauNumero = str_pad($dernierNumero + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nouveauNumero = '0001';
        }
        
        return 'ENS' . $annee . $premiereLettre . $nouveauNumero;
    }

    /**
     * ✅ AJOUT: Récupère l'URL complète de la photo
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }

        // Avatar par défaut avec les initiales
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nom_complet) .
               '&color=7F9CF5&background=EBF4FF&bold=true&size=128&length=2';
    }
}