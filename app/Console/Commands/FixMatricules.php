<?php
// app/Console/Commands/FixMatricules.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Eleve;

class FixMatricules extends Command
{
    protected $signature = 'fix:matricules';
    protected $description = 'Corrige les matricules des élèves au format Année+Lettre+Numéro';

    public function handle()
    {
        $eleves = Eleve::all();
        $count = 0;

        foreach ($eleves as $eleve) {
            $matricule = $eleve->matricule;
            
            // Si le matricule a 8 caractères (sans lettre)
            if (strlen($matricule) === 8 && preg_match('/^\d{8}$/', $matricule)) {
                $annee = substr($matricule, 0, 4);
                $numero = substr($matricule, -4);
                $premiereLettre = strtoupper(substr($eleve->nom, 0, 1));
                
                $nouveauMatricule = $annee . $premiereLettre . $numero;
                
                // Vérifier l'unicité
                $tentatives = 0;
                while (Eleve::where('matricule', $nouveauMatricule)->where('id', '!=', $eleve->id)->exists() && $tentatives < 26) {
                    // Si le matricule existe déjà, essayer une autre lettre
                    $lettres = range('A', 'Z');
                    $lettreIndex = array_search($premiereLettre, $lettres) + $tentatives + 1;
                    $premiereLettre = $lettres[$lettreIndex % 26] ?? 'X';
                    $nouveauMatricule = $annee . $premiereLettre . $numero;
                    $tentatives++;
                }
                
                $eleve->matricule = $nouveauMatricule;
                $eleve->save();
                
                $this->info("Corrigé: {$matricule} -> {$nouveauMatricule}");
                $count++;
            }
        }

        $this->info("{$count} matricules corrigés avec succès.");
    }
}