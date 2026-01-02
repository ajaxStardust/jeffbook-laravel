<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

Route::get("/", function () {
    return view("home");
})->name("home");

Auth::routes();

Route::middleware("auth")->group(function () {
    Route::get("/{category}/post/create", [
        PostController::class,
        "create",
    ])->name("posts.create");
    Route::post("/{category}/post/create", [
        PostController::class,
        "store",
    ])->name("posts.store");

    Route::get("/{category}/{postslug}/edit", [
        PostController::class,
        "edit",
    ])->name("posts.edit");
    Route::put("/{category}/{postslug}", [
        PostController::class,
        "update",
    ])->name("posts.update");

    Route::get("/{category}/{postslug}/delete", [
        PostController::class,
        "destroy",
    ])->name("posts.delete");
});

// PUBLIC
Route::get("/{category}", [CategoryController::class, "index"])->name(
    "category.show",
);
Route::get("/{category}/{postslug}", [PostController::class, "show"])->name(
    "posts.show",
);
