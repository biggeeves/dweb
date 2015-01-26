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


/* first step in Laravel 
 Route::get('/', function()
{
	 return View::make( 'hello' );
});
*/

// This will check the _token for every form submission
Route::when('*', 'csrf', array('post', 'put', 'delete'));  

Route::get('/', array('as' => 'home', function() 
{
	 return View::make( 'hello' );
}));

Route::get('testbed', function(){
    $r = new ReflectionClass('DB');
    var_dump(
        $r->getFilename()
    );
 
    var_dump(
        $r->getName()
    );
});

Route::get('/register', 'RegisterController@showRegister');

Route::post('/register', 'RegisterController@doRegister');

Route::get('/login', function () 
{
    return View::make('login');
});

Route::post('login', function () 
{
    $cred2 = array( "user_login" => Input::get('user_login'),
		"password" => Input::get('user_password')
	);
	
    if (Auth::attempt($cred2)) {
	 // return ( 'You are authenticated' );
        return Redirect::intended('/');
    }
       
	$x_debug = implode(",", $cred2 ) ;
    $hashedPassword = Hash::make('mypassword');
    if (Hash::check(Input::get('user_password'), $hashedPassword)) {   
        return ('password match<br>' . Input::get('user_password'). "=" . $hashedPassword); 
    }
	
    Session::flash('message', $x_debug);

    return ( var_dump(Auth::attempt($cred2) ) );
    return Redirect::to('login');
});

Route::get('/logout', function () 
{
    Auth::logout();
    return View::make('logout');
});

// Route::get('login', array('as' => 'login', function () {return 'login'; }))->before('guest');

// Route::post('login', function () { });

// Route::get('logout', array('as' => 'logout', function () { }))->before('auth');

Route::get('profile', array('as' => 'profile', function () { }))->before('auth');

Route::get('signup', function() {
    return View:: make('signup');
});

Route::post('thanks', function() {
    $theEmail = Input::get('email');
    return View::make('thanks')->with('theEmail', $theEmail);
});

/*
Route::get('/a', array(
    'before' => 'newYear',
    function () {
    Return "You blah blah";
    }
    )
);
*/
Route::get('/a', array('before'=>'newYear', 'uses' => 'AController@showWelcome'));

Route::get('/a', 'AController@showWelcome');
Route::get('/b', 'AController@showTable');
Route::get('c/{someVar}', function ($someVar) {
    return "You added {$someVar}";
});
Route::get('/d/{passVar}', 'AController@passVar');
Route::get('/e', array('uses' => 'AController@withArray', 'as' => 'directions'));



Route::get( 'users', function() 
{
     $users = User::all();

	 return View::make( 'users' )->with( 'users', $users);
});


Route::get( 'sir_table', array(
    'before' => 'auth',
    function() 
{
    $allTables = DB::select('SHOW TABLES');
    if (isset($allTables)) {
        foreach ($tables as $tablename) {
            foreach($tablename as $key=>$value) {
            	if( substr( $value, 1, 3)  == 'crf') {
                    $firstTable = $value;
                }
            }
        }
    }

	$crf ='';
		if (Input::has( 'crf' ) ) {
		$crf = Input::get('crf');
	 }
	 
	if ($crf == 'crf_ptrack') {
		if (Input::has( 'slname' ) ) {
			$someLastName = Input::get('slname');
		}
	}
	/* $crf_list = DB::select( DB::raw('SELECT * FROM crf_Ptrack WHERE slname LIKE "$someLastName"'), array(1) ); */

	if (!isset( $crf ) ) $crf = firstTable;
	if (!isset( $someLastName ) ) $someLastName  = 'ESCANO';
	
	$crf_list = DB::table( 'crf_ptrack' )->where('slname', 'LIKE', $someLastName)->lists('slname');
	$ptracks = Crf_ptrack::all();

	/* $ptracks = DB::select('select * from crf_ptrack ', array(1)); */
	 $columns = Schema::getColumnListing( $crf );

     return View::make('sir_table')
        ->with('ptracks', $ptracks)
        ->with('tableName', $crf)
        ->with('columns', $columns)
        ->with('this_crf', $crf) 
        ->with('tables', $allTables);

}));

Route::get('forms/{crf}', ['uses' =>'FormController@showForm', 'as'=>'showForm'] );

Route::post('forms/crud', ['uses' =>'FormController@updateForm', 'as'=>'updateForm'] );

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
    
    
Route::get('crf_schema/{crf?}', ['uses' =>'CrfSchemaController@showCrfSchema', 'as'=>'crfSchema'] );

Route::get('var_schema/{crf}/{varNum}', ['uses' =>'VarSchemaController@showVarSchema', 'as'=>'varSchema'] );

Route::post('var_schema/crud',  ['uses' =>'VarSchemaController@updateVarSchema', 'as'=>'updateVarSchema'] );

Route::get('value_schema/{crf}/{varName}', ['uses' =>'ValueSchemaController@showValueSchema', 'as'=>'valueSchema'] );
