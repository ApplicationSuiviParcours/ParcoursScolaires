@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Parcours Scolaire de mon enfant') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('parent.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-teal-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        <a href="{{ route('parent.enfants') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-teal-600 md:ml-2">Mes Enfants</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Parcours de {{ $eleve->nom_complet }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- ══════════════════════════════════════════════════
             EN-TÊTE
        ══════════════════════════════════════════════════ --}}
        <div class="relative mb-8 overflow-hidden bg-white shadow-2xl rounded-3xl">
            <div class="absolute inset-0 bg-blue-900 opacity-90"></div>
            <div class="absolute inset-0 opacity-10">
                <div class="absolute bg-white rounded-full w-96 h-96 -top-48 -right-48 blur-3xl"></div>
            </div>
            <div class="relative p-8 md:p-12">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="flex items-center justify-center w-28 h-28 bg-white rounded-2xl shadow-xl overflow-hidden border-4 border-white/30 flex-shrink-0">
                        @if($eleve->photo)
                            <img src="{{ asset('storage/' . $eleve->photo) }}" alt="{{ $eleve->nom_complet }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl font-bold text-teal-600">{{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="text-center md:text-left text-white">
                        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight">{{ $eleve->nom_complet }}</h1>
                        <p class="text-lg text-teal-100 mt-2 font-medium">Matricule : <span class="font-bold">{{ $eleve->matricule }}</span></p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-6">
                            <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                                <span class="text-xs text-teal-200 block uppercase tracking-wider">Moyenne Globale</span>
                                <span class="text-xl font-bold">{{ $statsParcours['moyenne_globale'] ? number_format($statsParcours['moyenne_globale'], 2) : '--' }}/20</span>
                            </div>
                            <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                                <span class="text-xs text-teal-200 block uppercase tracking-wider">Années de scolarité</span>
                                <span class="text-xl font-bold">{{ $statsParcours['nombre_annees'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════
             GRAPHIQUE D'ÉVOLUTION (Chart.js)
        ══════════════════════════════════════════════════ --}}
        @php
            $anneeLabels = [];
            $moyennesT1  = [];
            $moyennesT2  = [];
            $moyennesT3  = [];
            foreach ($historique->reverse() as $item) {
                $bAnnee = $eleve->bulletins->where('annee_scolaire_id', $item['annee_scolaire']->id);
                $anneeLabels[] = $item['annee_scolaire']->nom;
                $bT1 = $bAnnee->firstWhere('periode', 'Trimestre 1');
                $bT2 = $bAnnee->firstWhere('periode', 'Trimestre 2');
                $bT3 = $bAnnee->firstWhere('periode', 'Trimestre 3');
                $moyennesT1[] = $bT1 ? round($bT1->moyenne_generale, 2) : null;
                $moyennesT2[] = $bT2 ? round($bT2->moyenne_generale, 2) : null;
                $moyennesT3[] = $bT3 ? round($bT3->moyenne_generale, 2) : null;
            }
        @endphp

        @if($historique->count() > 0)
        <div class="mb-8 bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
                <div class="p-2 bg-teal-100 rounded-xl">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Évolution des moyennes de {{ $eleve->prenom }}</h3>
                    <p class="text-xs text-gray-500">Progression par trimestre sur toutes les années scolaires</p>
                </div>
            </div>
            <div class="p-6">
                <div style="position:relative; height:280px;">
                    <canvas id="evolutionChart"></canvas>
                </div>
                <div class="flex flex-wrap gap-5 mt-4 justify-center text-xs font-semibold text-gray-600">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-teal-500 inline-block"></span> Trimestre 1</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span> Trimestre 2</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-cyan-500 inline-block"></span> Trimestre 3</span>
                    <span class="flex items-center gap-1.5"><span class="w-8 border-t-2 border-dashed border-gray-400 inline-block"></span> Seuil d'admission (10/20)</span>
                </div>
            </div>
        </div>
        @endif

        {{-- ══════════════════════════════════════════════════
             TIMELINE DU PARCOURS
        ══════════════════════════════════════════════════ --}}
        <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Historique de scolarité — année par année
                </h3>
                <div class="flex gap-2">
                    <a href="{{ route('parent.enfant.notes', $eleve->id) }}" class="px-4 py-2 text-sm font-semibold text-teal-600 bg-teal-50 rounded-xl hover:bg-teal-100 transition-colors">Notes</a>
                    <a href="{{ route('parent.enfant.bulletin', $eleve->id) }}" class="px-4 py-2 text-sm font-semibold text-teal-600 bg-teal-50 rounded-xl hover:bg-teal-100 transition-colors">Bulletins</a>
                </div>
            </div>

            <div class="p-8">
                @if($historique->count() > 0)
                    <div class="relative">
                        <div class="absolute left-4 md:left-1/2 transform md:-translate-x-1/2 top-0 bottom-0 w-1 bg-blue-900 rounded-full opacity-20"></div>

                        <div class="space-y-12">
                            @foreach($historique as $index => $item)
                                @php
                                    $bulletinsAnnee = $eleve->bulletins->where('annee_scolaire_id', $item['annee_scolaire']->id);
                                    $bulletinT1     = $bulletinsAnnee->firstWhere('periode', 'Trimestre 1');
                                    $bulletinT2     = $bulletinsAnnee->firstWhere('periode', 'Trimestre 2');
                                    $bulletinT3     = $bulletinsAnnee->firstWhere('periode', 'Trimestre 3');
                                    $moyenneAnnee   = $bulletinsAnnee->isNotEmpty() ? round($bulletinsAnnee->avg('moyenne_generale'), 2) : null;
                                    $meilleurRang   = $bulletinsAnnee->whereNotNull('rang')->min('rang');
                                    $estRedoublant  = $item['est_redoublant'] ?? false;

                                    $obsContientOriente = $item['observation'] && stripos($item['observation'], 'orient') !== false;
                                    if ($obsContientOriente) {
                                        $decisionLabel = 'Orienté(e)';
                                        $decisionClass = 'bg-orange-100 text-orange-700 border-orange-200';
                                        $decisionEmoji = '➡️';
                                    } elseif ($estRedoublant) {
                                        $decisionLabel = 'Redoublant(e)';
                                        $decisionClass = 'bg-red-100 text-red-700 border-red-200';
                                        $decisionEmoji = '🔄';
                                    } elseif ($moyenneAnnee !== null && $moyenneAnnee >= 10) {
                                        $decisionLabel = 'Admis(e)';
                                        $decisionClass = 'bg-green-100 text-green-700 border-green-200';
                                        $decisionEmoji = '✅';
                                    } elseif ($moyenneAnnee !== null) {
                                        $decisionLabel = 'En attente';
                                        $decisionClass = 'bg-amber-100 text-amber-700 border-amber-200';
                                        $decisionEmoji = '⏳';
                                    } else {
                                        $decisionLabel = null;
                                        $decisionClass = '';
                                        $decisionEmoji = '';
                                    }
                                @endphp

                                <div class="relative flex flex-col md:flex-row items-start group">
                                    <div class="absolute left-4 md:left-1/2 transform -translate-x-1/2 w-9 h-9 rounded-full bg-white border-4 border-teal-500 shadow-xl z-10 transition-all duration-300 group-hover:scale-110 group-hover:bg-teal-500 flex items-center justify-center mt-6">
                                        <span class="text-[9px] font-black text-teal-600 group-hover:text-white transition-colors">{{ substr($item['annee_scolaire']->nom, -4) }}</span>
                                    </div>

                                    <div class="ml-14 md:ml-0 md:w-1/2 {{ $index % 2 == 0 ? 'md:pr-16' : 'md:pl-16 md:order-last' }}">
                                        <div class="block p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 border-t-4 border-t-teal-500 group-hover:-translate-y-1">

                                            {{-- En-tête --}}
                                            <div class="flex flex-wrap items-center gap-2 mb-4">
                                                <span class="px-3 py-1 text-sm font-bold text-teal-600 bg-teal-50 rounded-full">{{ $item['annee_scolaire']->nom }}</span>
                                                @if($decisionLabel)
                                                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold rounded-full border {{ $decisionClass }}">
                                                        {{ $decisionEmoji }} {{ $decisionLabel }}
                                                    </span>
                                                @endif
                                            </div>

                                            <h4 class="text-xl font-black text-gray-900">{{ $item['classe']->nom }}</h4>
                                            <p class="text-gray-500 mt-1 text-sm font-medium">{{ $item['classe']->niveau }}</p>

                                            {{-- Grille Trimestre 1 / Trimestre 2 / Trimestre 3 --}}
                                            <div class="mt-5 grid grid-cols-3 gap-3">
                                                @foreach([
                                                    ['libelle' => 'Trimestre 1', 'b' => $bulletinT1, 'ring' => 'teal'],
                                                    ['libelle' => 'Trimestre 2', 'b' => $bulletinT2, 'ring' => 'emerald'],
                                                    ['libelle' => 'Trimestre 3', 'b' => $bulletinT3, 'ring' => 'cyan'],
                                                ] as $trim)
                                                    @php $b = $trim['b']; $r = $trim['ring']; @endphp
                                                    <div class="p-3 bg-{{ $r }}-50 border border-{{ $r }}-100 rounded-xl text-center">
                                                        <p class="text-[9px] font-black uppercase tracking-widest text-{{ $r }}-500 mb-1">{{ $trim['libelle'] }}</p>
                                                        <p class="text-lg font-black {{ $b ? 'text-'.$r.'-700' : 'text-gray-300' }}">
                                                            {{ $b ? number_format($b->moyenne_generale, 2) : '—' }}
                                                        </p>
                                                        @if($b && $b->rang)
                                                            <p class="text-[9px] text-{{ $r }}-400 mt-0.5">Rang {{ $b->rang }}{{ $b->effectif_classe ? '/'.$b->effectif_classe : '' }}</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Récapitulatif annuel --}}
                                            @if($moyenneAnnee !== null)
                                                <div class="mt-4 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-4 text-sm">
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="text-gray-500 font-semibold">Moyenne annuelle :</span>
                                                        <span class="font-black text-base {{ $moyenneAnnee >= 10 ? 'text-green-600' : 'text-red-500' }}">
                                                            {{ number_format($moyenneAnnee, 2) }}/20
                                                        </span>
                                                    </div>
                                                    @if($meilleurRang)
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="text-gray-500 font-semibold">Meilleur rang :</span>
                                                            <span class="font-black text-teal-600">{{ $meilleurRang }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="mt-3 text-xs text-gray-400 font-semibold">
                                                Inscrit le {{ \Carbon\Carbon::parse($item['date_inscription'])->format('d/m/Y') }}
                                            </div>

                                            @if($item['observation'])
                                                <div class="mt-4 p-3 bg-teal-50/60 rounded-xl border border-teal-100 italic text-sm text-gray-600">
                                                    "{{ $item['observation'] }}"
                                                </div>
                                            @endif

                                            {{-- Boutons d'action --}}
                                            <div class="mt-5 pt-4 border-t border-gray-100 grid grid-cols-3 gap-2">
                                                <a href="{{ route('parent.enfant.bulletin', ['eleve' => $eleve->id, 'annee_scolaire_id' => $item['annee_scolaire']->id]) }}"
                                                   class="flex flex-col items-center p-2 rounded-xl bg-purple-50 text-blue-900 hover:bg-blue-100 transition-colors">
                                                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <span class="text-[10px] font-bold uppercase tracking-wider">Bulletins</span>
                                                </a>
                                                <a href="{{ route('parent.enfant.notes', ['eleve' => $eleve->id, 'annee_scolaire_id' => $item['annee_scolaire']->id]) }}"
                                                   class="flex flex-col items-center p-2 rounded-xl bg-green-50 text-green-700 hover:bg-green-100 transition-colors">
                                                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                    </svg>
                                                    <span class="text-[10px] font-bold uppercase tracking-wider">Notes</span>
                                                </a>
                                                <a href="{{ route('parent.enfant.absences', ['eleve' => $eleve->id, 'annee_scolaire_id' => $item['annee_scolaire']->id]) }}"
                                                   class="flex flex-col items-center p-2 rounded-xl bg-red-50 text-red-700 hover:bg-red-100 transition-colors">
                                                    <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-[10px] font-bold uppercase tracking-wider">Absences</span>
                                                </a>
                                            </div>

                                            @if($moyenneAnnee !== null && $moyenneAnnee >= 10)
                                                <div class="mt-3">
                                                    <a href="{{ route('parent.enfant.certificat', ['eleve' => $eleve->id, 'annee_scolaire_id' => $item['annee_scolaire']->id]) }}"
                                                       class="flex items-center justify-center gap-2 p-2.5 rounded-xl bg-blue-900 hover:from-amber-600 hover:via-yellow-600 hover:to-amber-700 text-white font-black text-xs uppercase tracking-wider shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                        </svg>
                                                        🎓 Certificat de Réussite
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="hidden md:block md:w-1/2"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-20">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-100 rounded-full mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800">Aucun historique trouvé</h4>
                        <p class="text-gray-500 mt-2">L'historique de scolarité de votre enfant s'affichera ici au fur et à mesure des années.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('evolutionChart');
    if (!ctx) return;

    const labels  = @json($anneeLabels);
    const dataT1  = @json($moyennesT1);
    const dataT2  = @json($moyennesT2);
    const dataT3  = @json($moyennesT3);

    const thresholdPlugin = {
        id: 'threshold',
        beforeDraw(chart) {
            const { ctx, chartArea: { left, right }, scales: { y } } = chart;
            const y10 = y.getPixelForValue(10);
            ctx.save();
            ctx.setLineDash([6, 4]);
            ctx.strokeStyle = 'rgba(107,114,128,0.45)';
            ctx.lineWidth = 1.5;
            ctx.beginPath();
            ctx.moveTo(left, y10);
            ctx.lineTo(right, y10);
            ctx.stroke();
            ctx.restore();
        }
    };

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Trimestre 1',
                    data: dataT1,
                    borderColor: '#14b8a6',
                    pointBackgroundColor: '#14b8a6',
                    pointRadius: 6, pointHoverRadius: 9,
                    tension: 0.4, spanGaps: true, fill: false,
                },
                {
                    label: 'Trimestre 2',
                    data: dataT2,
                    borderColor: '#10b981',
                    pointBackgroundColor: '#10b981',
                    pointRadius: 6, pointHoverRadius: 9,
                    tension: 0.4, spanGaps: true, fill: false,
                },
                {
                    label: 'Trimestre 3',
                    data: dataT3,
                    borderColor: '#06b6d4',
                    pointBackgroundColor: '#06b6d4',
                    pointRadius: 6, pointHoverRadius: 9,
                    tension: 0.4, spanGaps: true, fill: false,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.dataset.label + ' : ' + (ctx.raw !== null ? ctx.raw + '/20' : 'N/A'),
                    }
                },
            },
            scales: {
                y: {
                    min: 0, max: 20,
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { callback: v => v + '/20', stepSize: 5, font: { size: 11 } },
                },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } },
            },
        },
        plugins: [thresholdPlugin],
    });
});
</script>
@endpush
@endsection
