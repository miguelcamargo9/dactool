<?php

class ReportesController extends BaseController {
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

    public function VerReportes() {
        $conn = DB::connection('DactoolDB');
        $select = "select * from Reportes";
        $result = $conn->select($select);

        $datos = array();
        foreach ($result as $reporte) {
            $selectautor = "select NombreUsuario from Usuarios where IdUsuario = $reporte->AutorReporte";
            $resultautor = $conn->select($selectautor);
            foreach ($resultautor as $autor) {
                $reporte->AutorReporte = $autor->NombreUsuario;
            }
            $datos[] = $reporte;
        }
        $datos = json_encode($datos);
        DB::disconnect('DactoolDB');
        return View::make('ReportesController.listareportes', array('datos' => $datos));
    }

}
