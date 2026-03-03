<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\AnneeScolaire;
use App\Models\Note;

class Bulletin extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'classe_id',
        'annee_scolaire_id',
        'periode',
        'moyenne_generale',
        'rang',
        'effectif_classe',
        'appreciation',
        'date_bulletin',
    ];

    protected $casts = [
        'moyenne_generale' => 'float',
        'rang' => 'integer',
        'effectif_classe' => 'integer',
        'date_bulletin' => 'date',
    ];

    /**
     * Relation avec l'élève
     */
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    /**
     * Relation avec la classe
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Relation avec l'année scolaire
     */
    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    /**
     * Relation avec les notes du bulletin (via clé étrangère bulletin_id dans notes)
     * À utiliser si vous avez ajouté bulletin_id à la table notes
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'bulletin_id');
    }

    /**
     * Relation many-to-many avec les notes via table pivot (RECOMMANDÉ)
     * À utiliser si vous avez créé la table pivot bulletin_note
     */
    public function notesBulletin(): BelongsToMany
{
    return $this->belongsToMany(Note::class, 'bulletin_note')
                ->withPivot('coefficient', 'appreciation') // Retiré 'rang_matiere'
                ->withTimestamps();
}

    /**
     * Calculer la moyenne générale à partir des notes
     */
    public function calculerMoyenneGenerale(): float
    {
        $total = 0;
        $coefficientTotal = 0;
        
        foreach ($this->notesBulletin as $note) {
            $coefficient = $note->pivot->coefficient ?? 1;
            $total += $note->note * $coefficient;
            $coefficientTotal += $coefficient;
        }
        
        return $coefficientTotal > 0 ? round($total / $coefficientTotal, 2) : 0;
    }

    /**
     * Obtenir les moyennes par matière
     */
    public function getMoyennesParMatiereAttribute()
    {
        $moyennes = [];
        
        foreach ($this->notesBulletin->groupBy('evaluation.matiere_id') as $matiereId => $notes) {
            $total = 0;
            $coeffTotal = 0;
            $matiere = $notes->first()->evaluation->matiere;
            
            foreach ($notes as $note) {
                $coeff = $note->pivot->coefficient ?? 1;
                $total += $note->note * $coeff;
                $coeffTotal += $coeff;
            }
            
            $moyennes[$matiereId] = [
                'matiere' => $matiere,
                'moyenne' => $coeffTotal > 0 ? round($total / $coeffTotal, 2) : 0,
                'nombre_notes' => $notes->count(),
                'coefficient_total' => $coeffTotal,
            ];
        }
        
        return $moyennes;
    }

    /**
     * Déterminer la mention en fonction de la moyenne
     */
    public function getMentionAttribute(): string
    {
        if ($this->moyenne_generale >= 16) {
            return 'Très bien';
        } elseif ($this->moyenne_generale >= 14) {
            return 'Bien';
        } elseif ($this->moyenne_generale >= 12) {
            return 'Assez bien';
        } elseif ($this->moyenne_generale >= 10) {
            return 'Passable';
        } else {
            return 'Insuffisant';
        }
    }

    /**
     * Vérifier si l'élève est admis
     */
    public function getEstAdmisAttribute(): bool
    {
        return $this->moyenne_generale >= 10;
    }

    /**
     * Scope pour filtrer par période
     */
    public function scopeForPeriode($query, $periode)
    {
        return $query->where('periode', $periode);
    }

    /**
     * Scope pour filtrer par année scolaire
     */
    public function scopeForAnneeScolaire($query, $anneeScolaireId)
    {
        return $query->where('annee_scolaire_id', $anneeScolaireId);
    }

    /**
     * Scope pour les bulletins récents
     */
    public function scopeRecents($query, $limit = 5)
    {
        return $query->orderBy('date_bulletin', 'desc')->limit($limit);
    }
}