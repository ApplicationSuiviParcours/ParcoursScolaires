<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
            $statutsActifs = ['inscrit', 'active', '1', 1, true];
            
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
