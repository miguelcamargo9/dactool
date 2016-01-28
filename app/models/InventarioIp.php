<?php

class InventarioIp extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $connection = 'mysql';
	protected $table = 'noglpi_ip_inventory';
    
    public $timestamps = false;
     
    public function RangoIp() {
        return $this->belongsTo('RangoIp', 'RangeId', 'Id');
    }
    
    public function StateIp() {
        return $this->belongsTo('StateIp', 'Status', 'ID');
    }
}