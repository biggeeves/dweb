<?php

class ValueSchemaController extends BaseController {

    public function showValueSchema ($crf, $varNum) {

        
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

        $tableMeta  = Schema_table::where('table_name', '=', $crf)->first();
        $tableLabel = $tableMeta->table_label;
        $varSchema  = Schema_value_labels::where('table_name', '=', $crf)
            ->where('id', $varNum)->get();
        foreach( $varSchema as $schemaRow ) {
            $varLine[] = $schemaRow->toArray(); 
        }

        return View::make('schema_value_labels')
            ->with('DBName', $DBName)               
            ->with('tables', $allTables)
            ->with('crf', $crf)
            ->with('tableLabel', $tableLabel)
            ->with('varLine', $varLine)
            ->with('nextLabelNum', $nextVarNum)
            ->with('prevLabelNum', $prevVarNum);
    }
}