<?php

class ValueSchemaController extends BaseController {

    public function showValueSchema ($crf, $varName) {
        
        $DBConfig = Db_config::first()->toArray();
        $DBName   = $DBConfig['db_name'];
        $DBCaseId = strtolower($DBConfig['db_caseid']);
        $allTables = DB::select('SHOW TABLES');
        
        if (!isset($varNum) ) $varNum = 1;
        $nextVarNum = $varNum + 1;
        $prevVarNum = $varNum - 1;
        if ( $prevVarNum < 1 ) $prevVarNum = 1;
        foreach ($allTables as $tablename) {
            foreach($tablename as $key=>$value) {
                if( substr( $value, 0, 3)  == 'crf') {
                    $firstTable = $value;
                }
            }
        }
        if (!isset( $crf ) ) $crf = $firstTable;

        $tableMeta  = Schema_table::where('table_name', '=', $crf)->first();
        if(!$tableMeta) {
            Session::flash('message', "Incorrect Table Name");
            return View::make('error')->with('tables', $allTables);          
        }
        $tableLabel = $tableMeta->table_label;
        $valueSchema  = Schema_value_labels::where('table_name', '=', $crf)
            ->where('variable_name', $varName)
            ->first();
        // Handle nothing returned
        if (count($valueSchema) == 0) {
            Session::flash('message', "No Value Labels Schema Returned");
            return View::make('error')->with('tables', $allTables);
        }
        
        $valueSchema->toArray();

        return View::make('schema_value_labels')
            ->with('DBName', $DBName)               
            ->with('tables', $allTables)
            ->with('crf', $crf)
            ->with('tableLabel', $tableLabel)
            ->with('varLine', $valueSchema)
            ->with('nextLabelNum', $nextVarNum)
            ->with('prevLabelNum', $prevVarNum);
    }
}