<?php


class ShowTables {
   public $allTables;

   public function __construct()
   {
      $this->allTables = DB::select('SHOW TABLES');
   }

   public function firstTable () {
   }

}
?>
