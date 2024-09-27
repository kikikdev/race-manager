<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/races', [RaceController::class, 'index'])->name('races.index');
Route::get('/races/create', [RaceController::class, 'create'])->name('races.create');
Route::post('/races', [RaceController::class, 'store'])->name('races.store');
Route::get('/races/{raceId}/edit', [RaceController::class, 'edit'])->name('races.edit');
Route::post('/races/{raceId}', [RaceController::class, 'update'])->name('races.update');
Route::delete('/races/{raceId}', [RaceController::class, 'destroy'])->name('races.destroy');
Route::get('races/{raceId}/download-pdf', [RaceController::class, 'downloadPdf'])->name('races.download-pdf');
Route::get('races/export-pdf', [RaceController::class, 'exportAllRacesPdf'])->name('races.export-pdf');



