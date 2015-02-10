<?php

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


// This will check the _token for every form submission
Route::when('*', 'csrf', array('post', 'put', 'delete'));  

Route::get('/', array('as' => 'home', function() 
{
	 return View::make( 'hello' );
}));

Route::resource('/testbed', 'TestBedController');

Route::get('/register', 'RegisterController@showRegister');

Route::post('/register', 'RegisterController@doRegister');

Route::get('/login', function () 
{
    return View::make('login');
});

Route::post('login', function () 
{
    // validate the info, create rules for the inputs
    $rules = array(
        'user_login' => 'required|alphaNum|min:3',
        'user_password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
    );

    // run the validation rules on the inputs from the form
    $validator = Validator::make(Input::all(), $rules);
    
    if ($validator->fails()) {
        Session::flash('message', 'Invalid');
        return Redirect::to('login')
        ->withErrors($validator) // send back all errors to the login form
        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
    } 
    
    
    $credentials = array( "username" => Input::get('user_login'),
        "password" => Input::get('user_password')
	);
     
    if (Auth::attempt($credentials)) {
        Session::flash('message', 'YOU MADE IT THROUGH!');
        return Redirect::intended('/');
    }
       
	$x_debug = implode(",", $credentials ) ;
    $hashedPassword = Hash::make('ASDFASDF');
    if (Hash::check(Input::get('user_password'), $hashedPassword)) {   
        return ('password match<br>' . Input::get('user_password'). "=" . $hashedPassword); 
    }
	
    Session::flash('message', $x_debug);

    // return ( var_dump(Auth::attempt($credentials) ) );
    return Redirect::to('login');
});

Route::get('/logout', function () 
{
    Auth::logout();
    return View::make('logout');
});

Route::get('signup', function() {
    return View:: make('signup');
});

Route::post('thanks', function() {
    $theEmail = Input::get('email');
    return View::make('thanks')
    ->with('theEmail', $theEmail);
});

Route::get('/a', array('before'=>'newYear', 'uses' => 'AController@showWelcome'));
Route::get('/d/{passVar}', 'AController@passVar');
Route::get('/e', array('uses' => 'AController@withArray', 'as' => 'directions'));

Route::get( 'users', function() 
{
     $users = User::all();

	 return View::make( 'users' )
     ->with( 'users', $users);
});

Route::get('liststats/', ['before'=>'auth',
    'uses' =>'ListStatsController@showListStats', 
    'as'=>'showListStats'] 
);
Route::get('forms/{crf?}', ['before'=>'auth',
    'uses' =>'FormController@showForm', 
    'as'=>'showForm'] 
);

Route::post('forms/crud', ['before'=>'auth','before' => 'csrf',
    'uses' =>'FormController@updateForm',
    'as'=>'updateForm'] 
);

Route::get('nerd/edit/{id_num}', array('as' => 'nerd.edit', function($id_num) 
{
	$allTables = DB::select('SHOW TABLES');
		// return our view and Nerd information
		return View::make('nerd-edit') // pulls app/views/nerd-edit.blade.php
			->with('nerd', Nerd::find($id_num))  ->with( 'tables', $allTables );
	}));

	// route to process the form
	Route::post('nerd/edit', function() {
		// process our form
});
    
    
Route::get('crf_schema/{crf?}', ['before'=>'auth', 
    'uses' =>'CrfSchemaController@showCrfSchema',
    'as'=>'crfSchema'] 
);

Route::get('var_schema/{crf}/{varNum}', ['before'=>'auth', 
    'uses' =>'VarSchemaController@showVarSchema',
    'as'=>'varSchema'] 
   
);

Route::post('var_schema/crud',  ['before'=>'auth',  
    'uses' =>'VarSchemaController@updateVarSchema',
    'as'=>'updateVarSchema'] 
);

Route::get('value_schema/{crf}/{varName}', ['before'=>'auth',  
    'uses' =>'ValueSchemaController@showValueSchema', 
    'as'=>'valueSchema'] 
);
