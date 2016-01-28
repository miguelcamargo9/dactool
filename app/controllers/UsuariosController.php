<?php

class UsuariosController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Usuarios Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::any('/listausuarios', array('as' => 'listausuarios', 'uses' => 'UsuariosController@VerUsuarios'));
      |
     */

    public function DatosUsuarios() {
        $users = Usuarios::join('Perfiles', 'Usuarios.IdPerfil', '=', 'Perfiles.ID')->get();
        $datos = array();
        foreach ($users->toArray() as $user) {
           $groupDes = Grupos::where('ID', '=', $user['IdGrupo']) ->select('Descripcion')->first();
           $user['Grupo'] = $groupDes->Descripcion;
            if (Session::get('idPeril') == 3) {
                $user['Perfil'] = "{$user['Perfil']}<a href='#' title='Editar Perfil' class='editar' alt='{$user['IdUsuario']}'>"
                        . "<span style='color:#FACC2E; padding-left:15px' class='glyphicon glyphicon-edit'></span>"
                        . "</a>";
            }
            $datos[] = $user;
        }

        return $datos = json_encode($datos);
    }

    public function VerUsuarios() {
        $mensaje = (Input::get('mensaje')) ? Input::get('mensaje') : '';
        $Perfiles = $this->GetPerfiles();
        return View::make('UsuariosController.listausuarios', array('Perfiles' => $Perfiles, 'mensaje' => $mensaje));
    }

    public function GetPerfiles() {
        $result = Perfiles::all();
        $Perfiles = array();
        foreach ($result as $value) {
            $Perfiles[$value->ID] = $value->Perfil;
        }
        return $Perfiles;
    }

    public function getUsuario() {
        $id = Input::get('id');
        return $usuario = Usuarios::where('IdUsuario', '=', $id)->first();
    }

    public function EditarPerfil() {
        Usuarios::where('IdUsuario', '=', Input::get('idusuario'))->update(array('IdPerfil' => Input::get('IdPerfil')));
        return Redirect::route('listausuarios', array('mensaje' => 'Usuario '.Input::get('nickname').' Editado con exito'));
    }

}
