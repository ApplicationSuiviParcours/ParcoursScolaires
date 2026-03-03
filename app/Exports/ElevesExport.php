<?php
// app/Exports/ElevesExport.php

namespace App\Exports;

use App\Models\Eleve;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ElevesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Eleve::query();

        // Appliquer les filtres
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        if ($this->request->filled('statut')) {
            $query->where('statut', $this->request->statut);
        }

        if ($this->request->filled('genre')) {
            $query->where('genre', $this->request->genre);
        }

        if ($this->request->filled('classe_id')) {
            $query->whereHas('inscriptions', function($q) {
                $q->where('classe_id', $this->request->classe_id)
                  ->where('statut', true);
            });
        }

        return $query->orderBy('nom')->orderBy('prenom')->get();
    }

    public function headings(): array
    {
        return ['N°', 'Matricule', 'Nom', 'Prénom', 'Classe', 'Statut'];
    }

    public function map($eleve): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $eleve->matricule,
            $eleve->nom,
            $eleve->prenom,
            $eleve->classe_actuelle?->nom ?? 'Non assigné',
            $eleve->statut ? 'Actif' : 'Inactif',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        return [];
    }

    public function title(): string
    {
        return 'Élèves';
    }
}
