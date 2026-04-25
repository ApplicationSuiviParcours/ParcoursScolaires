<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class UpdateLastLoginOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        try {
            /** @var \App\Models\User $user */
            $user = $event->user;
            
            $user->update([
                'last_login_at' => now()
            ]);
            
            Log::info('Dernière connexion mise à jour pour : ' . $user->email);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de la dernière connexion : ' . $e->getMessage());
        }
    }
}