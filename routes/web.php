<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/login', function () {
    return view('login_page'); // We will create a gorgeous custom login blade view.
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/jobs', function () {
    return view('jobs');
});

Route::get('/jobs/create', function () {
    return view('create_job');
});

Route::get('/technicians', function () {
    return view('technicians');
});

Route::get('/time-logs', function () {
    return view('time_logs');
});

Route::get('/settings', function () {
    return view('settings');
});

