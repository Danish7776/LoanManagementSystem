<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanDetailController;
use App\Http\Controllers\ProcessDataController;


Route::post('/loginUser', [UserController::class, 'login'])->name('loginUser');
Route::post('/registerUser', [UserController::class, 'signup'])->name('registerUser');
Route::post('logout', [UserController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('login');
})->name('home');

Route::get('/SignIn', function () {
    return view('login');
})->name('SignIn');

Route::get('/SignUp', function () {
    return view('signup');
})->name('SignUp');

// Route::get('fetch-employees', [EmployeeController::class, 'fetchemployee']);

// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Route::get('Dashboard-SuperAdmin', [EmployeeController::class, 'index']);
    // Route::post('employees', [EmployeeController::class, 'store']);
    // // Route::get('fetch-employees', [EmployeeController::class, 'fetchemployee']);
    // Route::get('edit-employee/{id}', [EmployeeController::class, 'edit']);
    // Route::put('update-employee/{id}', [EmployeeController::class, 'update']);
    // Route::delete('delete-employee/{id}', [EmployeeController::class, 'destroy']);

    Route::get('Dashboard', [LoanDetailController::class, 'index']);
    Route::get('fetch-loan-details', [LoanDetailController::class, 'fetchLoanData']);
    Route::get('/process-data', [ProcessDataController::class, 'showPage'])->name('process.data.show');
    Route::post('/process-data', [ProcessDataController::class, 'processData'])->name('process.data.process');
    Route::get('/processData', [ProcessDataController::class, 'showProceessPage'])->name('employee.welcome');

});

?>