@extends('layouts.app')

@section('title', 'Modifier l\'évaluation')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Modifier l'évaluation</h1>
        <a href="{{ route('admin.evaluations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.evaluations.update', $evaluation) }}">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="classe_id" class="form-label">Classe *</label>
                        <select class="form-select @error('classe_id') is-invalid @enderror" 
                                id="classe_id" name="classe_id" required>
                            <option value="">Sélectionner une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id', $evaluation->classe_id) == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="matiere_id" class="form-label">Matière *</label>
                        <select class="form-select @error('matiere_id') is-invalid @enderror" 
                                id="matiere_id" name="matiere_id" required>
                            <option value="">Sélectionner une matière</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ old('matiere_id', $evaluation->matiere_id) == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('matiere_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="annee_scolaire_id" class="form-label">Année scolaire *</label>
                        <select class="form-select @error('annee_scolaire_id') is-invalid @enderror" 
                                id="annee_scolaire_id" name="annee_scolaire_id" required>
                            <option value="">Sélectionner une année scolaire</option>
                            @foreach($anneeScolaires as $annee)
                                <option value="{{ $annee->id }}" {{ old('annee_scolaire_id', $evaluation->annee_scolaire_id) == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->annee }}
                                </option>
                            @endforeach
                        </select>
                        @error('annee_scolaire_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="type" class="form-label">Type *</label>
                        <select class="form-select @error('type') is-invalid @enderror" 
                                id="type" name="type" required>
                            <option value="">Sélectionner un type</option>
                            <option value="devoir" {{ old('type', $evaluation->type) == 'devoir' ? 'selected' : '' }}>Devoir</option>
                            <option value="examen" {{ old('type', $evaluation->type) == 'examen' ? 'selected' : '' }}>Examen</option>
                            <option value="test" {{ old('type', $evaluation->type) == 'test' ? 'selected' : '' }}>Test</option>
                            <option value="projet" {{ old('type', $evaluation->type) == 'projet' ? 'selected' : '' }}>Projet</option>
                            <option value="autre" {{ old('type', $evaluation->type) == 'autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom de l'évaluation *</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" value="{{ old('nom', $evaluation->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="date_evaluation" class="form-label">Date de l'évaluation *</label>
                        <input type="date" class="form-control @error('date_evaluation') is-invalid @enderror" 
                               id="date_evaluation" name="date_evaluation" 
                               value="{{ old('date_evaluation', $evaluation->date_evaluation->format('Y-m-d')) }}" required>
                        @error('date_evaluation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="coefficient" class="form-label">Coefficient *</label>
                        <input type="number" class="form-control @error('coefficient') is-invalid @enderror" 
                               id="coefficient" name="coefficient" 
                               value="{{ old('coefficient', $evaluation->coefficient) }}" 
                               min="1" step="0.5" required>
                        @error('coefficient')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="bareme" class="form-label">Barème *</label>
                        <input type="number" class="form-control @error('bareme') is-invalid @enderror" 
                               id="bareme" name="bareme" 
                               value="{{ old('bareme', $evaluation->bareme) }}" 
                               min="0" step="0.5" required>
                        @error('bareme')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="periode" class="form-label">Période</label>
                        <input type="text" class="form-control @error('periode') is-invalid @enderror" 
                               id="periode" name="periode" 
                               value="{{ old('periode', $evaluation->periode) }}" 
                               placeholder="Ex: Trimestre 1">
                        @error('periode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description', $evaluation->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.evaluations.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
