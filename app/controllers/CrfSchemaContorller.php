<?php

class CrfSchemaController extends BaseController {

    public function showCrfSchema ($crf) {
        
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

        $DBConfig = Db_config::first()->toArray();
        $DBName   = $DBConfig['db_name'];
        $DBCaseId = strtolower($DBConfig['db_caseid']);
        
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
            ->with('DBName', $DBName)               
            ->with( 'tables', $allTables )
            ->with( 'tableLabel', $tableLabel)
            ->with( 'crf', $crf)
            ->with( 'columnNames', $columnNames)
            ->with( 'varTable', $varLine );
    }
}