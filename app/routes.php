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

Route::when('*', 'csrf', array('post', 'put', 'delete'));  // This will check the _token for every form submission

Route::get('/', array('as' => 'home', function() 
{
	 return View::make( 'hello' );
}));

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
    if (Hash::check(Input::get('user_password'), $hashedPassword))
{   return ('password match<br>' . Input::get('user_password'). "=" . $hashedPassword); 
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
    if (isset($tables)) {
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

     return View::make('sir_table')->with( 'ptracks', $ptracks)->with('tableName', $crf)->with('columns', $columns)
	 ->with( 'this_crf', $crf) ->with( 'tables', $allTables );

}));


Route::get( 'generic/{crf}', function($crf) 
{
    $allTables = DB::select('SHOW TABLES');
    if (isset($allTables)) {
        foreach ($allTables as $tablename) {
            foreach($tablename as $key=>$value) {
            	if( substr( $value, 0, 3)  == 'crf') {
                    $firstTable = $value;
                }
            }
        }
    }

    $DBConfig = Db_config::first()->toArray();
    $DBCaseId = strtolower($DBConfig['db_caseid']);

	if (Input::has('crud')) {
		$crudOperation = Input::get('crud');
	 }
	if (!isset( $crudOperation ) ) $crudOperation = 'r';

	if (!isset( $crf ) ) $crf = $firstTable;

    $varSchema = Schema_variable::where('table_name', '=', $crf)->get();
    $valueSchema = Schema_value_labels::where('table_name', '=', $crf)->get();

    if (Input::has( 'caseid' ) ) {
		$caseid = Input::get('caseid');
	 }

	if ( isset( $caseid ) ) {
		$this_crf = DB::table( $crf) ->where($DBCaseId, $caseid)->first();
	}
	else {
		$this_crf = DB::table( $crf) -> get();
	}

	$allTables = DB::select('SHOW TABLES');

    $columns = Schema::getColumnListing( $crf );
	
	if (isset( $caseid )) {
		if ($crudOperation == 'r'  | $crudOperation == 'u'  ) 
		{
			return View::make('generic_form')
            ->with('crud', $crudOperation)
            ->with('crf', $this_crf)
            ->with('tableName', $crf)
            ->with('db_caseid', $DBCaseId)
            ->with('columns', $columns)
            ->with('tables', $allTables )
            ->with('caseid', $caseid)
            ->with('varSchema', $varSchema)
            ->with('valueSchema',$valueSchema);
		}
	}
	else {
		return View::make('generic_table')
        ->with('db_caseid', $DBCaseId)
        ->with('crf', $this_crf)
		->with('this_crf', $crf) 
        ->with('tableName', $crf)
        ->with('columns', $columns)
        ->with('tables', $allTables ) ;
	}
	return View::make('hello');
});


Route::post('crud', function()
{
	if (Input::has( 'crf' ) ) {
		$crf = Input::get('crf');
	}
    $tableClass = ucfirst($crf);
	 
    $slname =  Input::get('slname');
	$sfname =  Input::get('sfname');
	$statusx = Input::get('status');
    
    $DBConfig = Db_config::first()->toArray();
    $DBCaseId = strtolower($DBConfig['db_caseid']);
    $varSchema = Schema_variable::where('table_name', '=', $crf)->get();
    $valueSchema = Schema_value_labels::where('table_name', '=', $crf)->get();
    
    $allTables = DB::select('SHOW TABLES');
    foreach ($allTables as $tablename) {
        foreach($tablename as $key=>$value) {
          	if( substr( $value, 1, 3)  == 'crf') {
                $firstTable = $value;
            }
        }
    }
    if (!isset( $crf ) ) return ('There was an error with the crf value');
    $columns = Schema::getColumnListing( $crf );
    foreach ($columns as $eachColumn) {
        $fields[$eachColumn] = Input::get($eachColumn);  
    }
	if (Input::has( $DBCaseId ) ) {
		$caseid = Input::get($DBCaseId);
    }
	if ( isset( $caseid ) ) {
		$this_crf = DB::table( $crf) ->where($DBCaseId, $caseid)->first();
    } else {
        return ('There has been an error with the caseid');
    }
    
	if (Input::has( 'submit' ) ) {
		$dccSubmit = Input::get('submit');
    }
    if($dccSubmit == 'delete') {
        $crud = 'd';

        if( isset( $caseid ) ) {
                $tempTable = $tableClass::where($DBCaseId, '=', $caseid)->first();
            if (isset($tempTable) ) {
                $tempTable->delete();
                Session::flash('message', "Successfully deleted $caseid");
            } else{
                Session::flash('message', "Sorry, That record could not be found.  Try something else.");
            }
            return View::make('index')->with( 'tables', $allTables ) ;
        }
    }

// create the validation rules ------------------------
	$rules = array(
		'slname'             => 'required', 						// just a normal required validation
		'sfname'            => 'required', 	// required and must be unique in the ducks table
		'status'         => 'integer|min:0|max:44'
	);
    
   	// do the validation ----------------------------------
	// validate against the inputs from our form
	$validator = Validator::make(Input::all(), $rules);
    
    
   	// check if the validator failed -----------------------
	if ($validator->passes()) {

		// get the error messages from the validator
		$messages = $validator->messages();

		// redirect our user back to the form with the errors from the validator
        return View::make('generic_form')
        ->with( 'crud', 'u')
        ->with( 'crf', $this_crf)
        ->with('tableName', $crf)
        ->with('columns', $columns)
		->with( 'tables', $allTables )
        ->withErrors($validator)
        ->with('caseid', $caseid)
        ->with('varSchema', $varSchema)
        ->with('valueSchema',$valueSchema);
    }
	
    $tempTable = $tableClass::where($DBCaseId, '=', $caseid)->first();
    
    foreach ($columns as $eachColumn) {
    // General Improvement
    // must figure out how to handle dates and times properly!!!!
        if($eachColumn == 'mhdate') {
            $fields[$eachColumn] = date('Y-m-d', strtotime(str_replace('-', '/', $fields[$eachColumn])));
        }
        if($eachColumn == 'dccdate') continue;
        if($eachColumn == 'dcctime') continue;
        if($eachColumn == 'updated_at') continue;
        if($eachColumn == 'created_at') continue;
        if($eachColumn == 'dstamp') continue;
        $tempTable->$eachColumn = $fields[$eachColumn];  
    }
    
	//$tempTable->slname = $slname;		
	//$tempTable->sfname = $sfname;		
	//$tempTable->status = $statusx;		
	$tempTable->save();
	
	$this_crf = DB::table( $crf) ->where($DBCaseId, $caseid)->first();

    return View::make('generic_form')
            ->with('crud', 'u')
            ->with('crf', $this_crf)
            ->with('tableName', $crf)
            ->with('columns', $columns)
            ->with('tables', $allTables )
            ->withErrors($validator)
            ->with('caseid', $caseid)
            ->with('varSchema', $varSchema)
            ->with('valueSchema',$valueSchema);

});

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
    
    
Route::get('crf_schema/{crf}', function($crf) 
{
    $allTables = DB::select('SHOW TABLES');
    foreach ($allTables as $tablename) {
        foreach($tablename as $key=>$value) {
          	if( substr( $value, 1, 3)  == 'crf') {
                $firstTable = $value;
            }
        }
    }
    if (!isset( $crf ) ) $crf = $firstTable;
    $tableMeta = Schema_table::where('table_name', '=', $crf)->first();
    if(!$tableMeta) {
       $tableLabel = 'NA';
    } else {
        $tableLabel = $tableMeta->table_label;
    }
    
    $varTable = Schema_variable::where('table_name', '=', $crf)->get();
    if( count($varTable) == 0 ){
        return ('That table does not have any associated schema');
    }else{
        foreach( $varTable as $schemaRow ) {
            $varLine[] = $schemaRow->toArray(); 
        }
    }
    
    $columnNames = Schema::getColumnListing('schema_variable');

     return View::make('table_schema')
        ->with( 'tables', $allTables )
        ->with( 'tableLabel', $tableLabel)
        ->with( 'crf', $crf)
        ->with( 'columnNames', $columnNames)
        ->with( 'varTable', $varLine );

});

Route::get( 'var_schema/{crf}/{varNum}', function($crf, $varNum) 
{
    if (!isset($varNum) ) $varNum = 1;
    $nextVarNum = $varNum + 1;
    $prevVarNum = $varNum - 1;
    if ( $prevVarNum < 1 ) $prevVarNum = 1;
    $allTables = DB::select('SHOW TABLES');
    foreach ($allTables as $tablename) {
        foreach($tablename as $key=>$value) {
          	if( substr( $value, 1, 3)  == 'crf') {
                $firstTable = $value;
            }
        }
    }
    if (!isset( $crf ) ) $crf = $firstTable;

    $tableMeta = Schema_table::where('table_name', '=', $crf)->first();
    $tableLabel = $tableMeta->table_label;
    $varSchema = Schema_variable::where('table_name', '=', $crf)
        ->where('id', $varNum)->get();
    foreach( $varSchema as $schemaRow ) {
        $varLine[] = $schemaRow->toArray(); 
    }


    return View::make('schema_var_update')
    ->with( 'tables', $allTables )
    ->with( 'crf', $crf)
    ->with( 'tableLabel', $tableLabel)
    ->with( 'varLine', $varLine)
    ->with( 'nextVarNum', $nextVarNum)
    ->with( 'prevVarNum', $prevVarNum)
    ;
});

Route::post( 'var_schema/crud', function() 
{
    $allTables = DB::select('SHOW TABLES');
    foreach ($allTables as $tablename) {
        foreach($tablename as $key=>$value) {
          	if( substr( $value, 1, 3)  == 'crf') {
                $firstTable = $value;
            }
        }
    }
    $id = Input::get('id');
	$table_name = Input::get('table_name');
	$variable_name = Input::get('variable_name');
    $variable_label = Input::get('variable_label');

    $dccSubmit = Input::get('submit');

    $tableMeta = Schema_table::where('table_name', '=', $table_name)->first();
    $tableLabel = $tableMeta->table_label;
    
    if ($dccSubmit == 'Delete') return ('Deletions Currently NOT allowed');
    
    // create the validation rules ------------------------
	$rules = array(
		'id'             => 'required', 		
		'table_name'     => 'required', 	
		'variable_name'  => 'required',
		'variable_label'  => 'required'
	);
    
   	// do the validation ----------------------------------
	// validate against the inputs from our form
	$validator = Validator::make(Input::all(), $rules);
    
    
   	// check if the validator failed -----------------------
	if ($validator->fails()) {

		// get the error messages from the validator
		$messages = $validator->messages();

		// redirect our user back to the form with the errors from the validator
		//return Redirect::to('generic')
		//	->withErrors($validator)->with( 'tables', $allTables );
        return View::make('schema_var_update')
            ->with( 'tables', $allTables )
            ->with( 'crf', $crf)
            ->with( 'tableLabel', $tableLabel)
            ->with( 'varLine', $varLine)
            ->with( 'nextVarNum', $nextVarNum)
            ->with( 'prevVarNum', $prevVarNum)
            ->withErrors($validator);

    }


    $varSchema = Schema_variable::where('id', '=', $id)->first();
        
    // return (get_class_methods($varSchema));
	$varSchema->variable_name = $variable_name;		
	$varSchema->variable_label = $variable_label;		
    $varSchema->save();
    Session::flash('message', "Successfully Saved");
    
    $varSchema = Schema_variable::where('table_name', '=', $table_name)
        ->where('id', $id)->get();
    foreach( $varSchema as $schemaRow ) {
        $varLine[] = $schemaRow->toArray(); 
    }
    $nextVarNum = $id + 1;
    $prevVarNum = $id - 1;
    if ( $prevVarNum < 1 ) $prevVarNum = 1;

    return View::make('schema_var_update')
    ->with( 'tables', $allTables )
    ->with( 'crf', $table_name)
    ->with( 'tableLabel', $tableLabel)
    ->with( 'varLine', $varLine)
    ->with( 'nextVarNum', $nextVarNum)
    ->with( 'prevVarNum', $prevVarNum)
    ;
});

