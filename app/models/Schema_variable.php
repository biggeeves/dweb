<?php
class Schema_variable  extends Eloquent {
    protected $table = 'Schema_variable';
    protected $guarded = array('_token','id','table_name','variable_name');
    protected $primaryKey = 'id';
    protected $fillable = array('variable_label');
    public $timestamps = false;
}
?>
