<?php

class EquiposController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::any('/equipos', array('as' => 'equipos', 'uses' => 'EquiposController@NuevoEquipo', 'before' => 'authM'));
      |
     */

    public function NuevoEquipo() {
        $enviado = Input::get('enviado');
        if (isset($enviado)) {
            $rules = $this->getRulesNuevoEquipo();
            $messages = $this->getMensajesNuevoEquipo();
            $validator = Validator::make(Input::All(), $rules, $messages);
            $mensaje = "";
            $mensajeError = "";
            if ($validator->passes()) {
                $existedevice = $this->ValidarDevice(Input::get('name'));
                $existeip = $this->ValidarIp(Input::get('ip'));
                if (!$existedevice && !$existeip) {
                    $this->InsertarEquipo(Input::get('name'), Input::get('ip'), Input::get('numinvent'), Input::get('pais'), Input::get('fabricante'), Input::get('tipo'));
                    $mensaje = 'Equipo Creado con Exito';
                    $visible = false;
                } else {
                    $mensajeError = 'Nombre de Equipo o Ip Repetidos';
                    $visible = true;
                }
                Session::flash('mensajeError', $mensajeError);
                Session::flash('mensaje', $mensaje);
                Session::flash('visible', $visible);
                return Redirect::route('listaequipos')->withInput(Input::flash());
            } else {
                Session::flash('visible', true);
                return Redirect::route('listaequipos')->withInput(Input::flash())->withErrors($validator);
            }
        } else {
            Session::flash('visible', true);
            return Redirect::route('listaequipos');
        }
    }

    public function GetFabricantes() {
        $conn = DB::connection('mysql');
        $select = 'select * from glpi_dropdown_manufacturer';
        $result = $conn->select($select);
        DB::disconnect('DactoolDB');
        $RFabricantes = array();
        foreach ($result as $value) {
            $RFabricantes[$value->ID] = $value->name;
        }
        return $RFabricantes;
    }

    public function GetPaises() {
        $conn = DB::connection('mysql');
        $select = 'select * from glpi_dropdown_locations';
        $result = $conn->select($select);
        DB::disconnect('DactoolDB');
        $RPaises = array();
        foreach ($result as $value) {
            $RPaises[$value->ID] = $value->completename;
        }
        return $RPaises;
    }

    public function GetTipos() {
        $conn = DB::connection('mysql');
        $select = 'select * from glpi_type_networking';
        $result = $conn->select($select);
        DB::disconnect('DactoolDB');
        $RPaises = array();
        foreach ($result as $value) {
            $RPaises[$value->ID] = $value->name;
        }
        return $RPaises;
    }

    public function GetEstados() {
        $conn = DB::connection('mysql');
        $select = 'select * from glpi_dropdown_state';
        $result = $conn->select($select);
        DB::disconnect('DactoolDB');
        $RPaises = array();
        foreach ($result as $value) {
            $RPaises[$value->ID] = $value->name;
        }
        return $RPaises;
    }

    public function getRulesNuevoEquipo() {
        //Exprecion Regular que valida la IP y la gaurda en 4 resultado $1 - $4
        $re = "/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])$/";
        $rules = array('name' => array('required', 'regex:/^[\\pL\\pN]+$/u', 'min:3', 'max:80'),
            'ip' => array('required', 'regex:' . $re, 'min:7', 'max:15'),
            'numinvent' => array('required', 'regex:/^\pL+$/u', 'min:5')
        );
        return $rules;
    }

    public function getMensajesNuevoEquipo() {
        $messages = array(
            'name.required' => 'El campo nombre es requerido',
            'ip.required' => 'El campo ip es requerido',
            'numinvent.required' => 'El campo numero de inventario es requerido',
            'name.regex' => 'El campo nombre solo admite letras y numeros',
            'ip.regex' => 'El campo ip no tiene el formato correcto'
        );
        return $messages;
    }

    public function getRulesEditarEquipo() {
        //Exprecion Regular que valida la IP y la gaurda en 4 resultado $1 - $4
        $re = "/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])$/";
        $rules = array('nameEd' => array('required', 'regex:/^[\\pL\\pN]+$/u', 'min:3', 'max:80'),
            'ipEd' => array('required', 'regex:' . $re, 'min:7', 'max:15'),
            'numinventEd' => array('required', 'regex:/^\pL+$/u', 'min:5')
        );
        return $rules;
    }

    public function getMensajesEditarEquipo() {
        $messages = array(
            'nameEd.required' => 'El campo nombre es requerido',
            'ipEd.required' => 'El campo ip es requerido',
            'numinventEd.required' => 'El campo numero de inventario es requerido',
            'nameEg.regex' => 'El campo nombre solo admite letras y numeros',
            'ipEd.regex' => 'El campo ip no tiene el formato correcto'
        );
        return $messages;
    }

    public function InsertarEquipo($device, $ipaddress, $numinventory, $location, $fabricante, $tipo) {
        $equipo = new Equipos;
        $equipo->name = "$device";
        $equipo->ifaddr = "$ipaddress";
        $equipo->otherserial = "$numinventory";
        $equipo->FK_glpi_enterprise = $fabricante;
        $equipo->location = $location;
        $equipo->type = $tipo;
        $equipo->save();
    }

    public function ValidarDevice($device) {
        $count = Equipos::where('name', '=', "$device")
                        ->where('deleted', '=', 0)->count();
        if ($count > 0) {
            return true;
        }
    }

    public function ValidarIp($ip) {
        $count = Equipos::where('ifaddr', '=', "$ip")
                        ->where('deleted', '=', 0)->count();
        if ($count > 0) {
            return true;
        }
    }

    public function VerEquipos() {
        $visible = Input::get('visible');
        $visibleEditar = Input::get('visibleEditar');
        $mensaje = Input::get('mensaje');
        $mensajeError = Input::get('mensajeError');
        $query = Input::get('query');
        if (!$visible) {
            $visible = false;
        }
        $fabricantes = $this->GetFabricantes();
        $paises = $this->GetPaises();
        $tipos = $this->GetTipos();
        switch ($mensaje) {
            case 1:
                $mensaje = 'Equipo Creado con Exito';
                break;
            case 2:
                $mensaje = 'Nombre de Equipo o Ip Repetidos';
                break;
        }
        return View::make('EquiposController.listaequipos', array('fabricantes' => $fabricantes, 'paises' => $paises,
                    'tipos' => $tipos, 'mensaje' => $mensaje, 'visible' => $visible, 'query' => $query, 'mensajeError' => $mensajeError,
                    'visibleEditar' => $visibleEditar));
    }

    public function VerEquiposPermisos() {
        return View::make('EquiposController.listaequipospermisos');
    }

    public function VerBackEquipo($device = null) {
        $conn = DB::connection('mysqlBackUp');
        if (isset($_POST['device']) && $device == null) {
            $device = $_POST['device'];
        }
        if (isset($_POST['date'])) {
            $fecha = $_POST['date'];
            $querybackups = "SELECT * from logs where equipo like '%" . $device . "%' and dt like '%$fecha%'";
        } else {
            $fecha = "";
//            $querybackups = "SELECT * from logs where equipo like '%" . $device . "%' and dt like '%$fecha%'";
            $querybackups = "SELECT * from logs where equipo like '%" . $device . "%' order by dt desc limit 0,2";
        }
        $result = $conn->select($querybackups);
        foreach ($result as $backup) {
            $fecha = $backup->dt;
        }
        DB::disconnect('mysqlBackUp');
        return View::make('EquiposController.listabackups', array('resultado' => $result, 'sql' => $querybackups, 'device' => $device, 'date' => $fecha));
    }

    public function DatosEquipos() {
        $conn = DB::connection('mysql');
        $select = "select net.name as hostname, net.ifaddr, man.name as fabricante, net.ID as netid, pai.completename as pais, tynet.name as tipo,
                    fir.name as firmware, net.deleted as estado
                    from glpi_networking net
                    inner join glpi_dropdown_manufacturer man on man.ID = net.FK_glpi_enterprise
                    left join noglpi_conf_routers conf on conf.IDHOST = net.ID
                    left join glpi_dropdown_locations pai on net.location = pai.ID
                    left join glpi_type_networking tynet on tynet.ID = net.type
                    left join glpi_dropdown_firmware fir on fir.ID = net.firmware
                    where man.name != 'No Identificado' and man.name <> 'Otro' and net.is_template = 0
                    group by netid order by net.deleted ";
        $result = $conn->select($select);
        $datos = array();
        foreach ($result as $device) {
            $device->backup = "<a href='verbackup/$device->hostname' title='Ver Ultimo BackUp $device->hostname'>"
                    . "<span style='color:#01DF74; padding-left:30px' class='glyphicon glyphicon-duplicate'></span>"
                    . "</a>";
            $device->showlog = "<a href='syslogdeviceview/$device->netid' title='Ver log $device->hostname'>"
                    . "<span style='color:black; padding-left:30px' class='glyphicon glyphicon-comment'></span>"
                    . "</a>";
            $device->save = ($device->estado == 0) ? "<a href='savedeviceview/$device->netid' title='Generar BackUp $device->hostname'>"
                    . "<span style='color:#009BDD; padding-left:30px' class='glyphicon glyphicon-floppy-disk'></span>"
                    . "</a>" : "";
            $device->options = ($device->estado == 0) ? "<a href='#' title='Editar $device->hostname' class='editar' alt='$device->netid'>"
                    . "<span style='color:#FACC2E; padding-left:15px' class='glyphicon glyphicon-edit'></span>"
                    . "</a><a href='#' title='Eliminar $device->hostname' class='eliminar' alt='$device->netid'> "
                    . "<span style='color:#FA5858; padding-left:15px' class='glyphicon glyphicon-remove'></span>"
                    . "</a>" : "<a href='#' title='Activar $device->hostname' class='activar' alt='$device->netid'>"
                    . "<span style='color:#419641; padding-left:15px' class='glyphicon glyphicon-ok'></span>"
                    . "</a>";
            $device->hostname = "<a href='verinterfaces/$device->netid'> $device->hostname</a>";
            $device->estado = ($device->estado == 0) ? "Activo" : "Inactivo";
            $datos[] = $device;
        }
        $datos = json_encode($datos);
        DB::disconnect('mysql');

        return $datos;
    }

    public function VerInterfacesEquipo($device = null) {
        $deviceObj = Equipos::find($device);
        return View::make('EquiposController.listainterfaces', array('device' => $deviceObj));
    }

    public function DatosInterfacesEquipo() {
        $conn = DB::connection('mysql');
        $device = Input::get('device');

        $query = "SELECT np.ID AS id, np.name AS name, inf.name AS interface, net.name AS equipo, 
                    IF(ISNULL(cons.SERVICEID), conr.SERVICEIDQ, cons.SERVICEID) as service
                    FROM glpi_networking_ports AS np
                    LEFT JOIN glpi_dropdown_iface inf ON inf.ID = np.iface
                    LEFT JOIN glpi_networking net ON net.ID = np.on_device
                    LEFT JOIN noglpi_conf_routers conr ON conr.IDPORT = np.ID AND conr.IDHOST = net.ID
                    LEFT JOIN noglpi_confclientes_switches cons ON cons.IDPORT = np.ID  AND cons.IDHOST = net.ID
                    where np.on_device = $device ";
        $result = $conn->select($query);

        $datos = array();
        foreach ($result as $interface) {
            $interface->Vlans = $this->GetVlansPuerto($interface->id, $conn);
            $interface->interface = "<a href='javascript:;' class = 'showPopBox' alt='{$interface->id}'>"
                    . "{$interface->interface}</a>"
                    . "<div id='{$interface->id}' style='display:none;' class='box popupTemporal'>{$interface->name}</div>";
            if ($interface->service && intval($interface->service) > 0) {
                $interface->service = "<a href='/verservicio/{$interface->service}'>{$interface->service}</a>";
            }
            $datos[] = $interface;
        }
        DB::disconnect('mysql');

        return json_encode($datos);
    }

    public function VerServicio($servicio = null) {
        $confRouter = ConfRouters::where('serviceidq', '=', $servicio)->first();
        if(isset($confRouter)){
        $device = Equipos::find($confRouter->IDHOST);
        $graphHtml = $this->getGrafica($confRouter);
        if ($confRouter->DEVICETO != 'Not Available' && $confRouter->DEVICETO != null) {
            $deviceTo = Equipos::where('name', '=', $confRouter->DEVICETO)->first();
            $deviceTo = ($deviceTo) ? $deviceTo : "NO DISPONIBLE";
            $interSwitche = str_replace("Fa", "FastEthernet", $confRouter->INTERFACETO);
            if ($deviceTo != "NO DISPONIBLE") {
                $confSwitche = ConfSwitches::where('interface', 'LIKE', "%{$interSwitche}%")
                                ->where('idhost', '=', $deviceTo->ID)->first();
            }
            $confSwitche = (isset($confSwitche)) ? $confSwitche : "NO DISPONIBLE";
        } else {
            $deviceTo = "NO DISPONIBLE";
            $confSwitche = "NO DISPONIBLE";
        }
        $confRouters = ConfRouters::where('serviceidq', '=', $servicio)->get();
        $infoIp = array();
        foreach ($confRouters as $key => $confRoute) {
            $infoIp[$key]['subservicios'] = $confRoute->SUBSERVICEID;
            $infoIp[$key]['ipaddressname'] = $confRoute->IPADDRESSNAME;
            $infoIp[$key]['interfaces'] = $confRoute->INTERFACE;
            $infoIp[$key]['vlans'] = $confRoute->VLAN;
        }
        $confRouters = ConfRouters::where('serviceidq', '=', $servicio)->groupBy('interface')->get();
        $infoInterface = array();
        foreach ($confRouters as $key => $confRoute) {
            $infoInterface[$key]['INTERFACE'] = $confRoute->INTERFACE;
            $infoInterface[$key]['CONF'] = $confRoute->CONF;
            $infoInterface[$key]['VLAN'] = $confRoute->VLAN;
            $infoInterface[$key]['INTSTATE'] = $confRoute->INTSTATE;
            $infoInterface[$key]['GRAFICA'] = $this->getGrafica($confRoute);
        }
        return View::make('EquiposController.detalleservicio', array('device' => $device, 'servicio' => $servicio,
                    'confRouter' => $confRouter, 'deviceTo' => $deviceTo, 'confSwitche' => $confSwitche, 'infoIp' => $infoIp, 'infoInterface' => $infoInterface));
        } else{
            return View::make('EquiposController.servicionoencontrado');
        }
    }

    public function getGrafica($confRouter) {
        $conn = DB::connection('sqlsrv');
        $qsll = "select ISNULL(StatsURL,'PorDefinir') as StatsURL 
        from ServiceLocalLoop where GWIP='$confRouter->IPDEVICE' and GWInterface='$confRouter->INTERFACE' and isdeleted = 0 ";

        $result = $conn->select($qsll);

        $StatsURL = "";

        foreach ($result as $sll) {
            $StatsURL = $sll->StatsURL;
        }

        $re = "/.+=(\\d+)\\&.*/";
        preg_match($re, $StatsURL, $matches);

        if (isset($matches[1])) {
            $graphHtml = "<a rel='lightbox' href='http://vipcacti.ifxnetworks.com/graph.php?action=view&local_graph_id={$matches[1]}"
                    . "&rra_id=all' target='_blank'><img src='http://vipcacti.ifxnetworks.com/graph_image_nagios.php?local_graph_id={$matches[1]}"
                    . "&rra_id=0' width='432' height='170' alt='Ir a http://vipcacti.ifxnetworks.com (Recuerde ingresar con su cuenta)' /></a>";
        } else {
            $graphHtml = "Grafica Por Definir";
        }

        DB::disconnect('sqlsrv');

        return $graphHtml;
    }

    public function VerInterfaces() {
        return View::make('EquiposController.listadointerfaces');
    }

    public function VerServicios() {
        return View::make('EquiposController.listaservicios');
    }

    public function DatosInterfaces() {
        $conn = DB::connection('mysql');

        $query = "select cr.interface as interface, cr.intstate as state, cr.serviceidq as serviceid, cr.customerid as customerid, cr.nombre_cliente as cliente, "
                . "cr.conf as conf, cr.device as device "
                . "from noglpi_conf_routers as cr "
                . "group by interface, serviceid ";
        $result = $conn->select($query);

        $datos = array();
        if (count($result) > 0) {
            foreach ($result as $interface) {
                $idInterface = $this->CambiaIdInterface($interface->interface);
                $interface->interface = "<a href='javascript:;' class = 'showPopBox' alt='$idInterface'>"
                        . "{$interface->interface}</a>"
                        . "<div id='$idInterface' style='display:none;' class='box popupTemporal'>{$interface->conf}</div>";
                $datos[] = $interface;
            }
        } else {
            $query = "select cs.interface as interface, cs.conf as state, cs.serviceid as serviceid, "
                    . "cs.clientid as customerid, cs.nombre_cliente as cliente, cs.device as device "
                    . "from noglpi_confclientes_switches as cs "
                    . "group by interface, serviceid ";

            $result = $conn->select($query);

            foreach ($result as $interface) {
                $interface->conf = $interface->state;
                if ((strstr($interface->state, 'shutdown')) || (strstr($interface->state, 'disable'))) {
                    $interface->state = "Down";
                } else {
                    $interface->state = "Up";
                }
                $idInterface = $this->CambiaIdInterface($interface->interface);
                $interface->interface = "<a href='javascript:;' class = 'showPopBox' alt='$idInterface'>"
                        . "{$interface->interface}</a>"
                        . "<div id='$idInterface' style='display:none;' class='box popupTemporal'>{$interface->conf}</div>";
                $datos[] = $interface;
            }
        }
        $datos = json_encode($datos);
        DB::disconnect('mysql');
        return $datos;
    }

    public function DatosServicios() {
        $conn = DB::connection('mysql');
        $query = "select 	cr.SERVICEIDQ as Servicio,
                            cr.CUSTOMERID as CustomerID,
                            cr.NOMBRE_CLIENTE as Customer,
                            cr.DEVICE as Device,
                            'Router' as Tipo,
                            cr.INTERFACE as Interface,
                            cr.VLAN as VLAN,
                            cbw.SERVICENAME as Servicename,
                            com.Name as Company,
                            cr.INTSTATE as Estado
                from noglpi_conf_routers as cr
                left join noglpi_conf_routers_bw cbw on cr.SERVICEIDQ = cbw.SERVICEIDQ
                left join noglpi_company com on cr.COMPANYID = com.ID
                where cr.SERVICEIDQ IS NOT NULL
                and cr.SERVICEIDQ != 0
					 group by cr.SERVICEIDQ";
        $result = $conn->select($query);
        $datos = array();
        foreach ($result as $servicio) {
            $servicio->ips = '';
            $confRouters = ConfRouters::where('serviceidq', '=', $servicio->Servicio)->get();
            foreach ($confRouters as $confRoute) {
                $servicio->ips .= $confRoute->IPADDRESSNAME . "<br>";
            }
            $servicio->Servicio = "<a href='verservicio/$servicio->Servicio'> $servicio->Servicio</a><div style='display: none;'>$servicio->ips</div>";
            $datos[] = $servicio;
        }
        $datosjson = json_encode($datos);
        DB::disconnect('mysql');
        return $datosjson;
    }

    public function CambiaIdInterface($idIn) {
        $idInterface = utf8_encode($idIn);
        $idInterface = str_replace(".", "", $idInterface);
        $idInterface = str_replace("-", "", $idInterface);
        $idInterface = str_replace("\\", "", $idInterface);
        $idInterface = str_replace("/", "", $idInterface);
        return $idInterface;
    }

    public function EditarEquipoVista($id) {
        $device = Equipos::find($id)->name;
        $ip = Equipos::find($id)->ifaddr;
        $numinv = Equipos::find($id)->otherserial;
        $fabricante = $this->GetFabricante($id);
        $pais = $this->GetUbicacion($id);
        $tipo = $this->GetTipo($id);
        $fabricantes = $this->GetFabricantes();
        $paises = $this->GetPaises();
        $tipos = $this->GetTipos();
        return View::make('EquiposController.editarequipo', array(
                    'id' => $id, 'device' => $device, 'fabricante' => $fabricante->ID, 'pais' => $pais->ID, 'tipo' => $tipo->ID, 'ip' => $ip,
                    'numinv' => $numinv, 'device' => $device, 'fabricantes' => $fabricantes, 'paises' => $paises, 'tipos' => $tipos
        ));
    }

    public function EditarEquipo() {
        $editado = Input::get('editado');
        $id = Input::get('idEd');
        $mensaje = "";
        $mensajeError = "";
        if (isset($editado)) {
            $rules = $this->getRulesEditarEquipo();
            $messages = $this->getMensajesEditarEquipo();
            $validator = Validator::make(Input::All(), $rules, $messages);

            if ($validator->passes()) {

                if ((Input::get('name_old') != Input::get('nameEd')) || (Input::get('ip_old') != Input::get('ipEd'))) {
                    $existedevice = false;
                    $existeip = false;
                    if (Input::get('name_old') != Input::get('nameEd')) {
                        $existedevice = $this->ValidarDevice(Input::get('nameEd'));
                    }
                    if (Input::get('ip_old') != Input::get('ipEd')) {
                        $existeip = $this->ValidarIp(Input::get('ipEd'));
                    }

                    if (!$existedevice && !$existeip) {
                        Equipos::where('ID', '=', $id)->update(
                                array('name' => Input::get('nameEd'), 'ifaddr' => Input::get('ipEd'), 'otherserial' => Input::get('numinventEd'),
                                    'FK_glpi_enterprise' => Input::get('fabricanteEd'), 'location' => Input::get('ubicacionEd'), 'type' => Input::get('tipoEd')
                                )
                        );
                        $mensaje = "Equipo editado con exito.";
                        $visibleEditar = false;
                    } else {
                        $mensajeError = "Nombre de Equipo o Ip Repetidos";
                        $visibleEditar = true;
                    }
                } else {
                    Equipos::where('ID', '=', $id)->update(
                            array('name' => Input::get('nameEd'), 'ifaddr' => Input::get('ipEd'), 'otherserial' => Input::get('numinventEd'),
                                'FK_glpi_enterprise' => Input::get('fabricanteEd'), 'location' => Input::get('ubicacionEd'), 'type' => Input::get('tipoEd')
                            )
                    );
                    $mensaje = "Equipo editado con exito.";
                    $visibleEditar = false;
                }
            } else {
                return Redirect::route('listaequipos', array('visibleEditar' => true))->withInput(Input::flash())->withErrors($validator);
            }
        }
        Session::flash('mensajeError', $mensajeError);
        Session::flash('mensaje', $mensaje);
        Session::flash('visibleEditar', $visibleEditar);
        return Redirect::route('listaequipos')->withInput(Input::flash());
    }

    public function EliminarEquipo() {
        $eliminado = Input::get('eliminado');
        $id = Input::get('idEl');
        $mensaje = "";
        $mensajeError = "";
        if (isset($eliminado)) {
            $result = Equipos::where('ID', '=', $id)->update(array('deleted' => 1));
            $mensaje = ($result != 0 ) ? "Equipo Eliminado con Éxito." : "Error Eliminado el Equipo";
            $visible = false;
        } else {
            $mensajeError = "Error Eliminado el Equipo";
            $visible = true;
        }
        Session::flash('mensajeError', $mensajeError);
        Session::flash('mensaje', $mensaje);
        Session::flash('visibleEliminar', $visible);
        return Redirect::route('listaequipos');
    }

    public function GetFabricante($id) {
        $equipo = Equipos::find($id);
        return $equipo->Fabricante;
    }

    public function GetUbicacion($id) {
        $equipo = Equipos::find($id);
        return $equipo->Ubicacion;
    }

    public function GetTipo($id) {
        $equipo = Equipos::find($id);
        return $equipo->Tipo;
    }

    public function GetVlansPuerto($idprot, $conn) {
        $select = "select dv.name from glpi_dropdown_vlan as dv
                    join glpi_networking_vlan as nv on nv.FK_port = $idprot
                    where dv.ID = nv.FK_vlan";
        $result = $conn->select($select);

        $datos = array();
        foreach ($result as $vlan) {
            $datos[] = $vlan;
        }
        return $datos;
    }

    public function BackupEquipo() {
        $device = Input::get('id');
        $result = "";
        $numero_aleatorio = rand(1, 10000);
        $filetemp = "/var/www/html/ebackups/log/logweb$numero_aleatorio.txt";
        $commando = "perl /var/www/html/ebackups/runn2.pl " . $device . " > $filetemp 2>&1";
        system($commando);
        $result = `cat $filetemp`;

        return $result;
    }

    public function BackupEquipoVista($device) {
        return View::make('EquiposController.resultadobackup', array('device' => $device));
    }

    public function SysLogEquipoVista($device) {
        $device = Equipos::find($device);
        return View::make('EquiposController.syslogdevice', array('device' => $device));
    }

    public function SysLogEquipo() {
        $device = Input::get('id');
        $ip = Equipos::find($device)->ifaddr;
        $conn = DB::connection('SysLog');
        $hoy = date("Y-m-d");
        $select = "select date, uid, terminal, client_ip, type, service, cmd from accounting where nas='$ip' and date > '$hoy'  order by date";
        $result = $conn->select($select);
        $datos = array();
        foreach ($result as $syslog) {
            $datos[] = $syslog;
        }
        $datos = json_encode($datos);
        DB::disconnect('SysLog');

        return $datos;
    }

    public function getEquipo() {
        $device = Input::get('id');
        $deviceObj = Equipos::with('Fabricante')->with('Ubicacion')->with('Tipo')->find($device);
        return $deviceObj;
    }

    public function ActivarEquipo() {
        $activado = Input::get('activar');
        $query = Input::get('queryAc');
        $id = Input::get('idAc');
        if (isset($activado)) {
            $existedevice = $this->ValidarDevice(Input::get('nameAc'));
            $existeip = $this->ValidarIp(Input::get('ipAc'));
            $mensaje = ($existeip) ? "La Ip se encuentra asignada a un equipo activo" : "";
            $mensaje = ($existedevice) ? "El nombre de equipo ya existe en un equipo activo" : "";
            if ($mensaje == "") {
                $activar = Equipos::where('ID', '=', $id)->update(array('deleted' => 0));
                $mensaje = ($activar != 0) ? "Equipo Activado con Éxito" : "Error Activando el Equipo";
            }
        } else {
            $mensaje = "Error Activando el Equipo";
        }
        Session::flash('query', $query);
        Session::flash('mensaje', $mensaje);
        Session::flash('visible2', "true estoy");
        return Redirect::route('listaequipos');
    }

}
