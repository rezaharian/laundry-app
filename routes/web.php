<?php

use App\Http\Controllers\PackageController;
use App\Http\Controllers\PackageItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $today = Carbon::today();

    $jumlahTransaksi = Transaction::whereDate('tanggal_masuk', $today)->count();

    $jumlahItem = TransactionItem::whereHas('transaction', function ($q) use ($today) {
        $q->whereDate('tanggal_masuk', $today);
    })->sum('jumlah');

    $jumlahOrang = Transaction::whereDate('tanggal_masuk', $today)
        ->distinct('pelanggan_nama')
        ->count('pelanggan_nama');

    $jumlahRupiah = Transaction::whereDate('tanggal_masuk', $today)->sum('total_biaya');

    // $data = Transaction::get();
    // dd($today);
    // dd($jumlahRupiah);
    return view('dashboard', compact(
        'jumlahTransaksi',
        'jumlahItem',
        'jumlahOrang',
        'jumlahRupiah'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //////
    Route::resource('packages', PackageController::class);
    Route::resource('package-items', PackageItemController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('transactions', TransactionController::class);
    Route::get('/transactions/{id}/cetak', [TransactionController::class, 'cetak'])->name('transactions.cetak');
});

require __DIR__ . '/auth.php';
