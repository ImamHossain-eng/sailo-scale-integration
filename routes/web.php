<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->isSuperAdmin()) {
            return redirect()->route('super-admin.dashboard');
        } elseif ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isOperator()) {
            return redirect()->route('operator.dashboard');
        }
        
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('super-admin')->name('super-admin.')->middleware('super-admin')->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/vessels', function() { return view('admin.vessels.index'); })->name('vessels.index');
        Route::get('/vessels/{vessel}/print', [AdminDashboardController::class, 'printVessel'])->name('vessels.print');
    });

    Route::prefix('operator')->name('operator.')->middleware('operator')->group(function () {
        Route::get('/dashboard', [OperatorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/weighings/{weighing}/print', [OperatorDashboardController::class, 'print'])->name('weighings.print');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


require __DIR__ . '/auth.php';


});


    Route::post('/contact', function (\Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string|max:5000',
            ]);

            \App\Models\ContactMessage::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Your message has been sent successfully!'
            ]);
    });