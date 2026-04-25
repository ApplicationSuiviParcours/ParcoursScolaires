<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClasseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'nom_complet' => $this->nom_complet,
            'niveau' => $this->niveau,
            'serie' => $this->serie,
        ];
    }
}