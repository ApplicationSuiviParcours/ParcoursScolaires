<?php

namespace App\Exports;

use App\Models\EleveParent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EleveParentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $filters;
    
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = EleveParent::with(['eleve.inscriptions.classe', 'parentEleve']);
        
        // Appliquer les filtres si nécessaire
        if (!empty($this->filters)) {
            if (isset($this->filters['classe_id']) && $this->filters['classe_id']) {
                $query->whereHas('eleve', function($q) {
                    $q->whereHas('inscriptions', function($inscriptionQuery) {
                        $inscriptionQuery->where('classe_id', $this->filters['classe_id'])
                                        ->where('statut', true);
                    });
                });
            }
            
            if (isset($this->filters['lien_parental']) && $this->filters['lien_parental']) {
                $query->where('lien_parental', $this->filters['lien_parental']);
            }
        }
        
        return $query->get();
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID',
            'MATRICULE ÉLÈVE',
            'NOM ÉLÈVE',
            'PRÉNOM ÉLÈVE',
            'CLASSE ACTUELLE',
            'NIVEAU',
            'STATUT INSCRIPTION',
            'NOM PARENT',
            'PRÉNOM PARENT',
            'LIEN PARENTAL',
            'TÉLÉPHONE PARENT',
            'EMAIL PARENT',
            'PROFESSION PARENT',
            'DATE CRÉATION',
        ];
    }

    /**
    * @param mixed $relation
    * @return array
    */
    public function map($relation): array
    {
        // Récupérer la classe actuelle via l'accesseur
        $classeActuelle = $relation->eleve->classe_actuelle;
        
        return [
            $relation->id,
            $relation->eleve->matricule ?? 'N/A',
            strtoupper($relation->eleve->nom ?? ''),
            ucfirst($relation->eleve->prenom ?? ''),
            $classeActuelle ? $classeActuelle->nom : 'Non inscrit',
            $classeActuelle ? ($classeActuelle->niveau ?? 'N/A') : 'N/A',
            $relation->eleve->est_inscrit ? 'Inscrit' : 'Non inscrit',
            strtoupper($relation->parentEleve->nom ?? ''),
            ucfirst($relation->parentEleve->prenom ?? ''),
            $this->formatLienParental($relation->lien_parental),
            $relation->parentEleve->telephone ?? 'N/A',
            $relation->parentEleve->email ?? 'N/A',
            $relation->parentEleve->profession ?? 'N/A',
            $relation->created_at ? $relation->created_at->format('d/m/Y H:i') : 'N/A',
        ];
    }

    /**
    * @return string
    */
    public function title(): string
    {
        return 'Relations Élèves-Parents';
    }

    /**
    * @param Worksheet $sheet
    * @return array
    */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style pour la première ligne (en-têtes)
            1 => ['font' => ['bold' => true, 'size' => 12]],
            
            // Style pour toutes les cellules
            'A1:N1000' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }

    /**
    * Formater le lien parental
    */
    private function formatLienParental($lien)
    {
        $liens = [
            'pere' => 'Père',
            'mere' => 'Mère',
            'tuteur' => 'Tuteur légal',
            'grand_parent' => 'Grand-parent',
            'oncle' => 'Oncle',
            'tante' => 'Tante',
            'frere' => 'Frère',
            'soeur' => 'Soeur',
            'autre' => 'Autre',
        ];

        return $liens[$lien] ?? ucfirst($lien);
    }

    /**
    * @return array
    */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                // Ajuster automatiquement la largeur des colonnes
                foreach (range('A', 'N') as $column) {
                    $sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
                
                // Couleur de fond pour les en-têtes
                $sheet->getDelegate()->getStyle('A1:N1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF4CAF50');
                
                // Texte blanc pour les en-têtes
                $sheet->getDelegate()->getStyle('A1:N1')
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFFFF');
            },
        ];
    }

    /**
    * Export avec filtres (méthode utilitaire)
    */
    public static function exportWithFilters($filters = [])
    {
        return new self($filters);
    }
}