<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Front\LanguageController;


    
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
    Route::post('/select-material', [HomeController::class, 'selectMaterial'])->name('material.select');

    Route::get('/typeof', [HomeController::class, 'type'])->name('type');
    Route::post('/select-type', [HomeController::class, 'selectType'])->name('type.select');

    Route::get('/layout', [HomeController::class, 'layout'])->name('layout');
    Route::get('/step-content', [HomeController::class, 'stepContent'])->name('step.content');

        

    Route::get('/login', [UserController::class, 'index'])->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.submit');
    Route::get('/my-account', [UserController::class, 'myAccount'])->name('my.account');
    Route::post('/my-account/update', [UserController::class, 'updateProfile'])->name('profile.update');
   // Logout
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');  
    Route::get('/forgot-password', [UserController::class, 'forgotPassword'])->name('forgot.password');  
    Route::post('/forgot-password', [UserController::class, 'sendResetLinkEmail'])->name('forgot.password.email');
    Route::get('/otp', [UserController::class, 'otp'])->name('otp');  
    Route::post('/otp', [UserController::class, 'verifyOtp'])->name('otp.verify');
    Route::get('/reset-password', [UserController::class, 'reset'])->name('reset');  
    Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset.password.submit');
     
    Route::post('calculator-steps', [HomeController::class, 'getCalculatorSteps'])->name('calculator.steps');

    Route::get('/calculator/materials', [HomeController::class, 'getMaterials'])->name('calculator.materials');
    
    Route::get('/calculator/edge-thicknesses', [HomeController::class, 'getEdgeThicknesses'])->name('calculator.edge.thicknesses');
    
    Route::get('/calculator/edge-colors', [HomeController::class, 'getEdgeColors'])->name('calculator.edge.colors');
    
    Route::post('/calculator/submit', [HomeController::class, 'submitQuote'])->name('calculator.submit');

    Route::get('/thank-you', [HomeController::class, 'thankYou'])->name('thank.you');
