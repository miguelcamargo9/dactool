<?php

class IpInventoryController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | InventarioIp Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/inventarioip', array('as' => 'inventarioip', 'uses' => 'InventarioIpController@VerInventario', 'before' => 'authM'));
      |
     */

    public $father = array();
    public $hijo = array();

    public function VerInventario() {
//        return View::make('IpInventoryController.viewinventory');
        return View::make('IpInventoryController.viewipam');
    }

    public function ConsultarInventario() {
        $ips = InventarioIp::with('StateIp')->with('RangoIp')
                        ->where('RangeId', '=', 1)
                        ->where('Netmask', '>=', 18)
                        ->where('Netmask', '<=', 24)->get();
//                ->where('IpAddress', 'like', '190.60.1%')->get();
        foreach ($ips as $ip) {
            $ip = $this->changeColors($ip);
        }
        return $ips;
    }

    public function changeColors($ip) {
        $ip->IpAddress = $ip->IpAddress . "/" . $ip->Netmask;
        switch ($ip->Status) {
            case 1:
                $ip->Color = 'Disponible';
                break;
            case 2:
                $ip->Color = 'noDisponible';
                break;
            case 3:
                $ip->Color = 'Ocupado';
                break;
            case 4:
                $ip->Color = 'Routing';
                break;
        }
        return $ip;
    }

    public function getIpRanges() {
        $ip = InventarioIp::with('StateIp')->with('RangoIp')
//                ->where('RangeId', '=', 1)->get();
                        ->where('Netmask', '=', 18)->get();
        foreach ($ip as $mip) {
            $mip->IpAddress = $mip->IpAddress . " / " . $mip->Netmask;
        }
        return $ip;
    }

    public function getInventoriIpId() {
        $ipsfinales = array();
        $ipaddress = (Input::get('ipaddress')) ? Input::get('ipaddress') : null;
        $netmask = (Input::get('netmask')) ? Input::get('netmask') : null;
        $ips = InventarioIp::with('StateIp')->with('RangoIp')
                        ->where('IpAddress', '=', $ipaddress)
                        ->where('Netmask', '=', $netmask)->get();
        foreach ($ips as $ip) {
            if ($ip->Netmask == 24) {
                $ip->IdPadre = null;
            }
            $ip = $this->changeColors($ip);
            $this->getFather($ip);
            $this->father = array_reverse($this->father);
            foreach ($this->father as $value) {
                $ipsfinales[] = $value;
            }
            $ipsfinales[] = $ip->toArray();
            $this->getSon($ip);
            foreach ($this->hijo as $value) {
                $ipsfinales[] = $value;
            }
        }
        return json_encode($ipsfinales);
    }
    
    public function getInventarioServicio() {
        $ipsfinales = array();
        $serviceid = (Input::get('serviceid')) ? Input::get('serviceid') : null;
        $ips = InventarioIp::with('StateIp')->with('RangoIp')
                        ->where('ServiceId', '=', $serviceid)->get();
        foreach ($ips as $ip) {
            if ($ip->Netmask == 24) {
                $ip->IdPadre = null;
            }
            $ip = $this->changeColors($ip);
            $this->getFather($ip);
            $this->father = array_reverse($this->father);
            foreach ($this->father as $value) {
                $ipsfinales[] = $value;
            }
            $ipsfinales[] = $ip->toArray();
            $this->getSon($ip);
            foreach ($this->hijo as $value) {
                $ipsfinales[] = $value;
            }
        }
        return json_encode($ipsfinales);
    }

    public function getFather($ip) {
        if ($ip->IdPadre) {
            $ips = InventarioIp::with('StateIp')->with('RangoIp')
                            ->where('Id', '=', $ip->IdPadre)
                            ->where('Netmask', '>', 23)->get();
            foreach ($ips as $miip) {
                if ($miip->Netmask == 24) {
                    $miip->IdPadre = null;
                }
                $miip = $this->changeColors($miip);
                $this->father[] = $miip->toArray();
                $this->getFather($miip);
            }
        }
    }

    public function getSon($ip) {
        $iphijo = InventarioIp::with('StateIp')->with('RangoIp')
                        ->where('IdPadre', '=', $ip->Id)->get();
        foreach ($iphijo as $miip) {
            $miip = $this->changeColors($miip);
            $this->hijo[] = $miip->toArray();
            $this->getSon($miip);
        }
    }

    public function getInventoriIpRangos() {
        $idRango = (Input::get('filtro')) ? Input::get('filtro') : null;
        $ips = InventarioIp::with('StateIp')->with('RangoIp')
                        ->where('RangeId', '=', $idRango)
                        ->where('Netmask', '>=', 18)
                        ->where('Netmask', '<=', 24)->get();
        foreach ($ips as $ip) {
            $ip = $this->changeColors($ip);
        }
        return $ips;
    }

    //MOTODOS PARA CALCULAR TODAS LAS IP

    public function calcularTodas() {
        $padres = InventarioIp::where('Netmask', '=', 18)->select('IpAddress', 'Netmask', 'RangeId')->get();
        foreach ($padres as $padre) {
            $this->calcularIpArriba($padre->IpAddress, $padre->Netmask, $padre->RangeId);
            echo $padre->IpAddress . "/" . $padre->Netmask . "<br>";
        }
    }

    public function calcularIpArriba($ip, $mask, $rangoid) {
        $barras = array('22' => 64, '24' => 256);
        $segmentos = array('ip' => $ip, 'mask' => $mask, 'hijos' => array());
        $octetos = explode(".", $ip);
        $ip = $octetos[0] . "." . $octetos[1] . ".";
        $hosta = $octetos[2];
        $hostb = $octetos[2];
        $ip18 = InventarioIp::where('IpAddress', '=', $segmentos['ip'])->where('Netmask', '=', $segmentos['mask'])->select('Id')->get();
        foreach ($ip18 as $value) {
            $id18 = $value->Id;
        }
        for ($a = 0; $a < 16; $a++) {
            if ($hosta < 256) {
                $segmentos['hijos'][$a] = array('ip' => $ip . $hosta . ".0", 'mask' => '22', 'hijos' => array());
                $ip22 = new InventarioIp;
                $ip22->IpAddress = $ip . $hosta . ".0";
                $ip22->Netmask = 22;
                $ip22->Status = 1;
                $ip22->RangeId = $rangoid;
                $ip22->IdPadre = $id18;
                $ip22->save();
                $p22 = InventarioIp::where('IpAddress', '=', $ip . $hosta . ".0")->where('Netmask', '=', 22)->select('Id')->get();
                foreach ($p22 as $value) {
                    $id22 = $value->Id;
                }
                $rango = 256 / $barras['22'];
                $hosta += $rango;
                for ($b = 0; $b < 4; $b++) {
                    if ($hostb < 256) {
                        $segmentos['hijos'][$a]['hijos'][$b] = array('ip' => $ip . $hostb . ".0", 'mask' => '24');
                        $ip24 = new InventarioIp;
                        $ip24->IpAddress = $ip . $hostb . ".0";
                        $ip24->Netmask = 24;
                        $ip24->Status = 1;
                        $ip24->RangeId = $rangoid;
                        $ip24->IdPadre = $id22;
                        $ip24->save();
                        $ip24 = InventarioIp::where('IpAddress', '=', $ip . $hostb . ".0")->where('Netmask', '=', 24)->get();
                        foreach ($ip24 as $value) {
                            $this->calcularIp($value->IpAddress, $value->Netmask, $rangoid);
                        }
                        $rango = 256 / $barras['24'];
                        $hostb += $rango;
                    }
                }
            }
        }
//        echo "<pre>";
//        print_r($segmentos);
//            echo json_encode($segmentos);
    }

    public function calcularIp($ip, $mask, $rangoid) {
        $barras = array('25' => 2, '26' => 4, '27' => 8, '28' => 16, '29' => 32, '30' => 64, '32' => 256);
        $segmentos = array('ip' => $ip, 'mask' => $mask, 'hijos' => array());
        $ip = substr($ip, 0, -1);
        $ip24 = InventarioIp::where('IpAddress', '=', $segmentos['ip'])->where('Netmask', '=', $segmentos['mask'])->select('Id')->get();
        foreach ($ip24 as $value) {
            $id24 = $value->Id;
        }
        $hosta = 0;
        $hostb = 0;
        $hostc = 0;
        $hostd = 0;
        $hoste = 0;
        $hostf = 0;
        $hostg = 0;
        for ($a = 0; $a < 2; $a++) {
            $rango = 256 / $barras['25'];
            $segmentos['hijos'][$a] = array('ip' => $ip . $hosta, 'mask' => '25', 'hijos' => array());
            $ip25 = new InventarioIp;
            $ip25->IpAddress = $ip . $hosta;
            $ip25->Netmask = 25;
            $ip25->Status = 1;
            $ip25->RangeId = $rangoid;
            $ip25->IdPadre = $id24;
            $ip25->save();
            $p25 = InventarioIp::where('IpAddress', '=', $ip . $hosta)->where('Netmask', '=', 25)->select('Id')->get();
            foreach ($p25 as $value) {
                $id25 = $value->Id;
            }
            $hosta += $rango;
            for ($b = 0; $b < 2; $b++) {
                $rango = 256 / $barras['26'];
                $segmentos['hijos'][$a]['hijos'][$b] = array('ip' => $ip . $hostb, 'mask' => '26', 'hijos' => array());
                $ip26 = new InventarioIp;
                $ip26->IpAddress = $ip . $hostb;
                $ip26->Netmask = 26;
                $ip26->Status = 1;
                $ip26->RangeId = $rangoid;
                $ip26->IdPadre = $id25;
                $ip26->save();
                $ip26 = InventarioIp::where('IpAddress', '=', $ip . $hostb)->where('Netmask', '=', 26)->select('Id')->get();
                foreach ($ip26 as $value) {
                    $id26 = $value->Id;
                }
                $hostb += $rango;
                for ($c = 0; $c < 2; $c++) {
                    $rango = 256 / $barras['27'];
                    $segmentos['hijos'][$a]['hijos'][$b]['hijos'][$c] = array('ip' => $ip . $hostc, 'mask' => '27', 'hijos' => array());
                    $ip27 = new InventarioIp;
                    $ip27->IpAddress = $ip . $hostc;
                    $ip27->Netmask = 27;
                    $ip27->Status = 1;
                    $ip27->RangeId = $rangoid;
                    $ip27->IdPadre = $id26;
                    $ip27->save();
                    $ip27 = InventarioIp::where('IpAddress', '=', $ip . $hostc)->where('Netmask', '=', 27)->select('Id')->get();
                    foreach ($ip27 as $value) {
                        $id27 = $value->Id;
                    }
                    $hostc += $rango;
                    for ($d = 0; $d < 2; $d++) {
                        $rango = 256 / $barras['28'];
                        $segmentos['hijos'][$a]['hijos'][$b]['hijos'][$c]['hijos'][$d] = array('ip' => $ip . $hostd, 'mask' => '28', 'hijos' => array());
                        $ip28 = new InventarioIp;
                        $ip28->IpAddress = $ip . $hostd;
                        $ip28->Netmask = 28;
                        $ip28->Status = 1;
                        $ip28->RangeId = $rangoid;
                        $ip28->IdPadre = $id27;
                        $ip28->save();
                        $ip28 = InventarioIp::where('IpAddress', '=', $ip . $hostd)->where('Netmask', '=', 28)->select('Id')->get();
                        foreach ($ip28 as $value) {
                            $id28 = $value->Id;
                        }
                        $hostd += $rango;
                        for ($e = 0; $e < 2; $e++) {
                            $rango = 256 / $barras['29'];
                            $segmentos['hijos'][$a]['hijos'][$b]['hijos'][$c]['hijos'][$d]['hijos'][$e] = array('ip' => $ip . $hoste, 'mask' => '29', 'hijos' => array());
                            $ip29 = new InventarioIp;
                            $ip29->IpAddress = $ip . $hoste;
                            $ip29->Netmask = 29;
                            $ip29->Status = 1;
                            $ip29->RangeId = $rangoid;
                            $ip29->IdPadre = $id28;
                            $ip29->save();
                            $ip29 = InventarioIp::where('IpAddress', '=', $ip . $hoste)->where('Netmask', '=', 29)->select('Id')->get();
                            foreach ($ip29 as $value) {
                                $id29 = $value->Id;
                            }
                            $hoste += $rango;
                            for ($f = 0; $f < 2; $f++) {
                                $rango = 256 / $barras['30'];
                                $segmentos['hijos'][$a]['hijos'][$b]['hijos'][$c]['hijos'][$d]['hijos'][$e]['hijos'][$f] = array('ip' => $ip . $hostf, 'mask' => '30', 'hijos' => array());
                                $ip30 = new InventarioIp;
                                $ip30->IpAddress = $ip . $hostf;
                                $ip30->Netmask = 30;
                                $ip30->Status = 1;
                                $ip30->RangeId = $rangoid;
                                $ip30->IdPadre = $id29;
                                $ip30->save();
                                $ip30 = InventarioIp::where('IpAddress', '=', $ip . $hostf)->where('Netmask', '=', 30)->select('Id')->get();
                                foreach ($ip30 as $value) {
                                    $id30 = $value->Id;
                                }
                                $hostf += $rango;
                                for ($g = 0; $g < 4; $g++) {
                                    $segmentos['hijos'][$a]['hijos'][$b]['hijos'][$c]['hijos'][$d]['hijos'][$e]['hijos'][$f]['hijos'][$g] = array('ip' => $ip . $hostg, 'mask' => '32');
                                    $ip32 = new InventarioIp;
                                    $ip32->IpAddress = $ip . $hostg;
                                    $ip32->Netmask = 32;
                                    $ip32->Status = 1;
                                    $ip32->RangeId = $rangoid;
                                    $ip32->IdPadre = $id30;
                                    $ip32->save();
                                    $hostg ++;
                                }
                            }
                        }
                    }
                }
            }
        }
//        echo json_encode($segmentos);
    }

    public function ocuparIps($ip, $mask, $actual) {
        $ipActual = InventarioIp::where('IpAddress', '=', $ip)->where('Netmask', '=', $mask)->select('Id', 'IdPadre', 'Status')->get();
        foreach ($ipActual as $value) {
            if ($value->Status != 3 && $actual) {
                InventarioIp::where('Id', '=', $value->Id)->update(array('Status' => 3));
            }
            if ($actual) {
                $this->ocuparHijos($value->Id);
            }
            $idPadre = $value->IdPadre;
        }
        if (isset($idPadre)) {
            InventarioIp::where('Id', '=', $idPadre)->update(array('Status' => 2));
            $ipPadre = InventarioIp::find($idPadre);
            $this->ocuparIps($ipPadre->IpAddress, $ipPadre->Netmask, false);
        }
    }

    public function ocuparHijos($idPadre) {
        $hijos = InventarioIp::where('IdPadre', '=', $idPadre)->get();
        foreach ($hijos as $hijo) {
            InventarioIp::where('Id', '=', $hijo->Id)->update(array('Status' => 2));
            $this->ocuparHijos($hijo->Id);
        }
    }

    public function cambiarEstados() {
        $ocupadas = InventarioIpOcupadas::select('IpAddress', 'Netmask')->get();
        foreach ($ocupadas as $padre) {
            $this->ocuparIps($padre->IpAddress, $padre->Netmask, true);
            echo $padre->IpAddress . "/" . $padre->Netmask . "<br>";
        }
    }

}
