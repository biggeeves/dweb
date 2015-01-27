<?php
class Schema_variable  extends Eloquent {
    protected $table = 'Schema_variable';
    protected $guarded = array('_token');
    protected $primaryKey = 'id';
    public $timestamps = false;
}
?>
