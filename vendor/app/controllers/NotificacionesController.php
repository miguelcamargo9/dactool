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
        $conn = DB::connection('DactoolDB');
        $select = "select * from Notificaciones";
        $result = $conn->select($select);

        $datos = array();
        foreach ($result as $notificacion) {
            $selectautor = "select NombreUsuario from Usuarios where IdUsuario = $notificacion->AutorNotificacion";
            $resultautor = $conn->select($selectautor);
            foreach ($resultautor as $autor) {
                $notificacion->AutorNotificacion = $autor->NombreUsuario;
            }
            $notificacion->Destinatarios = $this->GetDestinatarios($notificacion->IdNotificacion, $conn);
            $datos[] = $notificacion;
        }
        $datos = json_encode($datos);
        DB::disconnect('DactoolDB');
        return View::make('NotificacionesController.listanotificaciones', array('datos' => $datos));
    }

    public function GetDestinatarios($idnotificacion, $conn) {
        $select = "select * from DestinatariosNotificaciones where IdNotificacion = $idnotificacion";
        $result = $conn->select($select);

        $datos = array();
        foreach ($result as $notificacion) {
            $datos[] = $notificacion;
        }
        return $datos;
    }

}
