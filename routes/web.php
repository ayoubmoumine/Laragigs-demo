<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\List_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/register", [UserController::class, "create"])->middleware("guest");

Route::post("/users", [UserController::class, "store"])->middleware("guest");

Route::post("/logout", [UserController::class, "logout"])->middleware("auth");

Route::get("/login", [UserController::class, "login"])->name("login")->middleware("guest");

Route::post("/login", [UserController::class, "authenticate"])->middleware("guest");

Route::get("/", [ListingController::class, "index"]);

Route::get("/listings/create", [ListingController::class, "create"])->middleware("auth");

Route::post("/listings", [ListingController::class, "store"])->middleware("auth");

Route::get("/listings/manage", [ListingController::class, "manage"])->middleware("auth");

Route::get("/listings/{listing}", [ListingController::class, "show"])->middleware("auth");

Route::put("/listings/{listing}", [ListingController::class, "update"])->middleware("auth");

Route::delete("/listings/{listing}", [ListingController::class, "destroy"])->middleware("auth");

Route::get("/listings/{listing}/edit", [ListingController::class, "edit"])->middleware("auth");

Route::resource('post', PostController::class);


// Route::get('hello', function() {
//     return response("Hello world");
// });

// Route::get('posts/{id}', function($id) {
//     // ddd($id);
//     return response("Post N: ".$id);
// });
