<?php

use App\Http\Controllers\PetaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/peta-usaha', [PetaController::class, 'apiPetaUsaha']);
