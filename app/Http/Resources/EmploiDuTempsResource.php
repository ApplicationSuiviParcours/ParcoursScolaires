<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmploiDuTempsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'classe' => new ClasseResource($this->whenLoaded('classe')),
            'matiere' => new MatiereResource($this->whenLoaded('matiere')),
            'enseignant' => [
                'id' => $this->enseignant_id,
                'nom' => $this->enseignant?->nom ?? '',
                'prenom' => $this->enseignant?->prenom ?? '',
                'nom_complet' => $this->enseignant
                    ? trim(($this->enseignant->prenom ?? '') . ' ' . ($this->enseignant->nom ?? ''))
                    : '',
            ],
            'annee_scolaire' => new AnneeScolaireResource($this->whenLoaded('anneeScolaire')),
            'jour' => $this->jour, // 1=Lundi...7=Dimanche
            'jour_libelle' => $this->jour_libelle ?? $this->getJourLibelle(),
            'heure_debut' => $this->heure_debut instanceof \Carbon\Carbon ? $this->heure_debut->format('H:i') : substr($this->heure_debut, 0, 5),
            'heure_fin' => $this->heure_fin instanceof \Carbon\Carbon ? $this->heure_fin->format('H:i') : substr($this->heure_fin, 0, 5),
            'salle' => $this->salle,
            'duree' => $this->heure_fin instanceof \Carbon\Carbon && $this->heure_debut instanceof \Carbon\Carbon 
                ? $this->heure_fin->diffInMinutes($this->heure_debut) 
                : 0,
        ];
    }

    private function getJourLibelle(): string
    {
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        return $jours[$this->jour - 1] ?? 'Inconnu';
    }
}