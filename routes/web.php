<?php

use App\Livewire\Dashboard;
use App\Livewire\ErrorPage;
use App\Livewire\User\Faqs;
use App\Livewire\Adminlogin;
use App\Livewire\NoticePage;
use App\Livewire\PatientPet;
use App\Livewire\PetDetails;
use App\Livewire\WizardForm;
use App\Livewire\Translations;
use App\Livewire\ManageLanguage;
use App\Livewire\User\DetailsView;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;
use App\Http\Controllers\Auth\LoginQrController;
use App\Livewire\Unauthorized;
use App\Livewire\User\{MedicalHistory, PatientHistory};
use Illuminate\Support\Facades\DB;

/*
    |--------------------------------------------------------------------------
    | Application language bindings
    |--------------------------------------------------------------------------
    |*/

$locales = env('DEFAULT_LANGUAGE');
session()->put('locale', $locales);
// Wrap all non-admin routes with 'site_access' middleware

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('wizard', WizardForm::class)->name('wizard');
        Route::get('patient-details/{data}', PatientHistory::class)->name('patient-details');

});


Route::middleware(['site_access'])->group(
    function () {
        Route::middleware(['auth', 'verified'])->group(function () {
            // Route::get('wizard', WizardForm::class)->name('wizard');
            Route::get('medical-history', MedicalHistory::class)->name('medical-history');
            Route::get('SaveExit', [MedicalHistory::class, 'SaveExit'])->name('SaveExit');
            Route::get('pet-history', PetDetails::class)->name('pet-history');
            Route::get('faqs', Faqs::class)->name('faqs');
            Route::get('/', Dashboard::class)->name('dashboard');
            Route::get('dashboard', Dashboard::class);
        });


        Route::get('DetailsView/{data}', DetailsView::class)->name('DetailsView');
    }
);

Route::get('suspenedqr', NoticePage::class)->name('suspenedqr');
Route::get('unauthorized', Unauthorized::class)->name('unauthorized');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest_admin')->group(function () {
        Route::get('login', Adminlogin::class)->name('login');
    });
    Route::middleware('auth:admin')->group(function () {
        Route::get('/', AdminDashboard::class)->name('dashboard');
        Route::get('manage-language', ManageLanguage::class)->name('language');
        Route::get('editlang/{id}', ManageLanguage::class)->name('editlang');
        Route::delete('deletelang/{id}', [AdminDashboard::class, 'delete'])->name('deletelang');
        Route::get('translations/{id}', Translations::class)->name('languages.show');
    });
});

Route::post('/change-language', [ManageLanguage::class, 'changeLanguage'])->name('language.change');
require __DIR__ . '/auth.php';
// Route::fallback(ErrorPage::class);

Route::get('pd/{data}', PatientHistory::class)->name('patient-details');
            Route::get('patient-pet', PatientPet::class)->name('PatientPet');


Route::get('/test-db-connection', function () {
    try {
        DB::connection('wordpress')->getPdo();
        return 'WordPress database connection is successful!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
