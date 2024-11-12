<?php


// routes/web.php
use App\Http\Controllers\CustomerExportController;

Route::get('/export-customers', function () {
    return view('export'); // Return the export form view
});

Route::post('/export-customers', [CustomerExportController::class, 'export']); // Export job route
Route::get('/download-export', [CustomerExportController::class, 'downloadExportedFile']); // Direct download route
