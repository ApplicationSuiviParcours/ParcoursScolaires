<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $eleve_id
 * @property int $classe_id
 * @property int $annee_scolaire_id
 * @property \Carbon\Carbon $date_inscription
 * @property string $statut
 * @property string|null $observation
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Eleve $eleve
 * @property-read \App\Models\Classe $classe
 * @property-read \App\Models\AnneeScolaire $anneeScolaire
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Inscription query()
 * 
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Eloquent
 */
class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'classe_id',
        'annee_scolaire_id',
        'date_inscription',
        'statut',
        'observation',
    ];

    // 🔹 Ajout du cast pour que date_inscription soit un objet Carbon
    protected $casts = [
        'date_inscription' => 'datetime',
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

    /**
     * ✅ AJOUT: Synchronise la classe_id dans la table eleves 
     * pour assurer la compatibilité et la performance.
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($inscription) {
            // Liste des statuts considérés comme "actifs"
            $statutsActifs = ['inscrit', 'active', '1'];
            
            if ($inscription->eleve && in_array($inscription->statut, $statutsActifs, false)) {
                $inscription->eleve->update(['classe_id' => $inscription->classe_id]);
            }
        });

        static::deleted(function ($inscription) {
            $eleve = $inscription->eleve;
            if ($eleve) {
                $latest = $eleve->inscriptions()
                                ->whereIn('statut', ['inscrit', 'active', '1'])
                                ->latest()
                                ->first();
                $eleve->update(['classe_id' => $latest?->classe_id]);
            }
        });
    }
}
