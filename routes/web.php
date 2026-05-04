<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/families/pre-generate-report', function (Request $request) {
    $path = (string) $request->query('path', '');

    if ($path === '' || ! str_starts_with($path, 'reports/')) {
        abort(404);
    }

    if (! Storage::disk('local')->exists($path)) {
        abort(404);
    }

    return Storage::disk('local')->download($path);
})->name('families.pre-generate-report.download');
