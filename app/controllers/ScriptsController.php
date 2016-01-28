<?php

class ScriptsController extends BaseController {
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

    public function VerScripts() {
        $conn = DB::connection('DactoolDB');
        $select = "select * from Scripts";
        $result = $conn->select($select);

        $datos = array();
        foreach ($result as $script) {
            $script->AutorScript = $this->getAuthor($script->AutorScript, $conn);
//            $script->NombreScript = "<a href='verdependencia/$script->IdScript' title='Ver Dependencias del Script'>"
//                    . "$script->NombreScript</a>";
            $file = strstr($script->NombreScript, ".", true);
            $script->ScriptsFather = $this->GetScriptsFather($script->IdScript, $conn);
            $script->log = "<a href='/logs/$file.log' title='Ver log $script->NombreScript' target='log'>"
                    . "<span style='color:black; padding-left:30px' class='glyphicon glyphicon-comment'></span>"
                    . "</a>";
            $datos[] = $script;
        }
        $datosEncode = json_encode($datos);
        DB::disconnect('DactoolDB');
        return View::make('ScriptsController.listascripts', array('datos' => $datosEncode));
    }
    
    public function GetScriptsFather($idscript, $conn) {
        $select = "select * from ScriptsToScripts where IdScriptHijo = $idscript";
        $result = $conn->select($select);

        $datos = array();
        foreach ($result as $script) {
            $detalleScript = "select * from Scripts where IdScript = $script->IdScriptPadre";
            $resultD = $conn->select($detalleScript);
            foreach ($resultD as $scriptD) {
                $scriptD->AutorScript = $this->getAuthor($scriptD->AutorScript, $conn);
                $datos[] = $scriptD;
            }
        }
        return $datos;
    }

    public function VerDependenciaScripts($idscript = null) {
        $conn = DB::connection('DactoolDB');
        $select = "select * from ScriptsToScripts where IdScriptHijo = $idscript";
        $result = $conn->select($select);

        $datos = array();
        foreach ($result as $script) {
            $detalleScript = "select * from Scripts where IdScript = $script->IdScriptPadre";
            $resultD = $conn->select($detalleScript);
            foreach ($resultD as $scriptD) {
                $scriptD->AutorScript = $this->getAuthor($scriptD->AutorScript, $conn);
                $datos[] = $scriptD;
            }
        }
        $selectS = "select * from Scripts where IdScript = $idscript";
        $resultS = $conn->select($selectS);

        foreach ($resultS as $script) {
            $nameScript = $script->NombreScript;
        }
        $datosEncode = json_encode($datos);
        DB::disconnect('DactoolDB');
        return View::make('ScriptsController.listascriptspadres', array('datos' => $datosEncode, 'hijo' => $nameScript));
    }

    public function getAuthor($idautor, $conn) {
        $selectautor = "select NombreUsuario from Usuarios where IdUsuario = $idautor";
        $resultautor = $conn->select($selectautor);
        $resultadoAutor = "";
        foreach ($resultautor as $autor) {
            $resultadoAutor = $autor->NombreUsuario;
        }
        return $resultadoAutor;
    }

}
