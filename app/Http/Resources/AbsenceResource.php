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