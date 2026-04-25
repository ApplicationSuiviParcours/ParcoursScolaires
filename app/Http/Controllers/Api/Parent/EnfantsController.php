<?php

namespace App\Http\Controllers\Api\Parent;

use App\Http\Controllers\Controller;
use App\Http\Resources\EleveResource;
use App\Models\ParentEleve;
use App\Models\Eleve;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class EnfantsController extends Controller
{
    /**
     * List all enfants for authenticated parent.
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user || !$user->isParent()) {
            abort(403, 'Accès réservé aux parents.');
        }

        $parentEleve = ParentEleve::query()->whereHas('user', fn($q) => $q->where('id', $user->id))->first();
        if (!$parentEleve) {
            return EleveResource::collection(collect([]));
        }

        $enfants = $parentEleve->eleves()
            ->with(['classe', 'inscriptionActive.classe.anneeScolaire'])
            ->orderBy('nom', 'asc')
            ->paginate(20);

        // Add quick stats per enfant
        $enfants->getCollection()->transform(function ($eleve) {
            $eleve->setAttribute('quick_stats', [
                'moyenne' => round($eleve->notes()->avg('note') ?? 0, 2),
                'absences' => $eleve->absences()->count(),
                'bulletins' => $eleve->bulletins()->count(),
            ]);
            return $eleve;
        });

        $enfants->additional([
            'stats' => [
                'total_enfants' => $enfants->total(),
            ]
        ]);

        return EleveResource::collection($enfants);
    }
}