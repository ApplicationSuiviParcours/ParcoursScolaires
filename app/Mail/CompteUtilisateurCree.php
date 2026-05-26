<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompteUtilisateurCree extends Mailable
{
    use Queueable, SerializesModels;

    public string $nomComplet;
    public string $email;
    public string $motDePasse;
    public string $role;
    public string $matricule;

    /**
     * @param string $nomComplet   Prénom + Nom de l'utilisateur
     * @param string $email        Email de connexion
     * @param string $motDePasse   Mot de passe en clair (avant hashage)
     * @param string $role         eleve | enseignant | parent
     * @param string $matricule    Matricule de l'utilisateur
     */
    public function __construct(
        string $nomComplet,
        string $email,
        string $motDePasse,
        string $role,
        string $matricule
    ) {
        $this->nomComplet  = $nomComplet;
        $this->email       = $email;
        $this->motDePasse  = $motDePasse;
        $this->role        = $role;
        $this->matricule   = $matricule;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre compte Scolaire Parcours a été créé',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.compte-utilisateur-cree',
        );
    }
}
