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


Route::get('/', function()
{
	 return View::make( 'hello' );
});

Route::get( 'users', function() 
{
     $users = User::all();

	 return View::make( 'users' )->with( 'users', $users);
});


Route::get( 'trial', function() 
{
     $trials = Trial::all();
     // $trials = Trial::where('id_num', '=', 'W05004');
     // $trials = Trial::where('id_num', 'LIKE', '%W%');
     // $trials = Trial::where('STATUS','<',4);
	 //$trials = Trial::all()->where('id_num', 'W05004');
	 $thisCaseID = 'W05004';
     $trials = Trial::where('id_num', '=', $thisCaseID)->get();

	 return View::make( 'trial' )->with( 'trials', $trials);
});

Route::get( 'sir_table', function() 
{
    $allTables = DB::select('SHOW TABLES');

	$requestedCRF ='';
		if (Input::has( 'crf' ) ) {
		$requestedCRF = Input::get('crf');
	 }
	 
	if ($requestedCRF == 'crf_ptrack') {
		if (Input::has( 'slname' ) ) {
			$someLastName = Input::get('slname');
		}
	}
	/* $crf_list = DB::select( DB::raw('SELECT * FROM crf_Ptrack WHERE slname LIKE "$someLastName"'), array(1) ); */

	if (!isset( $requestedCRF ) ) $requestedCRF = 'crf_Ptrack';
	if (!isset( $someLastName ) ) $someLastName  = 'ESCANO';
	
	$crf_list = DB::table( 'crf_ptrack' )->where('slname', 'LIKE', $someLastName)->lists('slname');
	$ptracks = crf_ptrack::all();

	/* $ptracks = DB::select('select * from crf_ptrack ', array(1)); */
	 $columns = Schema::getColumnListing( $requestedCRF );

     return View::make('sir_table')->with( 'ptracks', $ptracks)->with('tableName', $requestedCRF)->with('columns', $columns)
	 ->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables );

});


Route::get( 'generic', function() 
{
    
	if (Input::has('crud')) {
		$crudOperation = Input::get('crud');
	 }
	if (!isset( $crudOperation ) ) $crudOperation = 'r';

	if (Input::has( 'crf' ) ) {
		$requestedCRF = Input::get('crf');
	 }
	 
	if (!isset( $requestedCRF ) ) $requestedCRF = 'crf_ptrack';

    $varSchema = SchemaVariable::where('table_name', '=', $requestedCRF)->get();
    $valueSchema = SchemaValueLabel::where('table_name', '=', $requestedCRF)->get();

if (Input::has( 'caseid' ) ) {
		$caseid = Input::get('caseid');
	 }

	if ( isset( $caseid ) ) {
		$this_crf = DB::table( $requestedCRF) ->where('id_num', $caseid)->first();
	}
	else {
		$this_crf = DB::table( $requestedCRF) -> get();
	}


	$allTables = DB::select('SHOW TABLES');

    $columns = Schema::getColumnListing( $requestedCRF );
	
	if (isset( $caseid )) {
		if ($crudOperation == 'r') 
		{
			return View::make('generic_form')->with( 'crf', $this_crf)->with('tableName', $requestedCRF)->with('columns', $columns)
			->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables )->with('caseid', $caseid)
            ->with('varSchema', $varSchema)->with('valueSchema',$valueSchema);
		} elseif ($crudOperation == 'u') 
		{ 
			return View::make('generic_form_update')->with( 'crf', $this_crf)->with('tableName', $requestedCRF)->with('columns', $columns)
			->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables )->with('caseid', $caseid)
            ->with('varSchema', $varSchema)->with('valueSchema',$valueSchema);
		}
	}
	else {
		return View::make('generic_table')->with( 'crf', $this_crf)->with('tableName', $requestedCRF)->with('columns', $columns)
		->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables ) ;
	}
	return View::make('hello');
});


Route::get( 'sir_form', function() 
{
     $ptracks = Crf_ptrack::all();
	 $tableName = 'Crf_Ptrack';
	 $columns = Schema::getColumnListing('crf_ptrack');

     return View::make('sir_form')->with( 'ptracks', $ptracks)->with('tableName', $tableName)->with('columns', $columns);

});

Route::get( 'sample_blog', function() 
{
     return View::make('sample_blog');
});

Route::post('crud', function()
{
	if (Input::has( 'crf' ) ) {
		$requestedCRF = Input::get('crf');
	 }
	 
	$slname = Input::get('slname');
	$sfname = Input::get('sfname');
	$statusx = Input::get('status');
	 

if (!isset( $requestedCRF ) ) $requestedCRF = 'crf_ptrack';
    $columns = Schema::getColumnListing( $requestedCRF );

	if (Input::has( 'id_num' ) ) {
		$caseid = Input::get('id_num');
	 }
	if ( isset( $caseid ) ) {
		$this_crf = DB::table( $requestedCRF) ->where('id_num', $caseid)->first();
	}
	$allTables = DB::select('SHOW TABLES');
    
	if (Input::has( 'submit' ) ) {
		$dccSubmit = Input::get('submit');
	 }
    if($dccSubmit == 'delete') {
        if( isset( $caseid ) ) {
            $trials = Trial::where('id_num', '=', $caseid)->first();
            if (isset($trials) ) {
                $trials->delete();
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
	if ($validator->fails()) {

		// get the error messages from the validator
		$messages = $validator->messages();

		// redirect our user back to the form with the errors from the validator
		//return Redirect::to('generic')
		//	->withErrors($validator)->with( 'tables', $allTables );
        return View::make('generic_form_update')->with( 'crf', $this_crf)->with('tableName', $requestedCRF)->with('columns', $columns)
		->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables )->withErrors($validator)->with('caseid', $caseid) ;

}
	
    $trials = Trial::where('id_num', '=', $caseid)->first();
	$trials->slname = $slname;		
	$trials->sfname = $sfname;		
	$trials->status = $statusx;		
	$trials->save();
	
	$this_crf = DB::table( $requestedCRF) ->where('id_num', $caseid)->first();

    return View::make('generic_form_update')->with( 'crf', $this_crf)->with('tableName', $requestedCRF)->with('columns', $columns)
		->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables )->with('caseid', $caseid) ;

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
    
    
Route::get( 'crf_schema/{crf}', function($crf) 
{
    $requestedCRF = $crf;
    if (!isset( $requestedCRF ) ) $requestedCRF = 'crf_ptrack';
    $varSchema = SchemaVariable::where('table_name', '=', $requestedCRF)->get();
    
    foreach( $varSchema as $schemaRow ) {
        $varLine[] = $schemaRow->toArray(); 
    }
    if(empty($varLine) ) $varLine[0] = 'empty';
   
    
    $valueSchema = SchemaValueLabel::where('table_name', '=', $requestedCRF)->get();

    $allTables = DB::select('SHOW TABLES');
    $tableName = $requestedCRF;
    $columns = Schema::getColumnListing('schema_variable');

     return View::make('table_schema')->with('tableName', $tableName)
        ->with('schemaColumn', $columns)
        ->with('tables', $allTables )
        ->with('varLine', $varLine)
        ->with('valueSchema', $valueSchema);

});
