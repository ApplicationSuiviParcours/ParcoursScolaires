<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'note'        => $this->note,
            'appreciation'=> !empty($this->observation) ? $this->observation : $this->appreciation_auto,
            'observation' => $this->observation,
            'evaluation'  => $this->when($this->relationLoaded('evaluation'), function () {
                return [
                    'id'              => $this->evaluation->id,
                    'nom'             => $this->evaluation->nom,
                    'date_evaluation' => $this->evaluation->date_evaluation,
                    'coefficient'     => $this->evaluation->coefficient,
                    'matiere'         => $this->when(
                        $this->evaluation->relationLoaded('matiere'),
                        fn() => new MatiereResource($this->evaluation->matiere)
                    ),
                ];
            }),
            'eleve'       => $this->when($this->relationLoaded('eleve'), function () {
                return [
                    'id'        => $this->eleve->id,
                    'nom'       => $this->eleve->nom,
                    'prenom'    => $this->eleve->prenom,
                    'matricule' => $this->eleve->matricule,
                ];
            }),
            'created_at'  => $this->created_at,
        ];
    }
}