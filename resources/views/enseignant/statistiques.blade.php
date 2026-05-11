@extends('layouts.app')
@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">Mes statistiques</h2>
@endsection
@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-6xl sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-8 mb-8 shadow-2xl">
            <h1 class="text-2xl font-bold text-white">📈 Mes statistiques</h1>
            <p class="text-indigo-200 mt-1">Vue d'ensemble de vos activités d'enseignement</p>
        </div>
        <div class="bg-white shadow-lg rounded-2xl p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <p class="text-gray-500 text-lg">Statistiques en cours de développement.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-4">
                <a href="{{ route('enseignant.evaluations.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">Mes évaluations</a>
                <a href="{{ route('enseignant.notes.index') }}" class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">Mes notes</a>
                <a href="{{ route('enseignant.absences.statistiques') }}" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">Stats absences</a>
            </div>
        </div>
    </div>
</div>
@endsection
