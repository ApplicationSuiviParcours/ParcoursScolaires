<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EnseignantMatiereClasse;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Classe;
use App\Models\AnneeScolaire;

class EnseignantMatiereClasseSeeder extends Seeder
{
    public function run(): void
    {
        $annee = AnneeScolaire::where('active', true)->first();
        if (!$annee) {
            $annee = AnneeScolaire::first();
        }

        $classeTest = Classe::where('nom', 'CE1 A')->first();
        if (!$classeTest) {
            $this->command->error('❌ La classe test CE1 A n\'existe pas.');
            return;
        }

        $this->command->info('🔄 Affectation des enseignants aux matières pour la classe CE1 A...');

        // Récupérer les enseignants
        $ndinga = Enseignant::where('email', 'ndinga@enseignant.cg')->first();
        $bidimbe = Enseignant::where('email', 'bidimbe@enseignant.cg')->first();
        $kimbonda = Enseignant::where('email', 'kimbonda@enseignant.cg')->first();
        $loubaki = Enseignant::where('email', 'loubaki@enseignant.cg')->first();
        $pemba = Enseignant::where('email', 'pemba@enseignant.cg')->first();

        // Récupérer les matières
        $matieres = Matiere::all();

        // Table de répartition : Enseignant => [noms de matières]
        $repartition = [
            'ndinga@enseignant.cg' => ['Mathématiques', 'Technologie'],
            'bidimbe@enseignant.cg' => ['Français', 'Anglais'],
            'kimbonda@enseignant.cg' => ['Sciences (SVT)', 'Physique-Chimie'],
            'loubaki@enseignant.cg' => ['Histoire-Géographie', 'Musique'],
            'pemba@enseignant.cg' => ['Éducation Physique (EPS)', 'Arts Plastiques'],
        ];

        $created = 0;
        foreach ($repartition as $email => $nomsMatieres) {
            $enseignant = Enseignant::where('email', $email)->first();
            if (!$enseignant) continue;

            foreach ($nomsMatieres as $nomMatiere) {
                $matiere = $matieres->firstWhere('nom', $nomMatiere);
                if (!$matiere) continue;

                // Associer la matière à la classe si ce n'est pas déjà fait
                \App\Models\ClasseMatiere::firstOrCreate(
                    [
                        'classe_id' => $classeTest->id,
                        'matiere_id' => $matiere->id,
                    ],
                    [
                        'coefficient' => $matiere->coefficient ?? 1,
                    ]
                );

                // Créer l'affectation enseignant-matiere-classe
                EnseignantMatiereClasse::updateOrCreate(
                    [
                        'enseignant_id' => $enseignant->id,
                        'matiere_id' => $matiere->id,
                        'classe_id' => $classeTest->id,
                    ],
                    ['annee_scolaire_id' => $annee->id]
                );

                $created++;
                $this->command->line("✅ {$enseignant->prenom} {$enseignant->nom} enseigne {$matiere->nom} en {$classeTest->nom}");
            }
        }

        $this->command->info("✅ {$created} affectations d'enseignants créées !");
    }
}