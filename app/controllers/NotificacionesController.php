<?php

class NotificacionesController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    public function VerNotificaciones() {
        return View::make('NotificacionesController.listanotificaciones');
    }
    
    public function DatosNotificaciones() {
        $notifiaciones = Notificacion::with('Usuarios')->get();
        $datos = array();
        foreach ($notifiaciones as $notificacion) {
            $notificacion->NombreAutor = (isset($notificacion->usuarios->NombreUsuario)) ? $notificacion->usuarios->NombreUsuario : "Sin Autor";
            $notificacion->Destinatarios = $this->GetDestinatarios($notificacion->IdNotificacion);          
            $datos[] = $notificacion->toArray();
        }

        $datos = json_encode($datos);
        return $datos;
    }

    public function GetDestinatarios($idnotificacion) {    
        $destinatarios = DestinatariosNotificaciones::where('IdNotificacion', '=', $idnotificacion)->get();
        $datos = array();
        foreach ($destinatarios as $destinatario) {
            $datos[] = $destinatario->toArray();
        }
        return $datos;
    }

}
