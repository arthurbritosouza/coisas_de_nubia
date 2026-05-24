<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class, "index"]);
Route::get("/croche",   [CategoryController::class, "show"])->defaults("category", "croche");
Route::get("/bordados", [CategoryController::class, "show"])->defaults("category", "bordados");
Route::get("/doces",    [CategoryController::class, "show"])->defaults("category", "doces");
