<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        // Safely load relations-based counts
        $notesLoaded = $this->relationLoaded('notes');
        $notesCollection = $notesLoaded ? $this->notes : collect([]);

        return [
            'id'              => $this->id,
            'nom'             => $this->nom,
            'date_evaluation' => $this->date_evaluation,
            'periode'         => $this->periode,
            'coefficient'     => $this->coefficient,
            'description'     => $this->description,
            'matiere_classe'  => $this->when($this->relationLoaded('matiereClasse'), function () {
                return [
                    'id'            => $this->matiereClasse->id,
                    'enseignant_id' => $this->matiereClasse->enseignant_id,
                    'classe'        => $this->when(
                        $this->matiereClasse->relationLoaded('classe'),
                        fn() => new ClasseResource($this->matiereClasse->classe)
                    ),
                    'matiere'       => $this->when(
                        $this->matiereClasse->relationLoaded('matiere'),
                        fn() => new MatiereResource($this->matiereClasse->matiere)
                    ),
                ];
            }),
            'notes_count'     => $notesCollection->count(),
            'notes_avg'       => round($notesCollection->avg('note') ?? 0, 2),
            'notes'           => $this->when($notesLoaded, fn() => NoteResource::collection($notesCollection)),
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}