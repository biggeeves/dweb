<?php

class PrimaryKeysController extends BaseController {
    public $allTables;
    public $tableInfo = [];
    public $tableKeys = [];
    
    public function showPrimaryKeys () {
        $allTables = DB::select('SHOW TABLES');
        foreach ($allTables as $tablename) {
            foreach($tablename as $key=>$value) {
                if( substr( $value, 0, 3)  == 'crf') {
                    $tableInfo[$value] = Null;
                }
            }
        }
        foreach ($tableInfo as $key=>$value) {
            $tableInfo[$key] = DB::select('SHOW index from ' . $key);
        }
        
        return View::make('primary_keys')
            ->with('tables', $allTables )
            ->with('tableInfo',$tableInfo);
    }           
        
    public function __construct() {
    }
}