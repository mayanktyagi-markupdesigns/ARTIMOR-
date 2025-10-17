<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\MaterialTypeController;
use App\Http\Controllers\Admin\MaterialLayoutController;
use App\Http\Controllers\Admin\DimensionController;
use App\Http\Controllers\Admin\MaterialEdgeController;
use App\Http\Controllers\Admin\BackWallController;
use App\Http\Controllers\Admin\SinkController;
use App\Http\Controllers\Admin\CutOutsController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Middleware\AdminAuthenticate;


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

        /*---------------------------------Banner Controller-----------------------------------------------------*/
        Route::prefix('banner')->name('banner.')->group(function () {
            Route::get('/list', [BannerController::class, 'index'])->name('list');          
            Route::get('/add', [BannerController::class, 'create'])->name('create');        
            Route::post('/create', [BannerController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [BannerController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [BannerController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [BannerController::class, 'view'])->name('view');
        });
        /*---------------------------------End Banner Controller-------------------------------------------------*/

        /*---------------------------------Setting Controller ---------------------------------------------------*/
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('edit');
            Route::post('update', [SettingController::class, 'update'])->name('update');
        });
        /*---------------------------------End Setting Controller------------------------------------------------*/

        /*---------------------------------Material Controller---------------------------------------------------*/
        Route::prefix('material')->name('material.')->group(function () {
            Route::get('/list', [MaterialController::class, 'index'])->name('list');          
            Route::get('/add', [MaterialController::class, 'create'])->name('create');        
            Route::post('/create', [MaterialController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [MaterialController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [MaterialController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [MaterialController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [MaterialController::class, 'view'])->name('view');
        });
        /*---------------------------------End Material Controller-----------------------------------------------*/

        /*---------------------------------Material Type Controller----------------------------------------------*/
        Route::prefix('material-type')->name('material.type.')->group(function () {
            Route::get('/list', [MaterialTypeController::class, 'index'])->name('list');          
            Route::get('/add', [MaterialTypeController::class, 'create'])-> name('create');        
            Route::post('/create', [MaterialTypeController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [MaterialTypeController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [MaterialTypeController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [MaterialTypeController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [MaterialTypeController::class, 'view'])->name('view');
        });
        /*---------------------------------End Material Type Controller------------------------------------------*/

        /*---------------------------------Material Layout Controller--------------------------------------------*/
        Route::prefix('material-layout')->name('layout.')->group(function () {
            Route::get('/list', [MaterialLayoutController::class, 'index'])->name('list');          
            Route::get('/add', [MaterialLayoutController::class, 'create'])->name('create');        
            Route::post('/create', [MaterialLayoutController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [MaterialLayoutController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [MaterialLayoutController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [MaterialLayoutController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [MaterialLayoutController::class, 'view'])->name('view');
        });
        /*---------------------------------End Material Layout Controller----------------------------------------*/

        /*---------------------------------Dimension Controller--------------------------------------------------*/
        Route::prefix('dimension')->name('dimension.')->group(function () {
            Route::get('/list', [DimensionController::class, 'index'])->name('list');          
            Route::get('/add', [DimensionController::class, 'create'])->name('create');        
            Route::post('/create', [DimensionController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [DimensionController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [DimensionController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [DimensionController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [DimensionController::class, 'view'])->name('view');
        }); 
        /*---------------------------------End Dimension Controller----------------------------------------------*/

        /*---------------------------------Material Edge Controller----------------------------------------------*/
        Route::prefix('material-edge')->name('material.edge.')->group(function () {
            Route::get('/list', [MaterialEdgeController::class, 'index'])->name('list');          
            Route::get('/add', [MaterialEdgeController::class, 'create'])->name('create');        
            Route::post('/create', [MaterialEdgeController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [MaterialEdgeController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [MaterialEdgeController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [MaterialEdgeController::class, 'destroy'])->name('destroy');            
        }); 
        /*---------------------------------End Material Edge Controller------------------------------------------*/

        /*---------------------------------Back Wall Controller--------------------------------------------------*/
        Route::prefix('back-wall')->name('back.wall.')->group(function () {
            Route::get('/list', [BackWallController::class, 'index'])->name('list');          
            Route::get('/add', [BackWallController::class, 'create'])->name('create');        
            Route::post('/create', [BackWallController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [BackWallController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [BackWallController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [BackWallController::class, 'destroy'])->name('destroy');            
        }); 
        /*---------------------------------End Back Wall Controller----------------------------------------------*/

        /*---------------------------------Sink Controller-------------------------------------------------------*/
        Route::prefix('sink')->name('sink.')->group(function () {
            Route::get('/list', [SinkController::class, 'index'])->name('list');          
            Route::get('/add', [SinkController::class, 'create'])->name('create');        
            Route::post('/create', [SinkController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [SinkController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [SinkController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [SinkController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [SinkController::class, 'view'])->name('view');
        });
        /*---------------------------------End Sink Controller--------------------------------------------------*/

        /*---------------------------------Cut Outs Controller--------------------------------------------------*/
        Route::prefix('cut-outs')->name('cut.outs.')->group(function () {
            Route::get('/list', [CutOutsController::class, 'index'])->name('list');          
            Route::get('/add', [CutOutsController::class, 'create'])->name('create');        
            Route::post('/create', [CutOutsController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [CutOutsController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [CutOutsController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [CutOutsController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [CutOutsController::class, 'view'])->name('view');
        });
        /*---------------------------------End Cut Outs Controller----------------------------------------------*/
        /*---------------------------------Quotation Controller-------------------------------------------------*/
        Route::prefix('quotation')->name('quotations.')->group(function () {
            Route::get('/list', [QuotationController::class, 'index'])->name('list');          
            Route::get('/view/{id}', [QuotationController::class, 'show'])->name('view');            
        });
        /*---------------------------------End Quotation Controller---------------------------------------------*/
        
        /*---------------------------------Promo Code Controller------------------------------------------------*/
        Route::prefix('promo-code')->name('promo.code.')->group(function () {
            Route::get('/list', [PromoCodeController::class, 'index'])->name('list');          
            Route::get('/add', [PromoCodeController::class, 'create'])->name('create');        
            Route::post('/create', [PromoCodeController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [PromoCodeController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [PromoCodeController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [PromoCodeController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [PromoCodeController::class, 'view'])->name('view');
        });
        /*---------------------------------End Promo Code Controller---------------------------------------------*/
    });
}); 