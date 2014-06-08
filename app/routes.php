<?php


/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 *	Models are bson encoded objects (mongoDB)
 */
Route::model('users', 'User');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::group(array('prefix' => 'v1'), function(){
    

    Route::post('users/auth',           array('as' => 'v1.users.auth', 		'uses' => 'UserController@authenticate') );
    // Route::post('users/forgot',         array('as' => 'v1.users.forgot',    'uses' => 'UserController@forgot') );
    // Route::post('users/reset',          array('as' => 'v1.users.reset',     'uses' => 'UserController@resetPassword') );

    Route::resource('users', 'UserController', array('except' => array('create', 'edit', 'update', 'destroy')) );

    //	user needs to have a registered and active token
    Route::group(array('before' => 'logged_in'), function() {

        Route::post( 'users/logout', array('as' => 'v1.users.logout', 'uses' => 'UserController@logout') );

       
        Route::group(array('prefix' => 'users/{users}'), function() {

        });

    });
    

});