<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ClickController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlackListController;

use App\Http\Controllers\Ajax\AjaxCartController;
use Illuminate\Support\Facades\Auth;
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
//Auth::routes();

//auth routes ******  
Route::get('/sign-in', function () {
    return view('admin.sign-in');
})->name('login');
Route::get('table', function () {
    return view('admin.tables');
});

# login page route
Route::get('/', function () {


    if (Auth::user()  == null)
        return view('admin.sign-in');
    else
        return view('admin.dashboard');
})->name('dashboard');


# register page route
Route::get('/sginup', [AccountController::class, 'register']);


Route::group(['prefix' => 'auth'], function () {
    # login function
    Route::post('/login', [AccountController::class, 'login']);
    // Route::get('/login', function () {

    //     if (Auth::user()  == null)
    //         return view('admin.sign-in');
    //     else
    //         return view('admin.dashboard');
    // });

    # sign up(regestration) function
    Route::post('/signup', [AccountController::class, 'signup']);
});
Route::post('/signup', [AccountController::class, 'signup']);
Route::get('logout', [AccountController::class, 'logout']);
# logout route


//End auth routs. ******


//admin pages routes groupe 
Route::group(['middleware' => 'auth'], function () {

    #edit user
    Route::get('/user/edit/{id}', [AccountController::class, 'edit']);

    // Route::get('/user/doctor',[AccountController::class,'doctor']);
    Route::get('/notification', 'App\Http\Controllers\Admin\notificationController@index');

    # team routes
    Route::resource('team', 'App\Http\Controllers\Admin\TeamController');

    # User Public routes
    Route::resource('user-public', 'App\Http\Controllers\Admin\UserPublicController');

    # palyer routes
    Route::resource('player', 'App\Http\Controllers\Admin\PlayerController');

    # companie routes
    Route::resource('companie', 'App\Http\Controllers\Admin\CompaniesController');


    # prodact routes show form create new prodact 
    Route::get('prodact/create/{id}', 'App\Http\Controllers\Admin\ProductsController@create');

    # prodact routes show form create show all prodact 
    Route::get('prodact/{id}', 'App\Http\Controllers\Admin\ProductsController@index');


    # prodact routes store a new prodact 
    Route::post('prodact/store/{id}', 'App\Http\Controllers\Admin\ProductsController@store');

    # home route
    Route::get('home', [HomeController::class, 'index']);
    # user roles routes
    Route::resource('roles', 'App\Http\Controllers\Admin\UserRoleController');
    # users routes
    Route::resource('users', 'App\Http\Controllers\Admin\UserController');

    # districts routes

    Route::group(['prefix' => 'blacklist'], function () {
        # index route
        Route::get('index', [BlackListController::class, 'index']);
        Route::get('block/{id}', [BlackListController::class, 'block']);
    });
});






//errors pages routes

# sumething error
Route::get('/somethingwrong', function () {
    return view('admin.error.somethingwrong');
});
# parmitions error
Route::get('/unauthorized', function () {
    return view('admin.error.somethingwrong');
});
//End errors routes
