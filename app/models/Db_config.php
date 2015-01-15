<?php
class Db_config extends Eloquent {
    protected $table = 'db_config';
    public $fillable= array('db_label','db_type','db_caseid');
}
?>
