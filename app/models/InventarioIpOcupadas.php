<?php

class InventarioIpOcupadas extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    protected $connection = 'mysql';
	protected $table = 'noglpi_ip_inventory_ocupadas';
    
    public $timestamps = false;
     
}