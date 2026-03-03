{{-- resources/views/admin/eleve_parents/partials/form.blade.php --}}
@csrf

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="eleve_id" class="form-label">Élève <span class="text-danger">*</span></label>
        <select name="eleve_id" id="eleve_id" class="form-select @error('eleve_id') is-invalid @enderror" required>
            <option value="">Sélectionnez un élève</option>
            @foreach($eleves as $eleve)
                <option value="{{ $eleve->id }}" {{ old('eleve_id', $eleveParent->eleve_id ?? '') == $eleve->id ? 'selected' : '' }}>
                    {{ $eleve->nom }} {{ $eleve->prenom }}
                    @if($eleve->classe)
                        ({{ $eleve->classe->nom }})
                    @endif
                </option>
            @endforeach
        </select>
        @error('eleve_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="parent_eleve_id" class="form-label">Parent <span class="text-danger">*</span></label>
        <select name="parent_eleve_id" id="parent_eleve_id"
            class="form-select @error('parent_eleve_id') is-invalid @enderror" required>
            <option value="">Sélectionnez un parent</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_eleve_id', $eleveParent->parent_eleve_id ?? '') == $parent->id ? 'selected' : '' }}>
                    {{ $parent->nom }} {{ $parent->prenom }} - {{ $parent->email }}
                </option>
            @endforeach
        </select>
        @error('parent_eleve_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="lien_parental" class="form-label">Lien parental <span class="text-danger">*</span></label>
        <select name="lien_parental" id="lien_parental" class="form-select @error('lien_parental') is-invalid @enderror"
            required>
            <option value="">Sélectionnez le lien</option>
            <option value="père" {{ old('lien_parental', $eleveParent->lien_parental ?? '') == 'père' ? 'selected' : '' }}>Père</option>
            <option value="mère" {{ old('lien_parental', $eleveParent->lien_parental ?? '') == 'mère' ? 'selected' : '' }}>Mère</option>
            <option value="tuteur" {{ old('lien_parental', $eleveParent->lien_parental ?? '') == 'tuteur' ? 'selected' : '' }}>Tuteur</option>
            <option value="grand-parent" {{ old('lien_parental', $eleveParent->lien_parental ?? '') == 'grand-parent' ? 'selected' : '' }}>Grand-parent</option>
            <option value="oncle" {{ old('lien_parental', $eleveParent->lien_parental ?? '') == 'oncle' ? 'selected' : '' }}>Oncle</option>
            <option value="tante" {{ old('lien_parental', $eleveParent->lien_parental ?? '') == 'tante' ? 'selected' : '' }}>Tante</option>
            <option value="autre" {{ old('lien_parental', $eleveParent->lien_parental ?? '') == 'autre' ? 'selected' : '' }}>Autre</option>
        </select>
        @error('lien_parental')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ $submitButton ?? 'Enregistrer' }}
        </button>
        <a href="{{ route('admin.eleve-parents.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Annuler
        </a>
    </div>
</div>