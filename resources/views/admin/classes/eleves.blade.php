@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">
        Élèves — {{ $classe->nom_complet ?? $classe->nom }}
    </h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-6xl sm:px-6 lg:px-8">

        {{-- En-tête --}}
        <div class="bg-blue-900 rounded-3xl p-6 mb-8 shadow-2xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">
                        👥 Élèves — {{ $classe->nom_complet ?? $classe->nom }}
                    </h1>
                    <p class="text-blue-200 mt-1">
                        {{ $inscriptions->total() }} élève(s) · Capacité : {{ $classe->capacite }}
                    </p>
                </div>
                <a href="{{ route('admin.classes.show', $classe) }}"
                    class="inline-flex items-center px-4 py-2 bg-white/20 text-white rounded-xl hover:bg-white/30 transition-colors">
                    ← Retour à la classe
                </a>
            </div>
        </div>

        {{-- Liste des élèves --}}
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 overflow-x-auto">
                @if($inscriptions->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Élève</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Matricule</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Genre</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($inscriptions as $index => $inscription)
                        @php $eleve = $inscription->eleve; @endphp
                        @if($eleve)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $inscriptions->firstItem() + $index }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-900 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $eleve->prenom }} {{ $eleve->nom }}</p>
                                        <p class="text-xs text-gray-500">{{ $eleve->date_naissance ? \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') : 'N/A' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 font-mono">{{ $eleve->matricule ?? '—' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold {{ ($eleve->genre === 'M' || $eleve->genre === 'm') ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }} rounded-full">
                                    {{ ($eleve->genre === 'M' || $eleve->genre === 'm') ? '♂ Garçon' : '♀ Fille' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                    Inscrit
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.eleves.show', $eleve) }}"
                                    class="p-2 text-blue-900 bg-blue-100 rounded-lg hover:bg-blue-200 inline-flex items-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $inscriptions->links() }}</div>
                @else
                <div class="text-center py-12 text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                    </svg>
                    <p class="text-lg">Aucun élève inscrit dans cette classe.</p>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
