<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Enseignant;
use App\Models\AnneeScolaire;

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
