<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EleveResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'classe_id' => $this->classe_id,
            'matricule' => $this->matricule,
            'nom_complet' => $this->nom_complet,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'photo' => $this->photo_url,
            'inscription_active' => $this->inscriptionActive ? [
                'id' => $this->inscriptionActive->id,
                'classe' => [
                    'id' => $this->inscriptionActive->classe?->id,
                    'nom' => $this->inscriptionActive->classe?->nom,
                    'nom_complet' => $this->inscriptionActive->classe?->nom_complet,
                ],
                'annee_scolaire' => [
                    'id' => $this->inscriptionActive->anneeScolaire?->id,
                    'nom' => $this->inscriptionActive->anneeScolaire?->libelle,
                ],
            ] : null,
            'classe_actuelle' => $this->classe_actuelle ? [
                'id' => $this->classe_actuelle->id,
                'nom' => $this->classe_actuelle->nom,
                'nom_complet' => $this->classe_actuelle->nom_complet,
            ] : null,
            'est_inscrit' => $this->est_inscrit,
            'age' => $this->age,
            'stats' => $this->quick_stats ?? ($this->stats ?? null),
            'historique_classes' => $this->when(isset($this->historique_classes), $this->historique_classes),
        ];
    }
}