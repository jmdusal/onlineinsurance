<?php


use App\Http\Controllers\SalesrepController;
use App\Http\Controllers\PayrollController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::group(['middleware' => ['auth', 'disablepreventback']], function () {
    Route::get('/home', 'HomeController@index')->name('home');


    Route::group(['prefix' => 'salesrep'], function () {
        Route::get('/profiles', [SalesrepController::class, 'index'])->name('salesrep.profiles');
        Route::get('/create', [SalesrepController::class, 'create']);
        Route::post('/store', [SalesrepController::class, 'store'])->name('salesrep.store');
        Route::get('/edit/{salesrep_id}', [SalesrepController::class, 'edit']);
        Route::patch('/update/{salesrep_id}', [SalesrepController::class, 'update']);
        Route::delete('/destroy/{salesrep_id}', [SalesrepController::class, 'destroy']);
        Route::get('/datatable', [SalesrepController::class, 'datatable'])->name('salesrep.datatable');
    });

    Route::group(['prefix' => 'payroll'], function () {
        Route::get('/index', [PayrollController::class, 'index'])->name('payroll.index');
        Route::get('/create', [PayrollController::class, 'create']);
        Route::post('/store', [PayrollController::class, 'store'])->name('payroll.store');
        Route::get('/edit/{payroll_id}', [PayrollController::class, 'edit']);
        Route::patch('/update/{payroll_id}', [PayrollController::class, 'update'])->name('payroll.update');

        Route::get('/response_data/{payroll_id}', [PayrollController::class, 'response_data'])->name('response.data');
        Route::get('/pdf/{payroll_id}', [PayrollController::class, 'show']);
        Route::delete('/destroy/{payroll_id}', [PayrollController::class, 'destroy']);
        Route::get('/datatable', [PayrollController::class, 'datatable'])->name('payroll.datatable');
    });
});
