# ============================================================
# Script : Uniformisation des boutons d'actions admin
# Transforme les petites icones transparentes en pills colores
# ============================================================

$adminPath = "c:\xampp\htdocs\ScolairesParcours\scolaire-parcour\resources\views\admin"

# Fichiers ayant encore l'ancien style
$targets = @(
    "absences\index.blade.php",
    "annee_scolaires\index.blade.php",
    "bulletins\index.blade.php",
    "classes\index.blade.php",
    "classe_matieres\index.blade.php",
    "eleve_parents\index.blade.php",
    "eleves\index.blade.php",
    "enseignant_matiere_classes\index.blade.php",
    "inscriptions\index.blade.php",
    "matieres\index.blade.php",
    "parents\index.blade.php",
    "reinscriptions\index.blade.php"
)

$updated = 0
$skipped = 0

foreach ($rel in $targets) {
    $path = Join-Path $adminPath $rel
    if (-not (Test-Path $path)) {
        Write-Host "  [SKIP - fichier introuvable] $rel" -ForegroundColor Yellow
        $skipped++
        continue
    }

    $content = Get-Content $path -Raw -Encoding UTF8

    # Verifier si le fichier n'est pas deja mis a jour
    if ($content -notmatch 'p-1\.5 md:p-2 text-blue-600 bg-transparent') {
        Write-Host "  [DEJA A JOUR] $rel" -ForegroundColor Cyan
        $skipped++
        continue
    }

    # ----------------------------------------------------------
    # 1. Wrapper div des actions
    # ----------------------------------------------------------
    $content = $content -replace `
        'class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap"', `
        'class="flex items-center justify-end gap-1.5 flex-wrap"'

    # ----------------------------------------------------------
    # 2. Bouton VOIR (bleu)
    # ----------------------------------------------------------
    $content = $content -replace `
        'class="p-1\.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none"', `
        'class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-xs font-semibold transition-all duration-200 hover:shadow-sm"'

    # ----------------------------------------------------------
    # 3. Bouton MODIFIER (ambre)
    # ----------------------------------------------------------
    $content = $content -replace `
        'class="p-1\.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none"', `
        'class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-100 text-amber-700 hover:bg-amber-200 rounded-lg text-xs font-semibold transition-all duration-200 hover:shadow-sm"'

    # ----------------------------------------------------------
    # 4. Bouton SUPPRIMER - lien rouge (sans flex)
    # ----------------------------------------------------------
    $content = $content -replace `
        'class="p-1\.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none"(?!\s*flex)', `
        'class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-xs font-semibold transition-all duration-200 hover:shadow-sm"'

    # ----------------------------------------------------------
    # 5. Bouton SUPPRIMER - bouton rouge avec flex cursor
    # ----------------------------------------------------------
    $content = $content -replace `
        'class="p-1\.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer"', `
        'class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg text-xs font-semibold transition-all duration-200 hover:shadow-sm cursor-pointer border-none"'

    # ----------------------------------------------------------
    # 6. Bouton EMERALD (Justifier, Dupliquer)
    # ----------------------------------------------------------
    $content = $content -replace `
        'class="p-1\.5 md:p-2 text-emerald-600 bg-transparent hover:bg-emerald-50 rounded-lg transition-colors border-none cursor-pointer"', `
        'class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg text-xs font-semibold transition-all duration-200 hover:shadow-sm cursor-pointer border-none"'

    # Emerald sans cursor-pointer
    $content = $content -replace `
        'class="p-1\.5 md:p-2 text-emerald-600 bg-transparent hover:bg-emerald-50 rounded-lg transition-colors border-none"', `
        'class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg text-xs font-semibold transition-all duration-200 hover:shadow-sm"'

    # ----------------------------------------------------------
    # 7. Bouton VERT (green)
    # ----------------------------------------------------------
    $content = $content -replace `
        'class="p-1\.5 md:p-2 text-green-600 bg-transparent hover:bg-green-50 rounded-lg transition-colors border-none"', `
        'class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg text-xs font-semibold transition-all duration-200 hover:shadow-sm"'

    # ----------------------------------------------------------
    # 8. Bouton VIOLET (purple)
    # ----------------------------------------------------------
    $content = $content -replace `
        'class="p-1\.5 md:p-2 text-purple-600 bg-transparent hover:bg-purple-50 rounded-lg transition-colors border-none"', `
        'class="inline-flex items-center gap-1 px-3 py-1.5 bg-purple-100 text-purple-700 hover:bg-purple-200 rounded-lg text-xs font-semibold transition-all duration-200 hover:shadow-sm"'

    # ----------------------------------------------------------
    # 9. Taille des icones SVG dans les actions
    # ----------------------------------------------------------
    # Remplacement dans le contexte des actions (apres les nouvelles classes)
    # On cible uniquement les SVG dans les divs d'actions en reconnaissant le pattern inline-flex
    $content = [regex]::Replace(
        $content,
        '(inline-flex items-center gap-1 px-3 py-1\.5 (?:bg-\w+-100|bg-red-100)[^"]*"[^>]*>[\s\S]*?)<svg class="w-4 h-4 md:w-5 md:h-5"',
        { param($m) $m.Value -replace '<svg class="w-4 h-4 md:w-5 md:h-5"', '<svg class="w-3.5 h-3.5"' },
        [System.Text.RegularExpressions.RegexOptions]::None
    )

    # Remplacement global des tailles restantes dans les wrappers d'actions
    # On remplace toutes les occurrences dans le bloc d'actions (entre gap-1.5 flex-wrap et /div)
    $content = [regex]::Replace(
        $content,
        '(?s)(flex items-center justify-end gap-1\.5 flex-wrap">(.*?)(?=</div>))',
        { param($m) ($m.Value -replace 'class="w-4 h-4 md:w-5 md:h-5"', 'class="w-3.5 h-3.5"') },
        [System.Text.RegularExpressions.RegexOptions]::None
    )

    # ----------------------------------------------------------
    # 10. Ajout des labels texte apres les SVG (par title)
    # ----------------------------------------------------------
    $labels = @{
        'Voir'      = 'Voir'
        'Modifier'  = 'Modifier'
        'Supprimer' = 'Supprimer'
        'Justifier' = 'Justifier'
        'Exporter'  = 'Exporter'
        'Dupliquer' = 'Dupliquer'
        'Activer'   = 'Activer'
        'Photo'     = 'Photo'
    }

    foreach ($title in $labels.Keys) {
        $label = $labels[$title]
        # Recherche : title="X" suivi du SVG, sans deja avoir le label texte apres </svg>
        $pattern = '(?s)(title="' + [regex]::Escape($title) + '"[^>]*>)(\s*<svg[^>]*>.*?</svg>)(?!\s*' + [regex]::Escape($label) + ')'
        $replacement = '$1$2' + "`r`n                                        $label"
        $content = [regex]::Replace($content, $pattern, $replacement, [System.Text.RegularExpressions.RegexOptions]::Singleline)
    }

    # Sauvegarde
    [System.IO.File]::WriteAllText($path, $content, [System.Text.Encoding]::UTF8)
    Write-Host "  [OK] $rel" -ForegroundColor Green
    $updated++
}

Write-Host ""
Write-Host "============================================"
Write-Host "  Termine : $updated fichier(s) mis a jour, $skipped ignore(s)"
Write-Host "============================================"
