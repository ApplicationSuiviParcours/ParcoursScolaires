<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BulletinResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'periode'          => $this->periode,
            'date_bulletin'    => $this->date_bulletin,
            'moyenne_generale' => $this->moyenne_generale,
            'moyenne_classe'   => $this->moyenne_classe ?? 0,
            'ecart_classe'     => $this->ecart_classe,
            'appreciation'     => $this->appreciation,
            'rang'             => $this->rang ?? null,
            'classe'           => $this->when(
                $this->relationLoaded('classe'),
                fn() => new ClasseResource($this->classe)
            ),
            'annee_scolaire'   => $this->when(
                $this->relationLoaded('anneeScolaire'),
                fn() => new AnneeScolaireResource($this->anneeScolaire)
            ),
            // Notes chargées manuellement via DB::table (pas une relation Eloquent)
            'notes'            => $this->notes_manuelles ?? $this->whenLoaded('notesBulletin'),
        ];
    }
}