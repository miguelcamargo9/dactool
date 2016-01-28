<?php

class TareasController extends BaseController {
    /*
      |
      |	Route::any('/listatareas', array('as' => 'listatareas', 'uses' => 'TareasController@VerTareas', 'before' => 'authM'));
      |
     */

    public function VerTareas() {
        return View::make('TareasController.tareas');
    }

    public function DatosTareas() {
        return Tarea::all();
    }

    public function NuevaTarea() {
        $enviado = Input::get('enviado');
        if (isset($enviado)) {
            $rules = $this->getRulesNuevaTarea();
            $messages = $this->getMensajesNuevaTarea();
            $validator = Validator::make(Input::All(), $rules, $messages);
            if ($validator->passes()) {
                $insert = $this->InsertarTarea(Input::all());
                if ($insert === 1) {
                    $mensaje = 'Tarea Creada con Éxito';
                    $visible = false;
                } else {
                    
                }
                return Redirect::route('listatareas')->withInput(Input::flash());
            } else {
                Session::flash('visibleNuevo', TRUE);
                return Redirect::route('listatareas')->withInput(Input::flash())->withErrors($validator);
            }
        } else {
            Session::flash('mensajeError', $mensajeError);
            Session::flash('visibleNuevo', TRUE);
            return Redirect::route('listatareas');
        }
    }

    public function getRulesNuevaTarea() {
        $rules = array(
            'nombre' => array('required', 'regex:/^[\\pL\\pN ]+$/u', 'min:3', 'max:80'),
            'ruta' => array('required'),
            'minutos' => array('min:0', 'max:59'),
            'horas' => array('min:0', 'max:23'),
            'diames' => array('min:1', 'max:31'),
            'mes' => array('min:1', 'max:12'),
            'username' => array('required')
        );
        return $rules;
    }

    public function getMensajesNuevaTarea() {
        $messages = array(
            'nombre.required' => 'El campo nombre es requerido',
            'nombre.regex' => 'El campo nombre solo admite letras y numeros',
            'ruta.required' => 'El campo ruta es requerido',
            'username.required' => 'El campo usuario es requerido'
        );
        return $messages;
    }

    public function InsertarTarea($inputs) {
        echo "<pre>";
        print_r($inputs);

        $fechas = $this->calcularProximaEjecucion($inputs);

        $tarea = new Tarea;
        $tarea->RutaScript = $inputs["ruta"];
        $tarea->Nombre = $inputs["nombre"];
        $tarea->Parametros = $inputs["parametros"];
        $tarea->ProximaEjecucion = $fechas["Ejecucion"];
        $tarea->Intervalo = $fechas["Intervalo"];
        $tarea->Minutos = $inputs["minutos"];
        $tarea->Horas = $inputs["horas"];
        $tarea->DiaMes = $inputs["diames"];
        $tarea->Mes = $inputs["mes"];
        $tarea->Usuario = $inputs["username"];
        $dia = "";
        if (isset($inputs["dias"])) {
            if (count($inputs["dias"]) == 7) {
                $tarea->DiaSemana = "*";
            } else {
                foreach ($inputs["dias"] as $numeroDia => $value) {
                    $dia .= $numeroDia . ",";
                }
            }
            $tarea->DiaSemana = ($dia) ? substr($dia, 0, -1) : $tarea->DiaSemana;
        }
        
        $tarea->save();
    }

    public function calcularProximaEjecucion($inputs) {

        $minutos = ($inputs["minutos"]) ? $inputs["minutos"] : 0;

        //LOGICA SOLO PARA MINUTOS
        if (!$inputs["horas"] && !$inputs["diames"] && !$inputs["mes"]) {
            $dia = date("d");
            $mes = date("m");
            if (isset($inputs["cadaminuto"])) {
                $horas = date("H");
                $date = date("Y-m-d H:i:s", mktime($horas, date("i") + $minutos, 0, $mes, $dia, date("Y")));
                $int = $minutos * 60;
                $datePro = date("Y-m-d H:i:s", mktime($horas, date("i") + $minutos, 0, $mes, $dia, date("Y")) + $int);
            } else {
                $horas = ($inputs["horas"]) ? $inputs["horas"] : (($inputs["minutos"] >= date("i")) ? date("H") : date("H") + 1 );
                $date = date("Y-m-d H:i:s", mktime($horas, $minutos, 0, $mes, $dia, date("Y")));
                $int = (60 * 60);
                $datePro = date("Y-m-d H:i:s", mktime($horas, $minutos, 0, $mes, $dia, date("Y")) + $int);
            }
            //LOGICA SOLO PARA HORAS, CON O SIN MINUTOS
        } elseif ($inputs['horas'] && (!$inputs["diames"] && !$inputs["mes"])) {
            $horas = $inputs['horas'];
            $dia = date("d");
            $mes = date("m");
            if (isset($inputs["cadahora"])) {
                $date = date("Y-m-d H:i:s", mktime(date("H") + $horas, $minutos, 0, $mes, $dia, date("Y")));
                $int = ($horas * 60 * 60);
                $datePro = date("Y-m-d H:i:s", mktime(date("H") + $horas, $minutos, 0, $mes, $dia, date("Y")) + $int);
            } else {
                $dia = ($inputs["horas"] >= date("H")) ? date("d") : date("d") + 1;
                $date = date("Y-m-d H:i:s", mktime($horas, $minutos, 0, $mes, $dia, date("Y")));
                $int = (24 * 60 * 60);
                $datePro = date("Y-m-d H:i:s", mktime($horas, $minutos, 0, $mes, $dia, date("Y")) + $int);
            }
        } elseif ($inputs['diames'] && (!$inputs["mes"])) {
            $horas = ($inputs['horas']) ? $inputs['horas'] : 0;
            $dia = $inputs['diames'];

            $mes = ($inputs["diames"] >= date("d")) ? date("m") : date("m") + 1;
            $date = date("Y-m-d H:i:s", mktime($horas, $minutos, 0, $mes, $dia, date("Y")));
            $datePro = date("Y-m-d H:i:s", mktime($horas, $minutos, 0, $mes + 1, $dia, date("Y")));
            $d1 = new DateTime($date);
            $d2 = new DateTime($datePro);
            $int = ($d2->diff($d1)->days) * (24 * 60 * 60);
        } elseif ($inputs["mes"]) {
            $dia = ($inputs["diames"]) ? $inputs["diames"] : 1;
            $horas = ($inputs['horas']) ? $inputs['horas'] : 0;
            $mes = $inputs["mes"];
            $date = date("Y-m-d H:i:s", mktime($horas, $minutos, 0, $mes, $dia, date("Y")));
            $datePro = date("Y-m-d H:i:s", mktime($horas, $minutos, 0, $mes, $dia, date("Y") + 1));
            $d1 = new DateTime($date);
            $d2 = new DateTime($datePro);
            $int = ($d2->diff($d1)->days) * (24 * 60 * 60);
        }

        $result = array();
        $result["FechaActual"] = date("Y-m-d H:i:s");
        $result["Ejecucion"] = $date;
        $result["ProximaEjecucion"] = $datePro;
        $result["Intervalo"] = $int;
//
//        echo "<pre>";
//        print_r($result);
//
//        die();

        return $result;
    }

}
