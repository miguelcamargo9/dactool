<?php

class AdminController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | ADMIN Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    public function showMenu() {
        $interfaces = Interfaz::all();
        $menus = array();
        foreach ($interfaces as $interfaz) {
            if (isset($interfaz->IDPadre)) {
                $menus[$interfaz->IDPadre]['Hijos'][] = $interfaz->toArray();
            } else {
                $menus[$interfaz->ID] = $interfaz->toArray();
            }
        }
        return View::make('layouts.bootstrapmenu', array('Interfaces' => $menus));
    }

    public function newInterfazPerfil() {
        $enviado = Input::get('enviado');
        $error = false;
        if (isset($enviado)) {
            $InterPerf = InterfazPerfiles::where('IdPerfil', '=', Input::get('IdPerfil'))
                                        ->where('IdInterfaz', '=', Input::get('IdInterfaz'))->count();
            if($InterPerf === 0){
                $InterfazPerfiles = new InterfazPerfiles;
                $InterfazPerfiles->IdPerfil = Input::get('IdPerfil');
                $InterfazPerfiles->IdInterfaz = Input::get('IdInterfaz');
                $InterfazPerfiles->save();
                $mensaje = "Menu Asignado con Exito";
            } else{
                $error = true;
                $mensaje = "Este Perfil ya tiene asociado este Menu";
            }
        } else{
            $mensaje = (Input::get('mensaje')) ? Input::get('mensaje') : '';
        }
        
        $Interfaces = $this->GetInterfaces();
        $Perfiles = $this->GetPerfiles();
        return View::make('AdminController.interfacesperfiles', array('Interfaces' => $Interfaces, 'Perfiles' => $Perfiles, 'mensaje' => $mensaje, 'error' => $error));
    }

    public function GetInterfaces() {
        $result = Interfaz::all();
        $Interfaces = array();
        foreach ($result as $value) {
            $Interfaces[$value->ID] = $value->DisplayName;
        }
        return $Interfaces;
    }

    public function GetPerfiles() {
        $result = Perfiles::all();
        $Perfiles = array();
        foreach ($result as $value) {
            $Perfiles[$value->ID] = $value->Perfil;
        }
        return $Perfiles;
    }

    public function getInterPerfiles() {
        $interfacesPerfiles = Interfaz::join('InterfazPerfiles', 'InterfazPerfiles.IdInterfaz', '=', 'Interfaz.ID')
                        ->join('Perfiles', 'Perfiles.ID', '=', 'InterfazPerfiles.IdPerfil')
                        ->select('Interfaz.DisplayName', 'Perfiles.Perfil', 'IdInterfaz', 'IdPerfil')
                        ->orderBy('Interfaz.ID', 'asc')->get();

        $datos = array();

        foreach ($interfacesPerfiles->toArray() as $intperf) {
            $intperf['Eliminar'] = "<div class='text-center'><a href='desasignarint/{$intperf['IdInterfaz']}/{$intperf['IdPerfil']}' title='Desasignar'>"
                    . "<span style='color:#FA5858; padding-left:15px' class='glyphicon glyphicon-remove'></span>"
                    . "</a></div>";
            $datos[] = $intperf;
        }
        $datos = json_encode($datos);
        return $datos;
    }
    
    public function deleteInterPerfiles($interface, $perfil) {
        $InterPerf = InterfazPerfiles::where('IdPerfil', '=', $perfil)
                                        ->where('IdInterfaz', '=', $interface)->delete();
        
        return Redirect::route('interfazperfil', array('mensaje' => 'Menu desasignado con exito'));
    }

}
