<?php

class ListStatsController extends BaseController {
    public $allTables;
    public $tableCounts = [];
    
    public function showListStats () {
        $allTables = DB::select('SHOW TABLES');
        foreach ($allTables as $tablename) {
            foreach($tablename as $key=>$value) {
                if( substr( $value, 0, 3)  == 'crf') {
                    $tableCounts[$value] = Null;
                }
            }
        }
        foreach ($tableCounts as $key=>$value) {
            $tableCounts[$key] = DB::table($key)->count();
        }
        return View::make('list_stats')
            ->with('tableCounts',$tableCounts)
            ->with( 'tables', $allTables );
    }           
        
    public function __construct() {
    }
}