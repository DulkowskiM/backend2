<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SendMessageController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubDepartmentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::resource('departments', DepartmentController::class);
// Route::resource('/departments/{id}', [DepartmentController::class, 'show_only_department']);
Route::resource('subdepartments', SubDepartmentController::class);
Route::resource('categories', CategoryController::class);
Route::resource('topics', TopicController::class);
Route::resource('posts', PostController::class);
Route::resource('users', UserController::class);
Route::post('/users/{user}/change_permission', [UserController::class, 'changeAdminStatus']);
Route::post('/topic/{topic}/status', [TopicController::class, 'changeStatus']);
Route::get('/departments/subdepartments/categories', [DepartmentController::class, 'getDepartmentsSubdepartmentsCategories']);
//Endpoint do pobrania poszczególnego departmentu wraz z subdepartmentami
Route::get('/department/{id}', [DepartmentController::class, 'show_department']);
//Endpoint do pobrania poszczególnego subdepartmentu wraz z kategoriami
Route::get('/subdepartment/{id}', [SubDepartmentController::class, 'show_subdepartment']);
//Endpoint do pobrania pojedyńczej kategorii wraz z topicamu
Route::get('/category/{id}', [CategoryController::class, 'show_category']);
//Endpot na pobranie postu wraz z odpowiedziami
Route::get('/topic/{id_topic}', [TopicController::class, 'show_topic']);

//ednpoint na profile użytkowników.
Route::get('/profile/{id_user}', [UserController::class, 'show_profile']);
//endpoint My_profile
Route::post("/send", [SendMessageController::class, 'sendMessage']);
Route::post('/upload', [ImageUploadController::class, 'uploadImage'])
    ->name('images.upload');
//show room  
Route::get("/chat/{id}", [SendMessageController::class, 'show_room']);
Route::get("/rooms", [SendMessageController::class, 'chats']);
//read_messages 
Route::post("/read_all", [SendMessageController::class, 'read_all_messages']);

Route::get('/me', [UserController::class, 'my_profile']);

// Route::post('/refresh', [AuthController::class, 'refresh']);

//send message 

// Route::controller(AuthController::class)->group(function () {
//     Route::post('/login', 'login');
//     Route::post('/register', 'register');
//     Route::post('/logout', 'logout');
//     // Route::post('/refresh', 'refresh');
// });



// Route::get('/dashboard', function () {
//     return ('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
