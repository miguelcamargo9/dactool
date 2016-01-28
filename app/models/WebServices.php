<?php

class WebServices extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'WebServices';
     
    public function Autor() {
        return $this->belongsTo('Usuarios', 'AutorWS', 'IdUsuario');
    }
    
}