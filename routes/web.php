<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\DocumentController as ClientDocumentController;
use App\Http\Controllers\Client\TransactionController as ClientTransactionController;
use App\Http\Controllers\WithdrawalRequestController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\NotificationSettingsController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Client routes
Route::middleware(['auth', 'verified', 'client'])->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/toggle-balance-visibility', [DashboardController::class, 'toggleBalanceVisibility'])->name('dashboard.toggle-balance-visibility');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/pin', [ProfileController::class, 'updatePin'])->name('profile.update-pin');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/withdrawal-requests/create', [WithdrawalRequestController::class, 'create'])->name('withdrawal-requests.create');
    Route::post('/withdrawal-requests', [WithdrawalRequestController::class, 'store'])->name('withdrawal-requests.store');
    Route::get('/my-withdrawals', [WithdrawalRequestController::class, 'myRequests'])->name('withdrawal-requests.my');
    Route::get('/withdrawals/{withdrawal}', [WithdrawalController::class, 'show'])->name('withdrawals.show');
    Route::post('/withdrawal-requests/{withdrawalRequest}/cancel', [WithdrawalRequestController::class, 'cancel'])->name('withdrawal-requests.cancel');
    Route::get('/client/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::get('/client/profile', [ProfileController::class, 'edit'])->name('client.profile');

    // Client document routes
    Route::resource('client/documents', ClientDocumentController::class)->names([
        'index' => 'client.documents.index',
        'create' => 'client.documents.create',
        'store' => 'client.documents.store',
        'show' => 'client.documents.show',
        'destroy' => 'client.documents.destroy',
    ]);
    Route::get('/client/documents/{document}/download', [ClientDocumentController::class, 'download'])->name('client.documents.download');

    // Document routes
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');

    // Two-factor authentication routes
    Route::get('/two-factor/enable', [TwoFactorController::class, 'showEnableForm'])->name('two-factor.enable');
    Route::post('/two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable.store');
    Route::post('/two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable');

    // Notification settings routes
    Route::get('/notifications/settings', [NotificationSettingsController::class, 'edit'])->name('notifications.settings');
    Route::patch('/notifications/settings', [NotificationSettingsController::class, 'update'])->name('notifications.settings.update');

    // Client transaction routes
    Route::resource('client/transactions', ClientTransactionController::class)->names([
        'index' => 'client.transactions.index',
        'create' => 'client.transactions.create',
        'store' => 'client.transactions.store',
        'show' => 'client.transactions.show',
    ]);
});

// Admin routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/users/assign-vault-to-all', [AdminUserController::class, 'assignVaultToAll'])->name('users.assign-vault-to-all');
    Route::post('/users/{user}/assign-vault', [AdminUserController::class, 'assignVault'])->name('users.assign-vault');
    Route::post('/users/{user}/vaults/{vault}/unassign', [AdminUserController::class, 'unassignVault'])->name('users.unassign-vault');
    Route::get('/users/overview', [AdminUserController::class, 'overview'])->name('users.overview');
    Route::resource('users', AdminUserController::class);
    Route::get('/users/{user}/deposit', [AdminUserController::class, 'deposit'])->name('users.deposit');
    Route::post('/users/{user}/process-deposit', [AdminUserController::class, 'processDeposit'])->name('users.process-deposit');
    Route::get('/withdrawal-requests', [WithdrawalRequestController::class, 'index'])->name('withdrawal-requests.index');
    Route::put('/withdrawal-requests/{withdrawalRequest}', [WithdrawalRequestController::class, 'update'])->name('withdrawal-requests.update');

    // Document management routes
    Route::get('/documents', [AdminDocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}', [AdminDocumentController::class, 'show'])->name('documents.show');
    Route::post('/documents/{document}/approve', [AdminDocumentController::class, 'approve'])->name('documents.approve');
    Route::post('/documents/{document}/reject', [AdminDocumentController::class, 'reject'])->name('documents.reject');
    Route::get('/documents/{document}/download', [AdminDocumentController::class, 'download'])->name('documents.download');

    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
});

require __DIR__ . '/auth.php';
