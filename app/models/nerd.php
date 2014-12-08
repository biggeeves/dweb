<?php

class Nerd extends Eloquent {
	protected $table = 'crf_ptrack';
	protected $guarded = array('_token');
	protected $fillable = array('sfname', 'slname', 'status');
	protected $primaryKey = 'id_num';
	public $timestamps = false;
}