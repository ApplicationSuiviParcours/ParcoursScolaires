<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnneeScolaire;
use Carbon\Carbon;

class AnneeScolaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyer la table avant d'insérer (optionnel)
        // AnneeScolaire::truncate();

        // Désactiver toutes les années scolaires existantes si nécessaire
        // AnneeScolaire::query()->update(['active' => false]);

        $anneesScolaires = [
            [
                'nom' => '2022-2023',
                'date_debut' => '2022-09-01',
                'date_fin' => '2023-08-31',
                'active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => '2023-2024',
                'date_debut' => '2023-09-01',
                'date_fin' => '2024-08-31',
                'active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => '2024-2025',
                'date_debut' => '2024-09-01',
                'date_fin' => '2025-08-31',
                'active' => true, // L'année en cours
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => '2025-2026',
                'date_debut' => '2025-09-01',
                'date_fin' => '2026-08-31',
                'active' => false, // Année future
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insérer les années scolaires
        foreach ($anneesScolaires as $annee) {
            AnneeScolaire::create($annee);
        }

        $this->command->info('Années scolaires créées avec succès !');
        $this->command->info('Année active : 2024-2025');
    }

    /**
     * Méthode alternative pour créer des années scolaires de façon dynamique
     */
    public function createDynamicYears(): void
    {
        $currentYear = Carbon::now()->year;
        $startMonth = 9; // Septembre
        $endMonth = 8; // Août

        // Créer les 3 dernières années et les 2 prochaines années
        for ($i = -3; $i <= 2; $i++) {
            $yearStart = $currentYear + $i;
            $yearEnd = $yearStart + 1;
            
            // Déterminer si c'est l'année en cours
            $isActive = ($i === 0);
            
            AnneeScolaire::create([
                'nom' => $yearStart . '-' . $yearEnd,
                'date_debut' => Carbon::create($yearStart, $startMonth, 1)->format('Y-m-d'),
                'date_fin' => Carbon::create($yearEnd, $endMonth, 31)->format('Y-m-d'),
                'active' => $isActive,
            ]);
        }
    }

    /**
     * Méthode pour créer une seule année scolaire spécifique
     */
    public function createSpecificYear(string $nom, string $dateDebut, string $dateFin, bool $active = false): void
    {
        AnneeScolaire::create([
            'nom' => $nom,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'active' => $active,
        ]);
    }

    /**
     * Méthode pour définir une année comme active et désactiver les autres
     */
    public function setActiveYear(int $anneeId): void
    {
        // Désactiver toutes les années
        AnneeScolaire::query()->update(['active' => false]);
        
        // Activer l'année spécifiée
        AnneeScolaire::where('id', $anneeId)->update(['active' => true]);
        
        $this->command->info("L'année scolaire ID {$anneeId} est maintenant active");
    }
}