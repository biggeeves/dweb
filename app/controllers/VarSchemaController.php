<?php

class VarSchemaController extends BaseController {

    public function showVarSchema ($crf, $varNum) {
        
        $DBConfig = Db_config::first()->toArray();
        $DBName   = $DBConfig['db_name'];
        $DBCaseId = strtolower($DBConfig['db_caseid']);
        
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

        return View::make('schema_var')
            ->with('DBName', $DBName)               
            ->with('tables', $allTables)
            ->with('crf', $crf)
            ->with('tableLabel', $tableLabel)
            ->with('varLine', $varLine)
            ->with('prevVarNum', $prevVarNum)
            ->with('thisVarNum', $varNum)
            ->with('nextVarNum', $nextVarNum);
    }
    
    
    public function updateVarSchema () {
            
        $DBConfig = Db_config::first()->toArray();
        $DBName   = $DBConfig['db_name'];
        $DBCaseId = strtolower($DBConfig['db_caseid']);
        
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
            return View::make('schema_var')
                ->with('DBName', $DBName)               
                ->with('tables', $allTables)
                ->with('crf', $crf)
                ->with('tableLabel', $tableLabel)
                ->with('varLine', $varLine)
                ->with('nextVarNum', $nextVarNum)
                ->with('prevVarNum', $prevVarNum)
                ->withErrors($validator);

        }

        $varSchema = Schema_variable::where('id', '=', $id)->first();
            
        // return (get_class_methods($varSchema));
        $varSchema->variable_name = $variable_name;		
        $varSchema->variable_label = $variable_label;
        // return (get_class_methods($varSchema));
        // $reflector = new ReflectionClass($varSchema);
        // return ($reflector->getFileName());
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

        return View::make('schema_var')
            ->with('DBName', $DBName)               
            ->with('tables', $allTables)
            ->with('crf', $table_name)
            ->with('tableLabel', $tableLabel)
            ->with('varLine', $varLine)
            ->with('nextVarNum', $nextVarNum)
            ->with('prevVarNum', $prevVarNum);
    }
}