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
            'classe'          => new ClasseResource($this->whenLoaded('classe')),
            'matiere'         => new MatiereResource($this->whenLoaded('matiere')),
            'enseignant'      => $this->when($this->relationLoaded('enseignant'), function() {
                return [
                    'id' => $this->enseignant->id,
                    'nom_complet' => $this->enseignant->nom_complet,
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