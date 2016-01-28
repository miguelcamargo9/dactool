<?php

class Notificacion extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Notificaciones';
     
    public $timestamps = false;
    
    public function Usuarios() {
        return $this->belongsTo('Usuarios', 'AutorNotificacion', 'IdUsuario');
    }
    
}