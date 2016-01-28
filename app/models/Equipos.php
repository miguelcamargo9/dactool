<?php

class Equipos extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $connection = 'mysql';
	protected $table = 'glpi_networking';
    
    public $timestamps = false;
     
    public function Fabricante() {
        return $this->belongsTo('Fabricante', 'FK_glpi_enterprise', 'ID');
    }
    
    public function Ubicacion() {
        return $this->belongsTo('Ubicacion', 'location', 'ID');
    }
    
    public function Tipo() {
        return $this->belongsTo('TipoEquipos', 'type', 'ID');
    }
    
}