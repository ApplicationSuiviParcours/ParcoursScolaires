@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-sm text-gray-800 leading-tight flex justify-between items-center">
        <div>
            <a href="{{ route('enseignant.notes.index') }}" class="text-gray-500 hover:text-emerald-600 transition-colors mr-2">Notes</a> 
            <span class="text-gray-300">/</span> 
            <span class="text-emerald-600 ml-2">{{ __('Modifier Note') }}</span>
        </div>
    </h2>
@endsection

@section('content')
<div class="py-12 bg-gradient-to-br from-emerald-50 via-white to-teal-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Main Form Card -->
        <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-2xl sm:rounded-3xl border border-white/50">
            <div class="p-8 sm:p-10">
                
                @if ($errors->any())
                    <div class="mb-8 bg-red-50 border-l-4 border-red-500 rounded-r-2xl p-5 shadow-sm transform transition-all hover:scale-[1.01]">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 rounded-full p-2">
                                <svg class="h-6 w-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">Erreurs avec votre soumission</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Form Header -->
                <div class="flex items-center mb-8 pb-6 border-b border-gray-100">
                    <div class="bg-gradient-to-br from-blue-400 to-indigo-500 text-white p-4 rounded-2xl shadow-lg shadow-blue-500/30 mr-5 transform hover:-rotate-3 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-800">
                            Modification de la note de {{ $note->eleve->prenom }} {{ $note->eleve->nom }}
                        </h3>
                        <p class="text-gray-500 text-sm mt-1 font-medium">Réajustez la note ou modifiez votre appréciation.</p>
                    </div>
                </div>

                <div class="mb-8 bg-blue-50/50 p-6 rounded-2xl border border-blue-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-500/10 rounded-full blur-xl"></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                        <div class="flex items-start">
                            <div class="bg-white p-2 rounded-lg shadow-sm mr-4 text-blue-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 mb-1">Évaluation & Matière</p>
                                <p class="text-base text-gray-900 font-bold">{{ $note->evaluation->nom }}</p>
                                <p class="text-sm text-blue-700 font-medium">{{ $note->evaluation->matiere->nom }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-white p-2 rounded-lg shadow-sm mr-4 text-indigo-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider font-semibold text-gray-500 mb-1">Type & Date</p>
                                <p class="text-base text-gray-900 font-bold capitalize">{{ $note->evaluation->type }}</p>
                                <p class="text-sm text-indigo-700 font-medium">{{ \Carbon\Carbon::parse($note->evaluation->date_evaluation)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('enseignant.notes.update', $note->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        <!-- Ligne Note et Barème -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="group">
                                <label for="note" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-blue-600 transition-colors">
                                    Note de l'élève <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-xl shadow-sm overflow-hidden flex ring-1 ring-gray-200 focus-within:ring-2 focus-within:ring-blue-500 transition-all duration-300">
                                    <input type="number" step="0.25" min="0" max="{{ $note->evaluation->bareme ?? 20 }}" id="note" name="note" required value="{{ old('note', $note->note) }}"
                                        class="block w-full border-0 bg-gray-50 focus:bg-white text-lg font-bold text-blue-700 py-4 pl-5 focus:ring-0 transition-colors">
                                    <div class="flex items-center justify-center px-5 bg-gray-100 border-l border-gray-200">
                                        <span class="text-gray-600 font-black text-lg">/ {{ $note->evaluation->bareme ?? 20 }}</span>
                                    </div>
                                </div>
                                @error('note')
                                    <p class="text-sm text-red-600 mt-2 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Observation -->
                        <div class="group">
                            <label for="observation" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-blue-600 transition-colors">
                                Observation / Appréciation <span class="text-gray-400 font-normal">(Optionnel)</span>
                            </label>
                            <textarea id="observation" name="observation" rows="4"
                                class="block w-full rounded-xl border-gray-200 bg-gray-50 text-gray-800 p-4 shadow-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 resize-y"
                                placeholder="Appréciation du travail de l'élève...">{{ old('observation', $note->observation) }}</textarea>
                            @error('observation')
                                <p class="text-sm text-red-600 mt-2 font-medium flex items-center"><svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-12 flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('enseignant.notes.index') }}" 
                            class="px-6 py-3 bg-white text-gray-700 font-semibold border-2 border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all duration-300 text-center">
                            Annuler
                        </a>
                        <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Mettre à jour la note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
