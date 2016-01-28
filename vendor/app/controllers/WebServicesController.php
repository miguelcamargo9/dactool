<?php

class WebServicesController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Web Services Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::any('/listawebservicios', array('as' => 'listawebservicios', 'uses' => 'WebServicesController@VerWebServices', 'before' => 'authM'));
      |
     */

    public function VerWebServices() {
        $webs = WebServices::all();
        foreach ($webs as $ws) {
            $ws->AutorWS = $ws->Autor->NombreUsuario;
        }
        return View::make('WebServices.listawebservices', array('datos' => $webs));
    }
}
