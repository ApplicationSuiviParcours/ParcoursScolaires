{{-- resources/views/admin/eleve_parents/exports/single-pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fiche de relation</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4e73df;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4e73df;
            margin: 0;
            font-size: 28px;
        }
        .header .date {
            color: #666;
            font-size: 12px;
            margin-top: 5px;
        }
        .card {
            background: #f8f9fc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #4e73df;
        }
        .card h2 {
            color: #4e73df;
            margin: 0 0 15px 0;
            font-size: 18px;
        }
        .info-row {
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px dashed #e3e6f0;
        }
        .info-label {
            font-weight: bold;
            color: #666;
            width: 150px;
            display: inline-block;
        }
        .info-value {
            color: #333;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        .badge-primary {
            background: #4e73df;
            color: white;
        }
        .badge-danger {
            background: #e74a3b;
            color: white;
        }
        .badge-info {
            background: #36b9cc;
            color: white;
        }
        .signature {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 2px solid #e3e6f0;
        }
        .signature-line {
            display: inline-block;
            width: 200px;
            border-bottom: 1px solid #333;
            margin: 0 20px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Fiche de relation</h1>
            <div class="date">N° {{ $eleveParent->id }} - Créée le {{ $eleveParent->created_at->format('d/m/Y') }}</div>
        </div>

        <!-- Informations de l'élève -->
        <div class="card">
            <h2>👤 Informations de l'élève</h2>
            <div class="info-row">
                <span class="info-label">Nom complet :</span>
                <span class="info-value">{{ $eleveParent->eleve->prenom }} {{ $eleveParent->eleve->nom }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Classe :</span>
                <span class="info-value">{{ $eleveParent->eleve->classe->nom ?? 'Non assignée' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Date de naissance :</span>
                <span class="info-value">{{ $eleveParent->eleve->date_naissance ?? 'Non renseignée' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Matricule :</span>
                <span class="info-value">{{ $eleveParent->eleve->matricule ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Informations du parent -->
        <div class="card">
            <h2>👪 Informations du parent</h2>
            <div class="info-row">
                <span class="info-label">Nom complet :</span>
                <span class="info-value">{{ $eleveParent->parentEleve->prenom }} {{ $eleveParent->parentEleve->nom }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Lien parental :</span>
                <span class="info-value">
                    <span class="badge badge-{{ $eleveParent->lien_parental == 'Père' ? 'primary' : ($eleveParent->lien_parental == 'Mère' ? 'danger' : 'info') }}">
                        {{ $eleveParent->lien_parental }}
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Email :</span>
                <span class="info-value">{{ $eleveParent->parentEleve->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Téléphone :</span>
                <span class="info-value">{{ $eleveParent->parentEleve->telephone ?? 'Non renseigné' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Adresse :</span>
                <span class="info-value">{{ $eleveParent->parentEleve->adresse ?? 'Non renseignée' }}</span>
            </div>
        </div>

        <!-- Informations supplémentaires -->
        @if($eleveParent->notes)
        <div class="card">
            <h2>📝 Notes</h2>
            <p>{{ $eleveParent->notes }}</p>
        </div>
        @endif

        <!-- Signature -->
        <div class="signature">
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: center;">
                        <div class="signature-line"></div>
                        <p>Signature du parent</p>
                    </td>
                    <td style="text-align: center;">
                        <div class="signature-line"></div>
                        <p>Signature de l'administration</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Document officiel - {{ config('app.name') }}</p>
            <p>Imprimé le {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>