<?php

class Tarea extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CronJobs';
     
    public $timestamps = false;
    
    public function Usuario() {
        return $this->belongsTo('Usuarios', 'Usuario', 'NickNameUsuario');
    }
    
}