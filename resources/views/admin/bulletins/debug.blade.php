@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Debug Bulletin #{{ $bulletin->id }}</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">

        <div class="bg-blue-900 rounded-3xl p-6 mb-6 shadow-2xl">
            <h1 class="text-xl font-bold text-white font-mono">🛠 Debug — Bulletin #{{ $bulletin->id }}</h1>
            <p class="text-gray-400 mt-1">Vue de débogage pour vérifier les données du bulletin</p>
        </div>

        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-6">
            <div class="p-6 bg-gray-800">
                <h3 class="text-lg font-bold text-white font-mono">Données brutes du bulletin</h3>
            </div>
            <div class="p-6">
                <pre class="bg-gray-50 p-4 rounded-xl overflow-x-auto text-sm font-mono text-gray-800">{{ json_encode($bulletin->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>

        @if($bulletin->eleve)
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-6">
            <div class="p-6 bg-gray-700">
                <h3 class="text-lg font-bold text-white font-mono">Élève associé</h3>
            </div>
            <div class="p-6">
                <pre class="bg-gray-50 p-4 rounded-xl overflow-x-auto text-sm font-mono text-gray-800">{{ json_encode($bulletin->eleve->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
        @endif

        @if($bulletin->classe)
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-6">
            <div class="p-6 bg-gray-600">
                <h3 class="text-lg font-bold text-white font-mono">Classe</h3>
            </div>
            <div class="p-6">
                <pre class="bg-gray-50 p-4 rounded-xl overflow-x-auto text-sm font-mono text-gray-800">{{ json_encode($bulletin->classe->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
        @endif

        <div class="flex gap-4">
            <a href="{{ route('admin.bulletins.show', $bulletin) }}" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                Voir le bulletin normal
            </a>
            <a href="{{ route('admin.bulletins.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200">
                Retour à la liste
            </a>
        </div>

    </div>
</div>
@endsection
