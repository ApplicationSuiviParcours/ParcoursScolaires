<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EleveResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'matricule' => $this->matricule,
            'nom_complet' => $this->nom_complet,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'photo' => $this->photo_url,
            'classe_actuelle' => $this->whenLoaded('classe_actuelle', $this->classe_actuelle?->only(['id', 'nom_complet'])),
            'est_inscrit' => $this->est_inscrit,
            'age' => $this->age,
            'stats' => $this->when(isset($this->stats), $this->stats),
            'historique_classes' => $this->when(isset($this->historique_classes), $this->historique_classes),
        ];
    }
}