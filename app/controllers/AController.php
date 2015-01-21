<?php

class AController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('a');
	}
	public function passVar($passVar)
	{
		return 'The variable '.$passVar;
	}
    
	public function withArray()
	{
		$theURL = URL::route('directions');
        return "DIRECTIONS go to this URL: $theURL";
	}

public function showTable()
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
                return View::make('crf_form')->with( 'crf', $this_crf)->with('tableName', $requestedCRF)->with('columns', $columns)
                ->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables )->with('caseid', $caseid)
                ->with('varSchema', $varSchema)->with('valueSchema',$valueSchema);
            } elseif ($crudOperation == 'u') 
            { 
                return View::make('crf_form')->with( 'crf', $this_crf)->with('tableName', $requestedCRF)->with('columns', $columns)
                ->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables )->with('caseid', $caseid)
                ->with('varSchema', $varSchema)->with('valueSchema',$valueSchema);
            }
        } else {
            return View::make('generic_table')->with( 'crf', $this_crf)->with('tableName', $requestedCRF)->with('columns', $columns)
            ->with( 'this_crf', $requestedCRF) ->with( 'tables', $allTables ) ;
        }
        return View::make('hello');
    }
}
