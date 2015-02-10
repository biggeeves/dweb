<?php

class FormController extends BaseController {

    public function showForm ($crf = Null) {

        $allTables = DB::select('SHOW TABLES');
        $DBConfig  = Db_config::first()->toArray();
        $DBName    = $DBConfig['db_name'];
        $DBCaseId  = strtolower($DBConfig['db_caseid']);
        if (is_null($crf)) {
            Session::flash('message', "Please pick a table");
            return View::make('error')->with( 'tables', $allTables );
        }
        $columns   = Schema::getColumnListing( $crf );
        $crudOperation = 'r';
        if (Input::has('crud')) $crudOperation = Input::get('crud');
        if (Input::has('caseid')) $caseid = Input::get('caseid');
        if (!$columns) {
            Session::flash('message', "Sorry '$crf' was not found");
            return View::make('error')->with( 'tables', $allTables );
        }

        $varSchema = Schema_variable::where('table_name', '=', $crf)->get();
        $allVarInfo = $varSchema->toArray();
        
        foreach ($allVarInfo as $each_var) {
            $varName = $each_var['variable_name'];
            $$varName = new VariableInfo($each_var);
            $$varName->getVarAttributes();
        }
/*         echo "Name: $ccd01->variable_name<br />";
        echo "Label: $ccd01->variable_label<br />";
        echo "Min: $ccd01->variable_range_min<br />";
 */        
        //$allVarInfo->getVarAttributes(); 
        /* echo $allVarInfo->variable_name; */
        
        
/*         
        $x = $varSchema->toArray();
        
        foreach ($x as $y){
            $varName = $y['variable_name'];
            foreach ($y as $key=>$value){
                $z[$varName][$key] = $value;
            }
        }
        echo 'Specific var: '. $z['ccd01']['variable_label'] . '<hr />';
        
        foreach ($z as $y) {
            echo '<hr/>'. $y['variable_name'] .'<br/>';
            foreach ($y as $key=>$value) {
                echo $key.'.'.$value.'<br />';
            }
        }
        return ('done');
        
        return(get_class_methods($varSchema)); */
        
        
        $valueSchema = Schema_value_labels::where('table_name', '=', $crf)->get();
                
        
        if ( ! isset( $caseid ) ) {
            $this_crf = DB::table( $crf) -> get();
/*             if (count($this_crf) == 0) {
                Session::flash('message', "Sorry nothing was found in $crf ");
                return View::make('error')->with( 'tables', $allTables );
            } else { */
                return View::make('generic_table')
                ->with('DBName', $DBName)               
                ->with('db_caseid', $DBCaseId)
                ->with('this_crf', $this_crf) 
                ->with('tableName', $crf)
                ->with('columns', $columns)
                ->with('tables', $allTables ) ;
            //}
        }        

        
        // must increase the select to include keys
        $this_crf = DB::table( $crf) ->where($DBCaseId, $caseid)->first();
        
        if (count($this_crf) == 0) {
            Session::flash('message', "Sorry no $crf were found for $caseid.");
            return View::make('error')->with( 'tables', $allTables );
        }
        
        if ($crudOperation == 'r'  | $crudOperation == 'u'  ) 
        {
            return View::make('crf_form')
                ->with('crud', $crudOperation)
                ->with('this_crf', $this_crf)
                ->with('tableName', $crf)
                ->with('DBName', $DBName)               
                ->with('db_caseid', $DBCaseId)
                ->with('columns', $columns)
                ->with('tables', $allTables )
                ->with('caseid', $caseid)
                ->with('varSchema', $varSchema)
                ->with('valueSchema',$valueSchema);
            }
        Session::flash('message', "Sorry you reached this page.");
        return View::make('error')->with( 'tables', $allTables );
    }
        
      public function updateForm () {
        $allTables = DB::select('SHOW TABLES');
        $DBConfig = Db_config::first()->toArray();
        $DBName   = $DBConfig['db_name'];
        $DBCaseId = strtolower($DBConfig['db_caseid']);
        
        if (Input::has( 'crf' ) ) {
            $crf = Input::get('crf');
        } else {
            Session::flash('message', 'There was an error with the crf value.');
            return View::make('error')->with( 'tables', $allTables );
        }
           
        $varSchema = Schema_variable::where('table_name', '=', $crf)->get();  
        $valueSchema = Schema_value_labels::where('table_name', '=', $crf)->get();
        $tableClass = ucfirst($crf);  // Class names are case sensitive
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
            Session::flash('message', 'There has been an error with the caseid.');
            return View::make('error')->with( 'tables', $allTables ) ;
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

    /* create the validation rules ------------------------    */
        $rules = array();
        // for simplicity just make everything required during development
        foreach ($varSchema->toArray() as $schemaRow) {
            $rules[$schemaRow['variable_name']] = '';
        }    

        // do the validation ----------------------------------
        // validate against the inputs from our form
        $validator = Validator::make(Input::all(), $rules);
        
        
        // check if the validator failed -----------------------
        if ($validator->fails()) {

            // get the error messages from the validator
            $messages = $validator->messages();
            // redirect our user back to the form with the errors from the validator
            return View::make('crf_form')
                ->with('crud', 'u')
                ->with('DBName', $DBName)               
                ->with('db_caseid', $DBCaseId)
                ->with('this_crf', $this_crf)
                ->with('tableName', $crf)
                ->with('columns', $columns)
                ->with('tables', $allTables )
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
            if($eachColumn == 'dccedits') { $fields[$eachColumn] = $tempTable['dccedits']+1;}
            $tempTable->$eachColumn = $fields[$eachColumn];  
        }
        
        $tempTable->save();
        
        $this_crf = DB::table( $crf) ->where($DBCaseId, $caseid)->first();
        Session::flash('message', "Successfully Saved $caseid");


        return View::make('crf_form')
                ->with('crud', 'u')
                ->with('DBName', $DBName)               
                ->with('db_caseid', $DBCaseId)
                ->with('this_crf', $this_crf)
                ->with('tableName', $crf)
                ->with('columns', $columns)
                ->with('tables', $allTables )
                ->withErrors($validator)
                ->with('caseid', $caseid)
                ->with('varSchema', $varSchema)
                ->with('valueSchema',$valueSchema);
    }
}