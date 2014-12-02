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

Route::get( 'sir_table', function() 
{
	$requestedCRF ='';
		if (Input::has( 'crf' ) ) {
		$requestedCRF = Input::get('crf');
	 }
	 
	if ($requestedCRF == 'crf_ptrack') {
		if (Input::has( 'slname' ) ) {
			$someLastName = Input::get('slname');
		}
	}
	/* $crf_list = DB::select( DB::raw('SELECT * FROM crf_Ptrack WHERE SLNAME LIKE "$someLastName"'), array(1) ); */

	if (!isset( $requestedCRF ) ) $requestedCRF = 'crf_Ptrack';
	if (!isset( $someLastName ) ) $someLastName  = 'ESCANO';
	
	$crf_list = DB::table( 'crf_ptrack' )->where('SLNAME', 'LIKE', $someLastName)->lists('SLNAME');
	$ptracks = crf_ptrack::all();

	/* $ptracks = DB::select('select * from crf_ptrack ', array(1)); */
	 $columns = Schema::getColumnListing( $requestedCRF );

     return View::make('sir_table')->with( 'ptracks', $ptracks)->with('tableName', $requestedCRF)->with('columns', $columns)
	 ->with( 'this_crf', $requestedCRF) ->with( 'lol', $crf_list);

});


Route::get( 'generic', function() 
{
	 if (Input::has( 'crf' ) ) {
		$requestedCRF = Input::get('crf');
	 }
	 
	 if (Input::has( 'caseid' ) ) {
		$caseid = Input::get('caseid');
	 }

	if (!isset( $requestedCRF ) ) $requestedCRF = 'crf_Ptrack';
	
	if ( isset( $caseid ) ) {
		$this_crf = DB::table( $requestedCRF) ->where('ID_NUM', $caseid)->first();
	}
	else {
		$this_crf = DB::table( $requestedCRF) -> get();
	}


	$allTables = DB::select('SHOW TABLES');

    $columns = Schema::getColumnListing( $requestedCRF );
	
	if ( isset( $caseid ) ) {
		return View::make('generic_form')->with( 'crf', $this_crf)->with('tableName', $requestedCRF)->with('columns', $columns)
		->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables ) ;
	}
	else {
		return View::make('generic_table')->with( 'crf', $this_crf)->with('tableName', $requestedCRF)->with('columns', $columns)
		->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables ) ;
	}
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