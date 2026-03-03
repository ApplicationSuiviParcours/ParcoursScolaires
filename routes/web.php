<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\EleveAdminController;
use App\Http\Controllers\Admin\EnseignantAdminController;
use App\Http\Controllers\Admin\BulletinController;
use App\Http\Controllers\Admin\ReinscriptionController;
use App\Http\Controllers\Admin\AnneeScolaireController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\AbsenceController;
use App\Http\Controllers\Admin\EmploiDuTempsController;
use App\Http\Controllers\Admin\ParentAdminController;
use App\Http\Controllers\Admin\ClasseMatiereController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\EleveParentController;
use App\Http\Controllers\Admin\EvaluationAdminController;
use App\Http\Controllers\Admin\EnseignantMatiereClasseAdminController;

use Illuminate\Support\Facades\Auth;  // ← IMPORTANT
use Illuminate\Support\Facades\Route;

// ========== IMPORTS DES CONTROLLERS ENSEIGNANT ==========
use App\Http\Controllers\Enseignant\EvaluationController as EnseignantEvaluationController;
use App\Http\Controllers\Enseignant\AbsenceController as EnseignantAbsenceController;
use App\Http\Controllers\Enseignant\NoteController as EnseignantNoteController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ✅ UNE SEULE FOIS - Routes d'authentification avec vérification d'email
Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard principal - redirige vers le tableau de bord approprié selon le rôle
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// Routes pour les tableaux de bord avec statistiques
Route::middleware(['auth', 'role:administrateur'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'stats'])
        ->name('admin.dashboard');
});

// Routes supprimées pour éviter les doublons - voir plus bas

// ============================================
// ROUTES ADMINISTRATEUR
// ============================================
Route::middleware(['auth', 'role:administrateur'])->group(function () {
    // ========== NOUVELLES ROUTES UTILISATEURS ==========
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::patch('/admin/users/{user}/activate', [UserController::class, 'activate'])->name('admin.users.activate');
    Route::patch('/admin/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('admin.users.deactivate');
    Route::get('/admin/users/export', [UserController::class, 'export'])->name('admin.users.export');
    Route::delete('users/{user}/delete-photo', [UserController::class, 'deletePhoto'])->name('admin.users.delete-photo');
    Route::get('users/{user}/download-photo', [UserController::class, 'downloadPhoto'])->name('admin.users.download-photo');
    Route::post('users/{user}/resend-verification', [UserController::class, 'resendVerification'])->name('users.resend-verification');

    // Classes routes
    Route::get('/admin/classes', [ClasseController::class, 'index'])->name('admin.classes.index');
    Route::get('/admin/classes/create', [ClasseController::class, 'create'])->name('admin.classes.create');
    Route::post('/admin/classes', [ClasseController::class, 'store'])->name('admin.classes.store');
    Route::get('/admin/classes/{classe}', [ClasseController::class, 'show'])->name('admin.classes.show');
    Route::get('/admin/classes/{classe}/edit', [ClasseController::class, 'edit'])->name('admin.classes.edit');
    Route::put('/admin/classes/{classe}', [ClasseController::class, 'update'])->name('admin.classes.update');
    Route::patch('/admin/classes/{classe}', [ClasseController::class, 'update'])->name('admin.classes.update');
    Route::delete('/admin/classes/{classe}', [ClasseController::class, 'destroy'])->name('admin.classes.destroy');
    Route::get('/admin/classes/{classe}/eleves', [ClasseController::class, 'eleves'])->name('admin.classes.eleves');
    Route::get('/admin/classes/{classe}/emplois', [ClasseController::class, 'emplois'])->name('admin.classes.emplois');
    Route::post('/admin/classes/{classe}/duplicate', [ClasseController::class, 'duplicate'])->name('admin.classes.duplicate');
    Route::get('/admin/classes/exports/pdf', [ClasseController::class, 'exportPdf'])->name('admin.classes.exports.pdf');
    Route::get('/admin/classes/exports/excel', [ClasseController::class, 'exportExcel'])->name('admin.classes.exports.excel');
    Route::get('/admin/classes/{classe}/pdf', [ClasseController::class, 'generatePdf'])->name('admin.classes.pdf');
    Route::get('/admin/classes/{classe}/eleves/pdf', [ClasseController::class, 'exportElevesPdf'])->name('admin.classes.eleves-pdf');

    // Matières routes
    Route::get('/admin/matieres', [MatiereController::class, 'index'])->name('admin.matieres.index');
    Route::get('/admin/matieres/create', [MatiereController::class, 'create'])->name('admin.matieres.create');
    Route::post('/admin/matieres', [MatiereController::class, 'store'])->name('admin.matieres.store');
    Route::get('/admin/matieres/{matiere}', [MatiereController::class, 'show'])->name('admin.matieres.show');
    Route::get('/admin/matieres/{matiere}/edit', [MatiereController::class, 'edit'])->name('admin.matieres.edit');
    Route::put('/admin/matieres/{matiere}', [MatiereController::class, 'update'])->name('admin.matieres.update');
    Route::delete('/admin/matieres/{matiere}', [MatiereController::class, 'destroy'])->name('admin.matieres.destroy');
    Route::get('/admin/matieres/{matiere}/duplicate', [MatiereController::class, 'duplicate'])->name('admin.matieres.duplicate');
    Route::get('/admin/matieres/export', [MatiereController::class, 'export'])->name('admin.matieres.export');

    // Inscriptions routes
    Route::get('/admin/inscriptions', [InscriptionController::class, 'index'])->name('admin.inscriptions.index');
    Route::get('/admin/inscriptions/create', [InscriptionController::class, 'create'])->name('admin.inscriptions.create');
    Route::post('/admin/inscriptions', [InscriptionController::class, 'store'])->name('admin.inscriptions.store');
    Route::get('/admin/inscriptions/{inscription}', [InscriptionController::class, 'show'])->name('admin.inscriptions.show');
    Route::get('/admin/inscriptions/{inscription}/edit', [InscriptionController::class, 'edit'])->name('admin.inscriptions.edit');
    Route::put('/admin/inscriptions/{inscription}', [InscriptionController::class, 'update'])->name('admin.inscriptions.update');
    Route::patch('/admin/inscriptions/{inscription}/toggle-status', [InscriptionController::class, 'toggleStatus'])->name('admin.inscriptions.toggle-status');
    Route::delete('/admin/inscriptions/{inscription}', [InscriptionController::class, 'destroy'])->name('admin.inscriptions.destroy');
    Route::post('admin/inscriptions/check-eligibility', [InscriptionController::class, 'checkEligibility'])->name('admin.inscriptions.check-eligibility');

    // Élèves routes
    Route::get('/admin/eleves', [EleveAdminController::class, 'index'])->name('admin.eleves.index');
    Route::get('/admin/eleves/create', [EleveAdminController::class, 'create'])->name('admin.eleves.create');
    Route::post('/admin/eleves', [EleveAdminController::class, 'store'])->name('admin.eleves.store');
    Route::get('/admin/eleves/{eleve}', [EleveAdminController::class, 'show'])->name('admin.eleves.show');
    Route::get('/admin/eleves/{eleve}/edit', [EleveAdminController::class, 'edit'])->name('admin.eleves.edit');
    Route::put('/admin/eleves/{eleve}', [EleveAdminController::class, 'update'])->name('admin.eleves.update');
    Route::delete('/admin/eleves/{eleve}', [EleveAdminController::class, 'destroy'])->name('admin.eleves.destroy');
    Route::get('admin/eleves/export', [EleveAdminController::class, 'export'])->name('admin.eleves.export');
    Route::post('admin/eleves/{eleve}/toggle-statut', [EleveAdminController::class, 'toggleStatut'])->name('admin.eleves.toggle-statut');
    Route::patch('/admin/eleves/{eleve}', [EleveAdminController::class, 'update'])->name('admin.eleves.update');
    Route::post('/admin/eleves/{eleve}/create-user', [EleveAdminController::class, 'createUser'])->name('admin.eleves.create-user');
    Route::post('/admin/eleves/{eleve}/reset-password', [EleveAdminController::class, 'resetPassword'])->name('admin.eleves.reset-password');
    Route::delete('/admin/eleves/{eleve}/delete-user', [EleveAdminController::class, 'deleteUser'])->name('admin.eleves.delete-user');
    Route::get('/admin/eleves/{eleve}/calendrier-absences', [EleveAdminController::class, 'calendrierAbsences'])->name('admin.eleves.calendrier-absences');
    Route::get('/admin/eleves/{eleve}/releve-notes', [EleveAdminController::class, 'releveNotes'])->name('admin.eleves.releve-notes');
    Route::get('/admin/eleves/export', [EleveAdminController::class, 'export'])->name('admin.eleves.export');
    Route::get('/admin/eleves/export/pdf', [EleveAdminController::class, 'exportPdf'])->name('admin.eleves.exports.pdf');
    Route::get('/admin/eleves/export/excel', [EleveAdminController::class, 'exportExcel'])->name('admin.eleves.export.excel');
    Route::get('/admin/eleves/{eleve}/profil-pdf', [EleveAdminController::class, 'exportProfilPdf'])->name('admin.eleves.exports.profil-pdf');
    Route::get('/admin/eleves/{eleve}/releve-notes-pdf', [EleveAdminController::class, 'exportReleveNotesPdf'])->name('admin.eleves.releve-notes-pdf');

    // Enseignants routes
    Route::get('/admin/enseignants', [EnseignantAdminController::class, 'index'])->name('admin.enseignants.index');
    Route::get('/admin/enseignants/create', [EnseignantAdminController::class, 'create'])->name('admin.enseignants.create');
    Route::post('/admin/enseignants', [EnseignantAdminController::class, 'store'])->name('admin.enseignants.store');
    Route::get('/admin/enseignants/{enseignant}', [EnseignantAdminController::class, 'show'])->name('admin.enseignants.show');
    Route::get('/admin/enseignants/{enseignant}/edit', [EnseignantAdminController::class, 'edit'])->name('admin.enseignants.edit');
    Route::put('/admin/enseignants/{enseignant}', [EnseignantAdminController::class, 'update'])->name('admin.enseignants.update');
    Route::delete('/admin/enseignants/{enseignant}', [EnseignantAdminController::class, 'destroy'])->name('admin.enseignants.destroy');

    // Bulletins routes
    Route::get('/admin/bulletins', [BulletinController::class, 'index'])->name('admin.bulletins.index');
    Route::get('/admin/bulletins/generate', [BulletinController::class, 'generate'])->name('admin.bulletins.generate');
    Route::post('/admin/bulletins/generate', [BulletinController::class, 'generateStore'])->name('admin.bulletins.generateStore');
    Route::get('/admin/bulletins/{bulletin}', [BulletinController::class, 'show'])->name('admin.bulletins.show');
    Route::get('/admin/bulletins/{bulletin}/debug', [BulletinController::class, 'showDebug'])->name('admin.bulletins.debug');
    Route::put('/admin/bulletins/{bulletin}', [BulletinController::class, 'update'])->name('admin.bulletins.update');
    Route::delete('/admin/bulletins/{bulletin}', [BulletinController::class, 'destroy'])->name('admin.bulletins.destroy');
    Route::get('/admin/bulletins/{bulletin}/edit', [BulletinController::class, 'edit'])->name('admin.bulletins.edit');
    Route::get('/admin/bulletins/{bulletin}/print', [BulletinController::class, 'print'])->name('admin.bulletins.print');

    // Réinscriptions routes
    Route::get('/admin/reinscriptions', [ReinscriptionController::class, 'index'])->name('admin.reinscriptions.index');
    Route::get('/admin/reinscriptions/create', [ReinscriptionController::class, 'create'])->name('admin.reinscriptions.create');
    Route::post('/admin/reinscriptions', [ReinscriptionController::class, 'store'])->name('admin.reinscriptions.store');
    Route::get('/admin/reinscriptions/{reinscription}', [ReinscriptionController::class, 'show'])->name('admin.reinscriptions.show');
    Route::put('/admin/reinscriptions/{reinscription}', [ReinscriptionController::class, 'update'])->name('admin.reinscriptions.update');
    Route::get('/admin/reinscriptions/{reinscription}/edit', [ReinscriptionController::class, 'edit'])->name('admin.reinscriptions.edit');
    Route::delete('/admin/reinscriptions/{reinscription}', [ReinscriptionController::class, 'destroy'])->name('admin.reinscriptions.destroy');

    // Années scolaires routes
    Route::get('/admin/annee-scolaires', [AnneeScolaireController::class, 'index'])->name('admin.annee_scolaires.index');
    Route::get('/admin/annee-scolaires/create', [AnneeScolaireController::class, 'create'])->name('admin.annee_scolaires.create');
    Route::post('/admin/annee-scolaires', [AnneeScolaireController::class, 'store'])->name('admin.annee_scolaires.store');
    Route::get('/admin/annee-scolaires/{anneeScolaire}', [AnneeScolaireController::class, 'show'])->name('admin.annee_scolaires.show');
    Route::get('/admin/annee-scolaires/{anneeScolaire}/edit', [AnneeScolaireController::class, 'edit'])->name('admin.annee_scolaires.edit');
    Route::put('/admin/annee-scolaires/{anneeScolaire}', [AnneeScolaireController::class, 'update'])->name('admin.annee_scolaires.update');
    Route::post('/admin/annee-scolaires/{anneeScolaire}/activate', [AnneeScolaireController::class, 'activate'])->name('admin.annee_scolaires.activate');
    Route::post('/admin/annee-scolaires/{anneeScolaire}/deactivate', [AnneeScolaireController::class, 'deactivate'])->name('admin.annee_scolaires.deactivate');
    Route::delete('/admin/annee-scolaires/{anneeScolaire}', [AnneeScolaireController::class, 'destroy'])->name('admin.annee_scolaires.destroy');

    // Notes routes
    Route::get('/admin/notes', [NoteController::class, 'index'])->name('admin.notes.index');
    Route::get('/admin/notes/by-classe', [NoteController::class, 'byClasse'])->name('admin.notes.by-classe');
    Route::get('/admin/notes/eleve/{eleve}', [NoteController::class, 'byEleve'])->name('admin.notes.by-eleve');
    Route::get('/admin/notes/create', [NoteController::class, 'create'])->name('admin.notes.create');
    Route::post('/admin/notes', [NoteController::class, 'store'])->name('admin.notes.store');
    Route::get('/admin/notes/{note}', [NoteController::class, 'show'])->name('admin.notes.show');
    Route::get('/admin/notes/{note}/edit', [NoteController::class, 'edit'])->name('admin.notes.edit');
    Route::put('/admin/notes/{note}', [NoteController::class, 'update'])->name('admin.notes.update');
    Route::delete('/admin/notes/{note}', [NoteController::class, 'destroy'])->name('admin.notes.destroy');

    // Routes pour l'import/export
    Route::get('/admin/notes/import', [NoteController::class, 'import'])->name('admin.notes.import');
    Route::post('/admin/notes/import', [NoteController::class, 'importStore'])->name('admin.notes.import.store');
    Route::get('/admin/notes/export', [NoteController::class, 'export'])->name('admin.notes.export');

    // Absences routes
    Route::get('/admin/absences', [AbsenceController::class, 'index'])->name('admin.absences.index');
    Route::get('/admin/absences/by-classe', [AbsenceController::class, 'byClasse'])->name('admin.absences.byClasse');
    Route::get('/admin/absences/eleve/{eleve}', [AbsenceController::class, 'byEleve'])->name('admin.absences.byEleve');
    Route::get('/admin/absence/create',[AbsenceController::class, 'create'] )->name('admin.absences.create');
    Route::post('/admin/absence', [AbsenceController::class, 'store'])->name('admin.absences.store');
    Route::get('/admin/absence/{absence}', [AbsenceController::class, 'show'])->name('admin.absences.show');
    Route::get('/admin/absence/{absence}/edit', [AbsenceController::class, 'edit'])->name('admin.absences.edit');
    Route::put('/admin/absences/{absence}', [AbsenceController::class, 'update'])->name('admin.absences.update');
    Route::post('/admin/absences/{absence}/justify', [AbsenceController::class, 'justify'])->name('admin.absences.justify');
    Route::delete('/admin/absences/{absence}', [AbsenceController::class, 'destroy'])->name('admin.absences.destroy');

    // Emploi du temps routes
    Route::get('/admin/emploi-du-temps', [EmploiDuTempsController::class, 'index'])->name('admin.emploi_du_temps.index');
    Route::get('/admin/emploi-du-temps/by-classe', [EmploiDuTempsController::class, 'byClasse'])->name('admin.emploi_du_temps.byClasse');
    Route::get('/admin/emploi-du-temps/by-enseignant', [EmploiDuTempsController::class, 'byEnseignant'])->name('admin.emploi_du_temps.byEnseignant');
    Route::get('/admin/emploi-du-temps/create',[EmploiDuTempsController::class, 'create'] )->name('admin.emploi_du_temps.create');
    Route::post('/admin/emploi-du-temps', [EmploiDuTempsController::class, 'store'])->name('admin.emploi_du_temps.store');
    Route::get('/admin/emploi-du-temps/{emploi_du_temps}', [EmploiDuTempsController::class, 'show'])->name('admin.emploi_du_temps.show');
    Route::get('/admin/emploi-du-temps/{emploi_du_temps}/edit', [EmploiDuTempsController::class, 'edit'])->name('admin.emploi_du_temps.edit');
    Route::put('/admin/emploi-du-temps/{emploi_du_temps}', [EmploiDuTempsController::class, 'update'])->name('admin.emploi_du_temps.update');
    Route::delete('/admin/emploi-du-temps/{emploi_du_temps}', [EmploiDuTempsController::class, 'destroy'])->name('admin.emploi_du_temps.destroy');

    // Parents routes
    Route::get('/admin/parents', [ParentAdminController::class, 'index'])->name('admin.parents.index');
    Route::get('/admin/parents/create', [ParentAdminController::class, 'create'])->name('admin.parents.create');
    Route::post('/admin/parents', [ParentAdminController::class, 'store'])->name('admin.parents.store');
    Route::get('/admin/parents/{parent}', [ParentAdminController::class, 'show'])->name('admin.parents.show');
    Route::get('/admin/parents/{parent}/edit', [ParentAdminController::class, 'edit'])->name('admin.parents.edit');
    Route::put('/admin/parents/{parent}', [ParentAdminController::class, 'update'])->name('admin.parents.update');
    Route::delete('/admin/parents/{parent}', [ParentAdminController::class, 'destroy'])->name('admin.parents.destroy');

    // Classe-Matière routes
    Route::get('/admin/classe-matieres', [ClasseMatiereController::class, 'index'])->name('admin.classe_matieres.index');
    Route::get('/admin/classe-matieres/manage', [ClasseMatiereController::class, 'manage'])->name('admin.classe_matieres.manage');
    Route::get('/admin/classe-matieres/{classeMatiere}', [ClasseMatiereController::class, 'show'])->name('admin.classe_matieres.show');
    Route::post('/admin/classe-matieres', [ClasseMatiereController::class, 'store'])->name('admin.classe_matieres.store');
    Route::get('/admin/classe-matieres/{classeMatiere}/edit', [ClasseMatiereController::class, 'edit'])->name('admin.classe_matieres.edit');
    Route::put('/admin/classe-matieres/{classeMatiere}', [ClasseMatiereController::class, 'update'])->name('admin.classe_matieres.update');
    Route::delete('/admin/classe-matieres/{classeMatiere}', [ClasseMatiereController::class, 'destroy'])->name('admin.classe_matieres.destroy');

    // Élève-Parent routes
    Route::get('/admin/eleve-parents', [EleveParentController::class, 'index'])->name('admin.eleve-parents.index');
    Route::get('/admin/eleve-parents/create', [EleveParentController::class, 'create'])->name('admin.eleve-parents.create');
    Route::post('/admin/eleve-parents', [EleveParentController::class, 'store'])->name('admin.eleve-parents.store');
    Route::get('/admin/eleve-parents/{eleveParent}', [EleveParentController::class, 'show'])->name('admin.eleve-parents.show');
    Route::get('/admin/eleve-parents/{eleveParent}/edit', [EleveParentController::class, 'edit'])->name('admin.eleve-parents.edit');
    Route::put('/admin/eleve-parents/{eleveParent}', [EleveParentController::class, 'update'])->name('admin.eleve-parents.update');
    Route::delete('/admin/eleve-parents/{eleveParent}', [EleveParentController::class, 'destroy'])->name('admin.eleve-parents.destroy');
    Route::get('/admin/eleve-parents/export/pdf', [EleveParentController::class, 'exportPdf'])->name('admin.eleve-parents.export.pdf');
    Route::get('/admin/eleve-parents/export/excel', [EleveParentController::class, 'exportExcel'])->name('admin.eleve-parents.export.excel');
    Route::get('/admin/eleve-parents/{eleveParent}/pdf', [EleveParentController::class, 'generatePdf'])->name('admin.eleve-parents.pdf');

    // Élève-Parent API routes
    Route::get('/admin/eleve-parents/eleve/{eleve}/parents', [EleveParentController::class, 'getParentsByEleve'])->name('admin.eleve-parents.parents-by-eleve');
    Route::get('/admin/eleve-parents/parent/{parent}/eleves', [EleveParentController::class, 'getElevesByParent'])->name('admin.eleve-parents.eleves-by-parent');
    Route::delete('/admin/eleve-parents/eleve/{eleve}', [EleveParentController::class, 'deleteByEleve'])->name('admin.eleve-parents.delete-by-eleve');
    Route::delete('/admin/eleve-parents/parent/{parent}', [EleveParentController::class, 'deleteByParent'])->name('admin.eleve-parents.delete-by-parent');

    // Evaluations routes
    Route::get('/admin/evaluations', [EvaluationAdminController::class, 'index'])->name('admin.evaluations.index');
    Route::get('/admin/evaluations/create', [EvaluationAdminController::class, 'create'])->name('admin.evaluations.create');
    Route::post('/admin/evaluations', [EvaluationAdminController::class, 'store'])->name('admin.evaluations.store');
    Route::get('/admin/evaluations/{evaluation}', [EvaluationAdminController::class, 'show'])->name('admin.evaluations.show');
    Route::get('/admin/evaluations/{evaluation}/edit', [EvaluationAdminController::class, 'edit'])->name('admin.evaluations.edit');
    Route::put('/admin/evaluations/{evaluation}', [EvaluationAdminController::class, 'update'])->name('admin.evaluations.update');
    Route::delete('/admin/evaluations/{evaluation}', [EvaluationAdminController::class, 'destroy'])->name('admin.evaluations.destroy');
    Route::get('/admin/evaluations/upcoming', [EvaluationAdminController::class, 'upcoming'])->name('admin.evaluations.upcoming');
    Route::get('/admin/evaluations/past', [EvaluationAdminController::class, 'past'])->name('admin.evaluations.past');
    Route::get('/admin/evaluations/{evaluation}/duplicate', [EvaluationAdminController::class, 'duplicate'])->name('admin.evaluations.duplicate');
    Route::get('/admin/evaluations/{evaluation}/export', [EvaluationAdminController::class, 'export'])->name('admin.evaluations.export');

    // Enseignant-Matiere-Classe routes
    Route::get('/admin/enseignant-matiere-classes', [EnseignantMatiereClasseAdminController::class, 'index'])->name('admin.enseignant_matiere_classes.index');
    Route::get('/admin/enseignant-matiere-classes/create', [EnseignantMatiereClasseAdminController::class, 'create'])->name('admin.enseignant_matiere_classes.create');
    Route::post('/admin/enseignant-matiere-classes', [EnseignantMatiereClasseAdminController::class, 'store'])->name('admin.enseignant_matiere_classes.store');
    Route::get('/admin/enseignant-matiere-classes/{enseignantMatiereClasse}', [EnseignantMatiereClasseAdminController::class, 'show'])->name('admin.enseignant_matiere_classes.show');
    Route::get('/admin/enseignant-matiere-classes/{enseignantMatiereClasse}/edit', [EnseignantMatiereClasseAdminController::class, 'edit'])->name('admin.enseignant_matiere_classes.edit');
    Route::put('/admin/enseignant-matiere-classes/{enseignantMatiereClasse}', [EnseignantMatiereClasseAdminController::class, 'update'])->name('admin.enseignant_matiere_classes.update');
    Route::delete('/admin/enseignant-matiere-classes/{enseignantMatiereClasse}', [EnseignantMatiereClasseAdminController::class, 'destroy'])->name('admin.enseignant_matiere_classes.destroy');
});

// ============================================
// ROUTES ENSEIGNANT
// ============================================
Route::middleware(['auth', 'role:enseignant'])->prefix('enseignant')->name('enseignant.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [EnseignantController::class, 'dashboard'])->name('dashboard');

    // Classes
    Route::get('/classes', [EnseignantController::class, 'mesClasses'])->name('classes');

    // GESTION DES ÉVALUATIONS
    Route::resource('evaluations', EnseignantEvaluationController::class)->names([
        'index' => 'evaluations.index',
        'create' => 'evaluations.create',
        'store' => 'evaluations.store',
        'show' => 'evaluations.show',
        'edit' => 'evaluations.edit',
        'update' => 'evaluations.update',
        'destroy' => 'evaluations.destroy',
    ]);

    // Routes supplémentaires pour évaluations
    Route::post('evaluations/{id}/duplicate', [EnseignantEvaluationController::class, 'duplicate'])->name('evaluations.duplicate');
    Route::get('evaluations/{id}/statistiques', [EnseignantEvaluationController::class, 'statistiques'])->name('evaluations.statistiques');

    // GESTION DES NOTES
    Route::controller(EnseignantNoteController::class)->prefix('notes')->name('notes.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/eleves/{evaluationId}', 'getElevesByEvaluation')->name('eleves');
        Route::get('/quick/{evaluation}', 'quick')->name('quick');
        Route::post('/quick/{evaluation}', 'quickStore')->name('quick.store');
        Route::get('/export/{evaluation}', 'export')->name('export');
    });

    // GESTION DES ABSENCES
    Route::controller(EnseignantAbsenceController::class)->prefix('absences')->name('absences.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::put('/{id}/justify', 'justify')->name('justify');
        Route::post('/presence/{eleve}', 'marquerPresence')->name('presence');
        Route::get('/eleves/{classeId}', 'getElevesByClasse')->name('eleves');
        Route::get('/statistiques', 'statistiques')->name('statistiques');
        Route::get('/calendrier', 'calendrier')->name('calendrier');
    });

    // Profil et autres
    Route::get('/profil', [EnseignantController::class, 'profil'])->name('profil');
    Route::get('/emploi-du-temps', [EnseignantController::class, 'emploiDuTemps'])->name('emploi-du-temps');
    Route::get('/statistiques', [EnseignantController::class, 'statistiques'])->name('statistiques');
});

// ============================================
// ROUTES ÉLÈVE
// ============================================
Route::middleware(['auth', 'role:eleve'])->group(function () {
    Route::get('/eleve/dashboard', [EleveController::class, 'dashboard'])->name('eleve.dashboard');
    Route::get('/eleve/mes-notes', [EleveController::class, 'mesNotes'])->name('eleve.notes');
    Route::get('/eleve/mes-absences', [EleveController::class, 'mesAbsences'])->name('eleve.absences');
    Route::get('/eleve/mon-bulletin', [EleveController::class, 'monBulletin'])->name('eleve.bulletin');
    Route::get('/eleve/emploi-du-temps', [EleveController::class, 'emploiDuTemps'])->name('eleve.emploi-du-temps');
});

// ============================================
// ROUTES PARENT
// ============================================
Route::middleware(['auth', 'role:parent'])->group(function () {
    // Dashboard - remplacé par le nouveau contrôleur
    Route::get('/parent/dashboard', [App\Http\Controllers\Parent\DashboardController::class, 'index'])->name('parent.dashboard');
    
    // Mes enfants - gardé avec l'ancien contrôleur
    // Route::get('/parent/mes-enfants', [ParentController::class, 'mesEnfants'])->name('parent.enfants');
    Route::get('parent/mes-enfants', [App\Http\Controllers\Parent\EnfantsController::class, 'mesEnfants'])->name('parent.enfants');
    
    // Notes d'un enfant - remplacé par le nouveau contrôleur
    Route::get('/parent/enfant/{eleve}/notes', [App\Http\Controllers\Parent\NoteController::class, 'index'])->name('parent.enfant.notes');
    
    // Absences d'un enfant - remplacé par le nouveau contrôleur
    Route::get('/parent/enfant/{eleve}/absences', [App\Http\Controllers\Parent\AbsenceController::class, 'index'])->name('parent.enfant.absences');
    
    // Justification d'absence - remplacé par le nouveau contrôleur
    Route::post('/parent/absence/{absence}/justifier', [App\Http\Controllers\Parent\AbsenceController::class, 'justifier'])->name('parent.justifier-absence');
    
    // Bulletins d'un enfant - remplacé par le nouveau contrôleur
    Route::get('/parent/enfant/{eleve}/bulletins', [App\Http\Controllers\Parent\BulletinController::class, 'index'])->name('parent.enfant.bulletin');
    Route::get('/parent/enfant/{eleve}/bulletin/{bulletin}', [App\Http\Controllers\Parent\BulletinController::class, 'show'])->name('parent.enfant.bulletin.detail');
    Route::get('/parent/enfant/{eleve}/bulletin/{bulletin}/telecharger', [App\Http\Controllers\Parent\BulletinController::class, 'telecharger'])->name('parent.telecharger-bulletin');
    
    // Emploi du temps - gardé avec l'ancien contrôleur
    Route::get('/parent/enfant/{eleve}/emploi-du-temps', [ParentController::class, 'emploiDuTempsEnfant'])->name('parent.enfant.emploi-du-temps');
});

// Route pour la recherche
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/live', [SearchController::class, 'live'])->name('search.live');

// ============================================
// ROUTES PROFIL UTILISATEUR
// ============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========== FIN DU FICHIER - AUCUNE LIGNE SUPPLÉMENTAIRE ==========