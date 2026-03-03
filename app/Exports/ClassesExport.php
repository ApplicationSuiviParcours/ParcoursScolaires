<?php
// app/Exports/ClassesExport.php

namespace App\Exports;

use App\Models\Classe;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClassesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Classe::with('anneeScolaire')->withCount('eleves');
        
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('niveau', 'like', "%{$search}%")
                  ->orWhere('serie', 'like', "%{$search}%");
            });
        }
        
        if ($this->request->filled('niveau')) {
            $query->where('niveau', $this->request->niveau);
        }
        
        if ($this->request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $this->request->annee_scolaire_id);
        }
        
        return $query->orderBy('niveau')->orderBy('nom')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Niveau',
            'Nom',
            'Série',
            'Capacité',
            'Élèves',
            'Année Scolaire',
        ];
    }

    public function map($classe): array
    {
        return [
            $classe->id,
            $classe->niveau,
            $classe->nom,
            $classe->serie ?? '-',
            $classe->capacite,
            $classe->eleves_count,
            $classe->anneeScolaire->nom ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}