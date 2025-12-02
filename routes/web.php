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
use App\Http\Controllers\Admin\EdgeProfileThicknessController;
use App\Http\Controllers\Admin\MaterialColorEdgeExceptionController;
use App\Http\Controllers\Admin\BacksplashShapesController;
use App\Http\Controllers\Admin\BacksplashShapeSidesController;
use App\Http\Controllers\Admin\BacksplashPriceController;
use App\Http\Controllers\Admin\SinkCategoryController;
use App\Http\Controllers\Admin\SinkController;
use App\Http\Controllers\Admin\CutOutsCategoryController;
use App\Http\Controllers\Admin\CutOutsController;
use App\Http\Controllers\Admin\PromoCodeController;
use App\Http\Controllers\Admin\CutoutMaterialThicknessPriceController;
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

        /*---------------------------------Material Group Controller---------------------------------------------*/
        Route::prefix('material-group')->name('material.group.')->group(function () {
            Route::get('/list', [MaterialGroupController::class, 'index'])->name('list');
            Route::get('/add', [MaterialGroupController::class, 'create'])->name('create');
            Route::post('/create', [MaterialGroupController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MaterialGroupController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MaterialGroupController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MaterialGroupController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Material Group Controller----------------------------------------*/

        /*---------------------------------Material Type Controller---------------------------------------------*/
        Route::prefix('material-type')->name('material.type.')->group(function () {
            Route::get('/list', [MaterialTypeController::class, 'index'])->name('list');
            Route::get('/add', [MaterialTypeController::class, 'create'])->name('create');
            Route::post('/create', [MaterialTypeController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MaterialTypeController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MaterialTypeController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MaterialTypeController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Material Type Controller-----------------------------------------*/

        /*---------------------------------Color Controller-----------------------------------------------------*/
        Route::prefix('-material-color')->name('color.')->group(function () {
            Route::get('/list', [ColorController::class, 'index'])->name('list');
            Route::get('/add', [ColorController::class, 'create'])->name('create');
            Route::post('/create', [ColorController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ColorController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ColorController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [ColorController::class, 'destroy'])->name('destroy');
            Route::get('/get-material-types', [ColorController::class, 'getMaterialTypes'])->name('getMaterialTypes');
        });
        /*---------------------------------End Color Controller-------------------------------------------------*/

        /*---------------------------------Finish Controller----------------------------------------------------*/
        Route::prefix('finish')->name('finish.')->group(function () {
            Route::get('/list', [FinishController::class, 'index'])->name('list');
            Route::get('/add', [FinishController::class, 'create'])->name('create');
            Route::post('/create', [FinishController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [FinishController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [FinishController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [FinishController::class, 'destroy'])->name('destroy');           
        });
        /*---------------------------------End Finish Controller------------------------------------------------*/

        /*---------------------------------Thickness Controller-------------------------------------------------*/
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

        /*---------------------------------Material Layout Group Controller--------------------------------------*/
        Route::prefix('material-layout-group')->name('material.layout.group.')->group(function () {
            Route::get('/list', [MaterialLayoutGroupController::class, 'index'])->name('list');
            Route::get('/add', [MaterialLayoutGroupController::class, 'create'])->name('create');
            Route::post('/create', [MaterialLayoutGroupController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MaterialLayoutGroupController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MaterialLayoutGroupController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MaterialLayoutGroupController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Material Layout Group Controller----------------------------------*/

        /*---------------------------------Material Layout Shape Controller--------------------------------------*/
        Route::prefix('material-layout-shape')->name('material.layout.shape.')->group(function () {
            Route::get('/list', [MaterialLayoutShapeController::class, 'index'])->name('list');
            Route::get('/add', [MaterialLayoutShapeController::class, 'create'])->name('create');
            Route::post('/create', [MaterialLayoutShapeController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MaterialLayoutShapeController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MaterialLayoutShapeController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MaterialLayoutShapeController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [MaterialLayoutShapeController::class, 'view'])->name('view');    

        });
        /*---------------------------------End Material Layout Shape Controller----------------------------------*/

        /*---------------------------------Edge Profile Controller-----------------------------------------------*/
        Route::prefix('edge-profile')->name('edge.profile.')->group(function () {
            Route::get('/list', [EdgeProfileController::class, 'index'])->name('list');
            Route::get('/add', [EdgeProfileController::class, 'create'])->name('create');
            Route::post('/create', [EdgeProfileController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [EdgeProfileController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [EdgeProfileController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [EdgeProfileController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Edge Profile Controller-------------------------------------------*/

        /*---------------------------------Edge Profile Thickness Controller-------------------------------------*/
        Route::prefix('edge-profile-thickness')->name('edge.profile.thickness.')->group(function () {
            Route::get('/list', [EdgeProfileThicknessController::class, 'index'])->name('list');
            Route::get('/add', [EdgeProfileThicknessController::class, 'create'])->name('create');
            Route::post('/create', [EdgeProfileThicknessController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [EdgeProfileThicknessController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [EdgeProfileThicknessController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [EdgeProfileThicknessController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Edge Profile Thickness Controller---------------------------------*/

        /*---------------------------------Material Color Edge Exception Controller------------------------------*/
        Route::prefix('color-edge-exception')->name('color.edge.exception.')->group(function () {
            Route::get('/list', [MaterialColorEdgeExceptionController::class, 'index'])->name('list');
            Route::get('/add', [MaterialColorEdgeExceptionController::class, 'create'])->name('create');
            Route::post('/create', [MaterialColorEdgeExceptionController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [MaterialColorEdgeExceptionController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [MaterialColorEdgeExceptionController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [MaterialColorEdgeExceptionController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Material Color Edge Exception Controller--------------------------*/

        /*---------------------------------Backsplash Shapes Controller------------------------------------------*/
        Route::prefix('backsplash-shapes')->name('backsplash.shapes.')->group(function () {
            Route::get('/list', [BacksplashShapesController::class, 'index'])->name('list');
            Route::get('/add', [BacksplashShapesController::class, 'create'])->name('create');
            Route::post('/create', [BacksplashShapesController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [BacksplashShapesController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [BacksplashShapesController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [BacksplashShapesController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Backsplash Shapes Controller--------------------------------------*/

        /*---------------------------------Backsplash Shapes sides Controller------------------------------------*/
        Route::prefix('backsplash-shapes-sides')->name('backsplash.shapes.sides.')->group(function () {
            Route::get('/list', [BacksplashShapeSidesController::class, 'index'])->name('list');
            Route::get('/add', [BacksplashShapeSidesController::class, 'create'])->name('create');
            Route::post('/create', [BacksplashShapeSidesController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [BacksplashShapeSidesController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [BacksplashShapeSidesController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [BacksplashShapeSidesController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Backsplash Shapes sides Controller--------------------------------*/

        /*---------------------------------Back splash Price Controller------------------------------------------*/
        Route::prefix('backsplash-price')->name('backsplash.price.')->group(function () {
            Route::get('/list', [BacksplashPriceController::class, 'index'])->name('list');
            Route::get('/add', [BacksplashPriceController::class, 'create'])->name('create');
            Route::post('/create', [BacksplashPriceController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [BacksplashPriceController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [BacksplashPriceController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [BacksplashPriceController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Backsplash Price Controller Controller----------------------------*/

        /*---------------------------------sink Category Controller----------------------------------------------*/
        Route::prefix('sink-category')->name('sink.category.')->group(function () {
            Route::get('/list', [SinkCategoryController::class, 'index'])->name('list');
            Route::get('/add', [SinkCategoryController::class, 'create'])->name('create');
            Route::post('/create', [SinkCategoryController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [SinkCategoryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [SinkCategoryController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [SinkCategoryController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End sink Category Controller------------------------------------------*/

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
        /*---------------------------------End Sink Controller---------------------------------------------------*/

        /*---------------------------------Cut Outs Category Controller------------------------------------------*/
        Route::prefix('cut-outs-category')->name('cutouts.category.')->group(function () {
            Route::get('/list', [CutOutsCategoryController::class, 'index'])->name('list');
            Route::get('/add', [CutOutsCategoryController::class, 'create'])->name('create');
            Route::post('/create', [CutOutsCategoryController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [CutOutsCategoryController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [CutOutsCategoryController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [CutOutsCategoryController::class, 'destroy'])->name('destroy');
        });
        /*---------------------------------End Cut Outs Category Controller--------------------------------------*/

        /*---------------------------------Cut Outs Controller---------------------------------------------------*/
        Route::prefix('cut-outs')->name('cut.outs.')->group(function () {
            Route::get('/list', [CutOutsController::class, 'index'])->name('list');          
            Route::get('/add', [CutOutsController::class, 'create'])->name('create');        
            Route::post('/create', [CutOutsController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [CutOutsController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [CutOutsController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [CutOutsController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [CutOutsController::class, 'view'])->name('view');
        });
        /*---------------------------------End Cut Outs Controller-----------------------------------------------*/

        /*---------------------------------Promo Code Controller-------------------------------------------------*/
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
 
        /*---------------------------------Cutout Material Thickness Price Controller----------------------------*/
        Route::prefix('cutout-material-thickness-price-controller')->name('cutout.material.thickness.price.controller.')->group(function () {
            Route::get('/list', [CutoutMaterialThicknessPriceController::class, 'index'])->name('list');          
            Route::get('/add', [CutoutMaterialThicknessPriceController::class, 'create'])->name('create');        
            Route::post('/create', [CutoutMaterialThicknessPriceController::class, 'store'])->name('store');     
            Route::get('/edit/{id}', [CutoutMaterialThicknessPriceController::class, 'edit'])->name('edit');      
            Route::post('/update/{id}', [CutoutMaterialThicknessPriceController::class, 'update'])->name('update'); 
            Route::delete('/destroy/{id}', [CutoutMaterialThicknessPriceController::class, 'destroy'])->name('destroy');
            Route::get('/view/{id}', [CutoutMaterialThicknessPriceController::class, 'view'])->name('view');
        });
        /*---------------------------------End Cutout Material Thickness Price Controller-------------------------*/      
    });
}); 