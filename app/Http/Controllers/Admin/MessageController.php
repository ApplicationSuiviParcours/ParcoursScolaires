<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Models\User;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->middleware(['auth', 'role:administrateur']);
        $this->notificationService = $notificationService;
    }

    /**
     * Interface principale d'envoi de messages / notifications
     */
    public function index()
    {
        $classes = Classe::orderBy('nom')->get();
        $users   = User::with('roles')
            ->where('is_active', true)
            ->whereHas('roles', fn($q) => $q->whereIn('name', ['parent', 'enseignant']))
            ->orderBy('name')
            ->get();

        // Stats rapides
        $stats = [
            'parents'      => User::role('parent')->where('is_active', true)->count(),
            'enseignants'  => User::role('enseignant')->where('is_active', true)->count(),
            'total_notifs' => \App\Models\Notification::count(),
            'non_lues'     => \App\Models\Notification::where('read', false)->count(),
        ];

        return view('admin.messages.index', compact('classes', 'users', 'stats'));
    }

    /**
     * Envoyer une notification / message
     */
    public function send(Request $request)
    {
        $request->validate([
            'destinataire' => 'required|in:tous_parents,tous_enseignants,classe,utilisateur',
            'titre'        => 'required|string|max:255',
            'message'      => 'required|string|max:1000',
            'type'         => 'required|in:info,success,warning,error',
            'classe_id'    => 'nullable|required_if:destinataire,classe|exists:classes,id',
            'user_id'      => 'nullable|required_if:destinataire,utilisateur|exists:users,id',
            'lien'         => 'nullable|url',
        ]);

        $count = 0;
        $titre   = $request->titre;
        $message = $request->message;
        $type    = $request->type;
        $lien    = $request->lien;

        switch ($request->destinataire) {
            case 'tous_parents':
                $count = $this->notificationService->notifierTousParents($titre, $message, $type, $lien);
                $dest  = 'tous les parents';
                break;

            case 'tous_enseignants':
                $count = $this->notificationService->notifierTousEnseignants($titre, $message, $type, $lien);
                $dest  = 'tous les enseignants';
                break;

            case 'classe':
                $classe = Classe::findOrFail($request->classe_id);
                $count  = $this->notificationService->notifierParentsDeClasse(
                    $classe->id, $titre, $message, $type, $lien
                );
                $dest = "les parents de la classe {$classe->nom}";
                break;

            case 'utilisateur':
                $user = User::findOrFail($request->user_id);
                $notif = $this->notificationService->envoyer($user, [
                    'type'    => $type,
                    'title'   => $titre,
                    'message' => $message,
                    'link'    => $lien,
                ]);
                $count = $notif ? 1 : 0;
                $dest  = $user->name;
                break;
        }

        if ($count > 0) {
            return back()->with('success', "✅ Notification envoyée à {$dest} ({$count} destinataire(s)).");
        }

        return back()->with('error', 'Aucun destinataire trouvé ou erreur lors de l\'envoi.');
    }

    /**
     * Historique de toutes les notifications envoyées
     */
    public function historique(Request $request)
    {
        $query = \App\Models\Notification::with('user')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('statut')) {
            $query->where('read', $request->statut === 'lu');
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $notifications = $query->paginate(20)->appends($request->query());

        return view('admin.messages.historique', compact('notifications'));
    }
}
