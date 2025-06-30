<?php
 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CaseComplaintController;
use App\Http\Controllers\MediationController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\MailController;
 
 
use Illuminate\Support\Facades\Route;
 
Route::get('/', function () {
    return view('welcome');
});
 
Route::middleware(['role:1'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard'); //
});
 
 
 
 
// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
 
    // Route::get('/registration', [DashboardController::class, 'registration'])->name('registration');

    // Case submission
    Route::get('/cases', [MediationController::class, 'index'])->name('cases.index');
    Route::get('/cases/status/{status}', [DashboardController::class, 'filterByStatus'])->name('cases.filter');
    Route::get('/cases/{id}', [DashboardController::class, 'show'])->name('cases.show');
    // Route::post('/mediations/{id}/summarize', [DashboardController::class, 'summarizeOrder'])->name('mediations.summarize');
    Route::post('/cases/{id}/summarize-order', [DashboardController::class, 'summarizeOrder'])
     ->name('cases.summarize-order');

    Route::post('/cases/{id}/summarize-case', [DashboardController::class, 'summarizeCase'])->name('cases.summarize-case');

    
    // chatbot
    Route::post('/support-messages', [DashboardController::class, 'store'])->name('support.store');
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [DashboardController::class, 'markRead'])->name('notifications.markRead');





 
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
 
    // Registration new form view (protected)
    Route::get('/register-new', [MediationController::class, 'create'])->name('register.new');
 
    // Mediation routes (protected)
    Route::get('/mediation/create', [MediationController::class, 'create'])->name('mediation.create');
    Route::post('/mediation/store', [MediationController::class, 'store'])->name('mediation.store');
 
    
 
    // Mediator routes
    Route::get('/mediators/create', [MediationController::class, 'create'])->name('mediators.create');
    Route::post('/mediators/store', [MediationController::class, 'storeMediator'])->name('mediators.store');
 
 
    Route::get('/mediation/{id}/edit', [MediationController::class, 'edit'])->name('mediation.edit');
    Route::put('/mediation/{id}', [MediationController::class, 'update'])->name('mediation.update');
    Route::delete('/mediation/{id}', [MediationController::class, 'destroy'])->name('mediation.destroy');
 
 
    Route::get('/appellants', [CrudController::class, 'appellant'])->name('appellants.index');
    Route::get('/respondents', [CrudController::class, 'Respondent'])->name('respondents.index');
    Route::get('/advocates', [CrudController::class, 'advocate'])->name('advocates.index');
    Route::get('/mediators', [CrudController::class, 'Mediator'])->name('mediators.index');
    Route::get('/courts', [CrudController::class, 'court'])->name('courts.index');
    Route::get('/subjects', [CrudController::class, 'subject'])->name('subjects.index');
    Route::get('/issues', [CrudController::class, 'issue'])->name('issues.index');
    Route::get('/statutes', [CrudController::class, 'statute'])->name('statutes.index');
    Route::get('/users', [CrudController::class, 'users'])->name('users.index');
});
 
 
// Public routes (no auth required)
Route::get('/fetch-judges', [MediationController::class, 'fetchJudges'])->name('fetchJudges');
Route::get('/fetch-cities', [MediationController::class, 'fetchCities'])->name('fetch.cities');
Route::get('/judge-suggestions', [MediationController::class, 'judgeSuggestions']);
 
 
Route::get('/autocomplete/advocates', [MediationController::class, 'autocomplete']);
Route::get('/autocomplete/mediators', [MediationController::class, 'autocompleteMediators']);
 
 
Route::middleware('auth')->group(function () {
    Route::get('/appellants/{id}', [CrudController::class, 'showComplainant'])->name('appellants.show');
    Route::get('/appellants/{id}/edit', [CrudController::class, 'editComplainant'])->name('appellants.edit');
    Route::put('/appellants/{id}', [CrudController::class, 'updateComplainant'])->name('appellants.update');
    Route::delete('/appellants/{id}', [CrudController::class, 'destroyComplainant'])->name('appellants.destroy');
 
    Route::get('/respondents/{id}', [CrudController::class, 'showRespondent'])->name('respondents.show');
    Route::get('/respondents/{id}/edit', [CrudController::class, 'editRespondent'])->name('respondents.edit');
    Route::put('/respondents/{id}', [CrudController::class, 'updateRespondent'])->name('respondents.update');
    Route::delete('/respondents/{id}', [CrudController::class, 'destroyRespondent'])->name('respondents.destroy');
    

    // Advocate routes
    Route::get('/advocates/create', [MediationController::class, 'create'])->name('advocates.create');
    Route::post('/advocates/store', [MediationController::class, 'storeAdvocate'])->name('advocates.store');
    Route::get('/advocates/{id}', [CrudController::class, 'showAdvocate'])->name('advocates.show');
    Route::get('/advocates/{id}/edit', [CrudController::class, 'editAdvocate'])->name('advocates.edit');
    Route::put('/advocates/{id}', [CrudController::class, 'updateAdvocate'])->name('advocates.update');
    Route::delete('/advocates/{id}', [CrudController::class, 'destroyAdvocate'])->name('advocates.destroy');
 
 
    Route::get('/mediators/{id}', [CrudController::class, 'showMediator'])->name('mediators.show');
    Route::get('/mediators/{id}/edit', [CrudController::class, 'editMediator'])->name('mediators.edit');
    Route::put('/mediators/{id}', [CrudController::class, 'updateMediator'])->name('mediators.update');
    Route::delete('/mediators/{id}', [CrudController::class, 'destroyMediator'])->name('mediators.destroy');
 
 
    Route::get('/courts/create', [CrudController::class, 'createCourt'])->name('courts.create');
    Route::post('/courts', [CrudController::class, 'storeCourt'])->name('courts.store');
    Route::get('/courts/{AG_Courtcode}', [CrudController::class, 'showCourt'])->name('courts.show');
    Route::get('/courts/{AG_Courtcode}/edit', [CrudController::class, 'editCourt'])->name('courts.edit');
    Route::put('/courts/{AG_Courtcode}', [CrudController::class, 'updateCourt'])->name('courts.update');
    Route::delete('/courts/{AG_Courtcode}', [CrudController::class, 'destroyCourt'])->name('courts.destroy');
 
 
    Route::get('/subjects/create', [CrudController::class, 'createSubject'])->name('subjects.create');
    Route::post('/subjects', [CrudController::class, 'storeSubject'])->name('subjects.store');
    Route::get('/subjects/{subject_id}', [CrudController::class, 'showSubject'])->name('subjects.show');
    Route::get('/subjects/{subject_id}/edit', [CrudController::class, 'editSubject'])->name('subjects.edit');
    Route::put('/subjects/{subject_id}', [CrudController::class, 'updateSubject'])->name('subjects.update');
    Route::delete('/subjects/{subject_id}', [CrudController::class, 'destroySubject'])->name('subjects.destroy');
 
 
 
    Route::get('issues/create', [CrudController::class, 'createIssue'])->name('issues.create');
    Route::post('issues', [CrudController::class, 'storeIssue'])->name('issues.store');
    Route::get('/issues/{id}', [CrudController::class, 'showIssue'])->name('issues.show');
    Route::get('/issues/{id}/edit', [CrudController::class, 'editIssue'])->name('issues.edit');
    Route::put('/issues/{id}', [CrudController::class, 'updateIssue'])->name('issues.update');
    Route::delete('/issues/{id}', [CrudController::class, 'destroyIssue'])->name('issues.destroy');
 
 
 
    Route::get('/statutes/create', [CrudController::class, 'createStatute'])->name('statutes.create');
    Route::post('/statutes', [CrudController::class, 'storeStatute'])->name('statutes.store');
    Route::get('/statutes/{id}', [CrudController::class, 'showStatute'])->name('statutes.show');
    Route::get('/statutes/{id}/edit', [CrudController::class, 'editStatute'])->name('statutes.edit');
    Route::put('/statutes/{id}', [CrudController::class, 'updateStatute'])->name('statutes.update');
    Route::delete('/statutes/{id}', [CrudController::class, 'destroyStatute'])->name('statutes.destroy');
 
 
 
    Route::get('/users/create', [CrudController::class, 'createUser'])->name('users.create');
    Route::post('/users', [CrudController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}', [CrudController::class, 'showUser'])->name('users.show');
    Route::get('/users/{id}/edit', [CrudController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [CrudController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [CrudController::class, 'destroyUser'])->name('users.destroy');
});
 
 
 
 
require __DIR__.'/auth.php';