<?php

class TestBedController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return ('indexed');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $allTables = DB::select('SHOW TABLES');
        $DBConfig  = Db_config::first()->toArray();
        $DBName    = $DBConfig['db_name'];
        $DBCaseId  = strtolower($DBConfig['db_caseid']);
        $found_table = False;
        foreach ($allTables as $tablename) {
            foreach($tablename as $key=>$value) {
                if( substr( $value, 0, 3)  == 'crf') {
                    $firstTable = $value;
                    $found_table = True; 
                    break;
                }
            }
            if($found_table) break;
        }
        if(!$found_table) {
            return ('could not find table');
        }
        $crf = $firstTable;
        $varSchema = Schema_variable::where('table_name', '=', $crf)->get();
        $allVarInfo = $varSchema->toArray();

        echo ('<pre>');
		die (print_r($allVarInfo));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
