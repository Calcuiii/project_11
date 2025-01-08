<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect to login page when accessing root
Route::get('/', function () {
    return redirect('login');
});

// Home route with authentication middleware
Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Profile route with authentication middleware
Route::get('profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');

// Resource route for employees with authentication middleware
Route::resource('employees', EmployeeController::class)->middleware('auth');

// Authentication routes
Auth::routes();

// Route for creating file in the local disk
Route::get('/local-disk', function () {
    Storage::disk('local')->put('local-example.txt', 'This is local example content');
    return asset('storage/local-example.txt');
});

// Route for creating file in the public disk
Route::get('/public-disk', function () {
    Storage::disk('public')->put('public-example.txt', 'This is public example content');
    return asset('storage/public-example.txt');
});

// Route to retrieve local file
Route::get('/retrieve-local-file', function () {
    if (Storage::disk('local')->exists('local-example.txt')) {
        return Storage::disk('local')->get('local-example.txt');
    } else {
        return 'File does not exist';
    }
});

// Route to retrieve public file
Route::get('/retrieve-public-file', function () {
    if (Storage::disk('public')->exists('public-example.txt')) {
        return Storage::disk('public')->get('public-example.txt');
    } else {
        return 'File does not exist';
    }
});

// Route to download local file
Route::get('/download-local-file', function () {
    return Storage::download('local-example.txt', 'local file');
});

// Route to download public file
Route::get('/download-public-file', function () {
    return Storage::download('public/public-example.txt', 'public file');
});

// Route to get file URL (URL for public files)
Route::get('/file-url', function () {
    $url = Storage::url('public-example.txt');
    return $url;
});

// Route to get file size
Route::get('/file-size', function () {
    $size = Storage::size('local-example.txt');
    return $size;
});

// Route to get file path
Route::get('/file-path', function () {
    $path = Storage::path('local-example.txt');
    return $path;
});

// Route to display upload form
Route::get('/upload-example', function () {
    return view('upload_example');
});

// Route to handle file upload
Route::post('/upload-example', function (Request $request) {
    $path = $request->file('avatar')->store('public');
    return $path;
})->name('upload-example');

// Route to delete local file
Route::get('/delete-local-file', function () {
    Storage::disk('local')->delete('local-example.txt');
    return 'Deleted';
});

// Route to delete public file
Route::get('/delete-public-file', function () {
    Storage::disk('public')->delete('public-example.txt');
    return 'Deleted';
});

// Route to download employee's CV file
Route::get('download-file/{employeeId}', [EmployeeController::class, 'downloadFile'])->name('employees.downloadFile');

Storage::makeDirectory('public/files');