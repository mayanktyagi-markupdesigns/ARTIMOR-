<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MaterialGroupController;
use App\Http\Controllers\Admin\MaterialTypeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\FinishController;
use App\Http\Controllers\Admin\ThicknessController;
use App\Http\Controllers\Admin\MaterialLayoutCaterogyController;
use App\Http\Controllers\Admin\MaterialLayoutGroupController;
use App\Http\Controllers\Admin\MaterialLayoutShapeController;
use App\Http\Controllers\Admin\EdgeProfileController;
use App\Http\Middleware\AdminAuthenticate;
use Illuminate\Support\Facades\Artisan;

// Route::get('/run-storage-link', function () {
//     Artisan::call('storage:link');
//     return 'Storage link created successfully!';
// });

Route::prefix('admin')->name('admin.')->group(function () {    
        Route::get('/login', [AuthController::class, 'index'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
   
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('profile', [AuthController::class, 'updateProfile'])->name('profile.update');
        Route::get('change-password', [AuthController::class, 'changePassword'])->name('password.change');
        Route::post('change-password', [AuthController::class, 'updatePassword'])->name('password.update');        

        /*---------------------------------User Controller-------------------------------------------------------*/
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/list', [UserController::class, 'index'])->name('list');          
            Route::get('/add', [UserController::class, 'create'])->name('create');        
            Route::post('/create', [UserController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');            
            Route::get('/view/{id}', [UserController::class, 'detailView'])->name('view');            
        });
        /*---------------------------------End User Controller---------------------------------------------------*/        

        /*---------------------------------Setting Controller ---------------------------------------------------*/
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('edit');
            Route::post('update', [SettingController::class, 'update'])->name('update');
        });
        /*---------------------------------End Setting Controller------------------------------------------------*/

        /*---------------------------------Material Group Controller------------------------------------------*/
        Route::prefix('material-group')->name('material.group.')->group(function () {
            Route::get('/list', [MaterialGroupController::class, 'index'])->name('list');
            Route::get('/add', [MaterialGroupController::class, 'create'])->name('create');
            Route::post('/create', [MaterialGroupController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MaterialGroupController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MaterialGroupController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MaterialGroupController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Material Group Controller--------------------------------------*/

        /*---------------------------------Material Type Controller------------------------------------------*/
        Route::prefix('material-type')->name('material.type.')->group(function () {
            Route::get('/list', [MaterialTypeController::class, 'index'])->name('list');
            Route::get('/add', [MaterialTypeController::class, 'create'])->name('create');
            Route::post('/create', [MaterialTypeController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MaterialTypeController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MaterialTypeController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MaterialTypeController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Material Type Controller--------------------------------------*/

        /*---------------------------------Color Controller--------------------------------------------------*/
        Route::prefix('-material-color')->name('color.')->group(function () {
            Route::get('/list', [ColorController::class, 'index'])->name('list');
            Route::get('/add', [ColorController::class, 'create'])->name('create');
            Route::post('/create', [ColorController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ColorController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ColorController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [ColorController::class, 'destroy'])->name('destroy');
            Route::get('/get-material-types', [ColorController::class, 'getMaterialTypes'])->name('getMaterialTypes');
        });
        /*---------------------------------End Color Controller---------------------------------------------*/

        /*---------------------------------Finish Controller--------------------------------------------------*/
        Route::prefix('finish')->name('finish.')->group(function () {
            Route::get('/list', [FinishController::class, 'index'])->name('list');
            Route::get('/add', [FinishController::class, 'create'])->name('create');
            Route::post('/create', [FinishController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [FinishController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [FinishController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [FinishController::class, 'destroy'])->name('destroy');           
        });
        /*---------------------------------End Finish Controller---------------------------------------------*/

        /*---------------------------------Thickness Controller--------------------------------------------------*/
        Route::prefix('thickness')->name('thickness.')->group(function () {
            Route::get('/list', [ThicknessController::class, 'index'])->name('list');
            Route::get('/add', [ThicknessController::class, 'create'])->name('create');
            Route::post('/create', [ThicknessController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ThicknessController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ThicknessController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [ThicknessController::class, 'destroy'])->name('destroy');
            Route::get('/thickness/{id}/view', [ThicknessController::class, 'show'])->name('show');

        });
        /*---------------------------------End Thickness Controller---------------------------------------------*/ 
        
        /*---------------------------------Material Layout Category Controller----------------------------------*/
        Route::prefix('material-layout-category')->name('material.layout.category.')->group(function () {
            Route::get('/list', [MaterialLayoutCaterogyController::class, 'index'])->name('list');
            Route::get('/add', [MaterialLayoutCaterogyController::class, 'create'])->name('create');
            Route::post('/create', [MaterialLayoutCaterogyController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MaterialLayoutCaterogyController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MaterialLayoutCaterogyController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MaterialLayoutCaterogyController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Material Category Controller--------------------------------------*/

        /*---------------------------------Material Layout Group Controller----------------------------------*/
        Route::prefix('material-layout-group')->name('material.layout.group.')->group(function () {
            Route::get('/list', [MaterialLayoutGroupController::class, 'index'])->name('list');
            Route::get('/add', [MaterialLayoutGroupController::class, 'create'])->name('create');
            Route::post('/create', [MaterialLayoutGroupController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MaterialLayoutGroupController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MaterialLayoutGroupController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MaterialLayoutGroupController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Material Layout Group Controller--------------------------------------*/

        /*---------------------------------Material Layout Shape Controller----------------------------------*/
        Route::prefix('material-layout-shape')->name('material.layout.shape.')->group(function () {
            Route::get('/list', [MaterialLayoutShapeController::class, 'index'])->name('list');
            Route::get('/add', [MaterialLayoutShapeController::class, 'create'])->name('create');
            Route::post('/create', [MaterialLayoutShapeController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MaterialLayoutShapeController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MaterialLayoutShapeController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MaterialLayoutShapeController::class, 'destroy'])->name('destroy');

        });
        /*---------------------------------End Material Layout Shape Controller--------------------------------------*/

        /*---------------------------------Edge Profile Controller------------------------------------------*/
        Route::prefix('edge-profile')->name('edge.profile.')->group(function () {
            Route::get('/list', [EdgeProfileController::class, 'index'])->name('list');
            Route::get('/add', [EdgeProfileController::class, 'create'])->name('create');
            Route::post('/create', [EdgeProfileController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [EdgeProfileController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [EdgeProfileController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [EdgeProfileController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Edge Profile Controller--------------------------------------*/
        
    });

}); 