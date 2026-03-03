<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use App\Models\Note;
use App\Models\Enseignant;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'enseignant_id',
        'classe_id',
        'matiere_id',
        'annee_scolaire_id',
        'type',
        'nom',
        'description',
        'date_evaluation',
        'coefficient',
        'bareme',
        'periode',
    ];

    protected $casts = [
        'date_evaluation' => 'date',
        'bareme' => 'float',
    ];

    /**
     * Relation avec l'enseignant qui a créé l'évaluation
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

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

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }


    public function getDateFormattedAttribute()
{
    return $this->date ? $this->date->format('d/m/Y') : 'Date non définie';
}

    /**
     * Scope pour filtrer les évaluations par enseignant
     */
    public function scopeForEnseignant($query, $enseignantId)
    {
        return $query->where('enseignant_id', $enseignantId);
    }

    /**
     * Scope pour filtrer les évaluations par période
     */
    public function scopeForPeriode($query, $periode)
    {
        return $query->where('periode', $periode);
    }

    /**
     * Scope pour filtrer les évaluations par classe
     */
    public function scopeForClasse($query, $classeId)
    {
        return $query->where('classe_id', $classeId);
    }

    /**
     * Scope pour filtrer les évaluations par matière
     */
    public function scopeForMatiere($query, $matiereId)
    {
        return $query->where('matiere_id', $matiereId);
    }

    /**
     * Scope pour les évaluations à venir
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date_evaluation', '>=', now());
    }

    /**
     * Scope pour les évaluations passées
     */
    public function scopePast($query)
    {
        return $query->where('date_evaluation', '<', now());
    }

    /**
     * Vérifie si l'évaluation a des notes saisies
     */
    public function hasNotes(): bool
    {
        return $this->notes()->exists();
    }

    /**
     * Calcule la moyenne des notes pour cette évaluation
     * Corrigé pour utiliser la bonne colonne (note au lieu de valeur)
     */
    public function moyenne(): ?float
    {
        // Vérifier d'abord le nom de la colonne dans votre table notes
        // Si c'est 'note' au lieu de 'valeur'
        return $this->notes()->avg('note'); // Changé de 'valeur' à 'note'
    }

    /**
     * Calcule le taux de réussite (nombre de notes >= 10)
     * Corrigé pour utiliser la bonne colonne
     */
    public function tauxReussite(): float
    {
        $totalNotes = $this->notes()->count();
        if ($totalNotes === 0) {
            return 0;
        }

        // Vérifier d'abord le nom de la colonne dans votre table notes
        $notesReussites = $this->notes()->where('note', '>=', 10)->count(); // Changé de 'valeur' à 'note'
        return ($notesReussites / $totalNotes) * 100;
    }
}
