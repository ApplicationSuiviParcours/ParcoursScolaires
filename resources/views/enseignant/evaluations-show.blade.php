@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-sm text-gray-800 leading-tight">
        <a href="{{ route('enseignant.evaluations.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors mr-2">Évaluations</a> 
        <span class="text-gray-300">/</span> 
        <span class="text-indigo-600 ml-2">Détails de l'Évaluation</span>
    </h2>
@endsection

@section('content')
<div class="py-12 bg-gradient-to-br from-indigo-50 via-white to-purple-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Header Section -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-8 sm:px-8 text-white flex justify-between items-center">
                <div>
                    <h3 class="text-2xl font-bold">{{ $evaluation->nom }}</h3>
                    <p class="mt-2 text-indigo-100 flex items-center space-x-4">
                        <span><svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253"></path></svg> {{ optional($evaluation->matiere)->nom }}</span>
                        <span><svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg> {{ optional($evaluation->classe)->nom }}</span>
                        <span><svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m/Y') }}</span>
                    </p>
                </div>
                <div class="flex flex-col items-center">
                    <span class="text-3xl font-black">{{ $evaluation->coefficient }}</span>
                    <span class="text-xs uppercase tracking-widest text-indigo-200">Coefficient</span>
                </div>
            </div>
            
            <div class="px-6 py-6 sm:px-8 bg-gray-50 flex space-x-4">
                 <a href="{{ route('enseignant.evaluations.edit', $evaluation->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg text-sm font-medium transition-colors">
                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                     Modifier
                 </a>
                 <a href="{{ route('enseignant.notes.create', ['evaluation' => $evaluation->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white hover:bg-green-700 rounded-lg text-sm font-medium transition-colors">
                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                     Saisie des Notes
                 </a>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase font-bold text-gray-500">Moyenne</p>
                    <p class="text-2xl font-black text-indigo-600 mt-1">{{ number_format($stats['moyenne'], 2) }} <span class="text-sm font-normal text-gray-400">/{{ $evaluation->bareme }}</span></p>
                </div>
                <div class="p-3 bg-indigo-50 rounded-full text-indigo-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase font-bold text-gray-500">Taux de réussite</p>
                    <p class="text-2xl font-black text-green-600 mt-1">{{ number_format($stats['taux_reussite'], 1) }}%</p>
                </div>
                <div class="p-3 bg-green-50 rounded-full text-green-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase font-bold text-gray-500">Note Min / Max</p>
                    <p class="text-2xl font-black text-gray-800 mt-1">{{ number_format($stats['note_min'], 1) }} <span class="text-sm font-normal text-gray-400">-</span> {{ number_format($stats['note_max'], 1) }}</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-full text-purple-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase font-bold text-gray-500">Saisie</p>
                    <p class="text-2xl font-black text-blue-600 mt-1">{{ $stats['notes_saisies'] }} <span class="text-sm font-normal text-gray-400">/{{ $stats['total_eleves'] }}</span></p>
                </div>
                <div class="p-3 bg-blue-50 rounded-full text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Notes Table -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                <h4 class="text-lg font-bold text-gray-900 flex items-center">
                   <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                   Notes des Élèves
                </h4>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Élève</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Matricule</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Note / {{ $evaluation->bareme }}</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Observation</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($evaluation->notes as $note)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ optional($note->eleve)->nom }} {{ optional($note->eleve)->prenom }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ optional($note->eleve)->matricule }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full font-bold text-xs border {{ $note->note >= 10 ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                    {{ $note->note }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 italic max-w-xs truncate" title="{{ $note->observation }}">{{ $note->observation ?? '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('enseignant.notes.edit', $note->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Modifier</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Aucune note n'a encore été saisie pour cette évaluation.<br>
                                <a href="{{ route('enseignant.notes.create', ['evaluation' => $evaluation->id]) }}" class="mt-2 inline-block text-indigo-600 font-semibold hover:underline">Commencer la saisie</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
