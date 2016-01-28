<?php

class HomeController extends BaseController {
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

    public function showWelcome() {
        return View::make('hello');
    }

    public function showIndex() {
        $conn = DB::connection('mysql');

        $devices = $conn->table("noglpi_conf_routers")->paginate(10);
//        $select = "select * from noglpi_conf_routers ";
//        $result = $conn->select($select);
        return View::make('index', array('resultado' => $devices));
    }

    public function showLogIn() {
        return View::make('HomeController.login');
    }

    public function Login() {
        $user = Input::get('username');
        $pass = Input::get('password');

        $validar_ldap = $this->ValidarLDAP($user, $pass);

        switch ($validar_ldap) {
            case "ERROR_LOGIN":
                Session::put('error', 'Login Incorrecto');
                Session::forget('username');
                break;
            case "ACCESO_NEGADO" :
                Session::put('error', 'Acceso Denegado');
                Session::forget('username');
                break;
            default :
                Session::forget('error');
                Session::put('username', $validar_ldap);
                $userinfo = explode("|", $validar_ldap);
                $nickname = $userinfo[1];
                Session::put('NickNameUsuario', $nickname);
                Session::put('activity', time());
                break;
        }

        if ((Session::get('username')) && (Session::get('username') != '')) {
            return Redirect::route('index');
        } else {
            return Redirect::route('login', array('error' => Session::get('error')));
        }
    }

    public function Logout() {
        Session::flush();
        return Redirect::route('login');
    }

    public function ValidarLDAP($user, $pass) {
        $adServer = "ldap://ad.ifxcorp.com/";
        $ldap = ldap_connect($adServer);
        $ldaprdn = 'ifxcorp' . "\\" . $user;

        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $bind = @ldap_bind($ldap, $ldaprdn, $pass);

        if ($bind) {
            $filter = "(sAMAccountName=$user)";
            $result = ldap_search($ldap, "dc=ifxcorp,dc=com", $filter);
            ldap_sort($ldap, $result, "sn");
            $info = ldap_get_entries($ldap, $result);
            $validar_grupo = $this->ValidarGrupo($info);
            return $validar_grupo;
            @ldap_close($ldap);
        } else {
            return "ERROR_LOGIN";
        }
        return $info;
    }

    public function ValidarGrupo($info) {
        for ($i = 0; $i < $info['count']; $i++) {
            if ($info['count'] > 1) {
                break;
            }
            $re = "/^(?:8|1|5|21|7|9|15)000$/s";
            if (isset($info[$i]["gidnumber"][0])) {
                if (preg_match($re, $info[$i]["gidnumber"][0], $matches)) {
                    return $info[$i]["displayname"][0] . "|" . $info[$i]["mailnickname"][0];
                } else {
                    return "ACCESO_NEGADO";
                }
            } else {
                return "ACCESO_NEGADO";
            }
        }
    }

    public function getRCS() {
        $conn = DB::connection('mysql');
        $datosa = array();
        $tablas = array('Cancelaciones' => 'noglpi_deleted_interface', 'Reactivaciones' => 'noglpi_reactivated_interface_dactool',
            'Suspensiones' => 'noglpi_suspended_interface');
        foreach ($tablas as $key => $value) {
            $select = "select YEAR(ca.date) as year, count(*) as val from $value as ca group by YEAR(ca.DATE) ";
            $result = $conn->select($select);
            foreach ($result as $rcs) {
                $datosa[$rcs->year]['period'] = $rcs->year;
                $datosa[$rcs->year][$key] = $rcs->val;
            }
        }
        $datos = array();
        foreach ($datosa as $value) {
            $datos[] = $value;
        }
        $datos = json_encode($datos);
        DB::disconnect('mysql');

        return $datos;
    }

    public function getInterfacesRoutersFbr() {
        $conn = DB::connection('mysql');
        $select = "select ro.fabr, ro.intstate, count(*) as val from noglpi_conf_routers as ro group by ro.fabr, ro.intstate";
        $result = $conn->select($select);
        $datosa = array();
        foreach ($result as $interface) {
            if ($interface->fabr == 'Cisco') {
                $datosa['Cisco']['y'] = $interface->fabr;
                if ($interface->intstate == 'Up') {
                    $datosa['Cisco']['a'] = $interface->val;
                } else {
                    $datosa['Cisco']['b'] = $interface->val;
                }
            } else {
                $datosa['Juniper']['y'] = $interface->fabr;
                if ($interface->intstate == 'Up') {
                    $datosa['Juniper']['a'] = $interface->val;
                } else {
                    $datosa['Juniper']['b'] = $interface->val;
                }
            }
        }
        $datos = array();
        foreach ($datosa as $value) {
            $datos[] = $value;
        }
        $datos = json_encode($datos);
        DB::disconnect('mysql');

        return $datos;
    }

    public function getDeviceNoBackUp() {
        $conn = DB::connection('mysql');
        $hoy = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("y")));
        $manana = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 1, date("y")));
        $ayer = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") - 1, date("y")));

        $select = "select count(*) as val from noglpi_device_no_backup where FECHA between '$hoy' AND '$manana'";
        $result = $conn->select($select);

        if ($result[0]->val == 0) {
            $select = "select count(*) as val from noglpi_device_no_backup where FECHA between '$ayer' AND '$hoy'";
            $result = $conn->select($select);
        }

        $noback = $result[0]->val;

        $select = "select count(*) as val
                    from glpi_networking, glpi_dropdown_manufacturer, glpi_type_networking where (glpi_networking.state=1) and (deleted=0) and (is_template=0) 
                    and (glpi_type_networking.ID=glpi_networking.type) and (glpi_networking.FK_glpi_enterprise=glpi_dropdown_manufacturer.ID) 
                    and ((glpi_dropdown_manufacturer.name='Cisco') or (glpi_dropdown_manufacturer.name='Juniper') or (glpi_dropdown_manufacturer.name='Foundry') 
                    or (glpi_dropdown_manufacturer.name='Lucent') or (glpi_dropdown_manufacturer.name='Nortel')) and glpi_networking.name not in ('a---ARBUENOC515x1', 'a---ARBUENOC355012Gx1') 
                    and glpi_networking.name NOT LIKE 'COBOGZNTE494810GEX1'
                    order by glpi_networking.ID";
        $result = $conn->select($select);

        $sibackup = $result[0]->val - $noback;

        $datos = array();
        array_push($datos, array("label" => "Equipos Con BackUp", "data" => (int) $sibackup, "color" => "#5cb85c"));
        array_push($datos, array("label" => "Equipos Sin BackUp", "data" => (int) $noback, "color" => "#d9534f"));

        $datos = json_encode($datos);
        DB::disconnect('mysql');

        return $datos;
    }

    public function generateGraphsView() {
        $organismospadre = Organismos::where('IdPadre', '=', NULL)->get();
        return View::make('HomeController.generategraphs', array('OrganismosPadres' => $organismospadre));
    }

    public function organismosHijos() {
        $organismo = Input::get('organismo');
        $organismoshijos = Organismos::where('IdPadre', '=', $organismo)->get();
        
        return $organismoshijos;
    }

    public function generateGraphsResult() {
        $serviceid = Input::get('serviceid');
        return View::make('HomeController.generategraphsresult', array('serviceid' => $serviceid));
    }

    public function generateGraphs() {
        $serviceid = Input::get('serviceid');
        $conn = DB::connection('mysql');

        $select = "select on_device as idhost from glpi_networking_ports where name like '%$serviceid%'";
        $result = $conn->select($select);

        if (isset($result[0]->idhost)) {
            $idhost = $result[0]->idhost;
        }

        if (isset($idhost)) {
            $equipo = Equipos::find($idhost);
            $filetemp = "/usr/local/scripts/cactigraphs/log/log_{$serviceid}_{$idhost}.txt";
//            $commando = "perl /usr/local/scripts/cactigraphs/create_graphs.pl {$equipo->ifaddr} {$serviceid} > {$filetemp} 2>&1";
            $commando = "perl /usr/local/scripts/cactigraphs/create_graphs.pl {$equipo->ifaddr} {$serviceid}";
//            $result = $commando;
//            $result = system($commando);
            $result = system($commando);
            //$result = `cat $filetemp`;
        } else {
            $result = "Este servicio no tiene Host relacionado";
        }

        return $result;
    }

    public function deleteVlanView() {
        return View::make('HomeController.deletevlan');
    }

    public function deleteVlanResult() {
        $vlanid = Input::get('vlanid');
        return View::make('HomeController.deletevlanresult', array('vlanid' => $vlanid));
    }

    public function deleteVlanV() {
        $vlanid = Input::get('vlanid');
        $user = Session::get('username');
        $commando = "perl /usr/local/scripts/desanilladovlan.pl {$vlanid} '{$user}'";

        $result = system($commando);

        return $result;
    }

    public function autoServiceid() {
        $conn = DB::connection('sqlsrv');
        $select = "select top 100 id from Services s where s.stateid not in(4,7)";
        $result = $conn->select($select);

        foreach ($result as $value) {
            $datos[] = $value->id;
        }
        $datos = json_encode($datos);
        DB::disconnect('mysql');

        return $datos;
    }

}
