<?php

use App\Http\Controllers\Admin\DashboardController;
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

Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function () {
        Route::prefix('admin-users')->name('admin-users/')->group(static function () {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });

        Route::prefix('projects')->name('projects/')->group(static function () {
            Route::get('/',                                             'ProjectsController@index')->name('index');
            Route::get('/create',                                       'ProjectsController@create')->name('create');
            Route::post('/',                                            'ProjectsController@store')->name('store');
            Route::get('/{project}/edit',                               'ProjectsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ProjectsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{project}',                                   'ProjectsController@update')->name('update');
            Route::delete('/{project}',                                 'ProjectsController@destroy')->name('destroy');
        });

        Route::prefix('timekeepings')->name('timekeepings/')->group(static function () {
            Route::get('/',                                             'TimekeepingController@index')->name('index');
            Route::get('/create',                                       'TimekeepingController@create')->name('create');
            Route::post('/',                                            'TimekeepingController@store')->name('store');
            Route::get('/{timekeeping}/edit',                           'TimekeepingController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'TimekeepingController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{timekeeping}',                               'TimekeepingController@update')->name('update');
            Route::put('/{timekeeping}/approve',                        'TimekeepingController@approve');
            Route::put('/{timekeeping}/reject',                         'TimekeepingController@reject');
            Route::delete('/{timekeeping}',                             'TimekeepingController@destroy')->name('destroy');
        });

        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');

        Route::get('/dashboard-e', [DashboardController::class, 'employee']);
        Route::get('/dashboard-a', [DashboardController::class, 'admin']);
    });
});
