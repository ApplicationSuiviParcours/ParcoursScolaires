<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\AnneeScolaire;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'matiere_id',
        'date_absence',
        'heure_debut',
        'heure_fin',
        'motif',
        'nombre_heures',
        'duree_jours',
        'observation',
        'justifiee',
        'annee_scolaire_id',
    ];

    protected $casts = [
        'date_absence' => 'date',
        'heure_debut' => 'string',
        'heure_fin' => 'string',
        'justifiee' => 'boolean',
        'duree_jours' => 'integer',
    ];

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }
}