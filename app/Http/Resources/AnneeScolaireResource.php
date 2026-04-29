<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnneeScolaireResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'libelle' => $this->nom, // Pour la compatibilité
            'date_debut' => $this->date_debut,
            'date_fin' => $this->date_fin,
            'active' => $this->active,
        ];
    }
}