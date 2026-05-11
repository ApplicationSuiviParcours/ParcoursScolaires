<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'date_absence' => $this->date_absence,
            'heure_debut'  => $this->heure_debut ? (is_string($this->heure_debut) ? substr(explode(' ', $this->heure_debut)[1] ?? $this->heure_debut, 0, 5) : $this->heure_debut->format('H:i')) : null,
            'heure_fin'    => $this->heure_fin ? (is_string($this->heure_fin) ? substr(explode(' ', $this->heure_fin)[1] ?? $this->heure_fin, 0, 5) : $this->heure_fin->format('H:i')) : null,
            'justifiee'    => (bool) $this->justifiee,
            'motif'        => $this->motif ?? $this->commentaire ?? null,
            'matiere'      => $this->when(
                $this->relationLoaded('matiere'),
                fn() => new MatiereResource($this->matiere)
            ),
            'eleve'        => $this->when(
                $this->relationLoaded('eleve'),
                fn() => [
                    'id'     => $this->eleve->id,
                    'nom'    => $this->eleve->nom,
                    'prenom' => $this->eleve->prenom,
                ]
            ),
        ];
    }
}