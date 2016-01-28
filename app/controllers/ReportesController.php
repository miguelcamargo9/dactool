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
            $reporte->VerReporte = "<a href='verreporte/$reporte->IdReporte' title='Ver Reporte $reporte->NombreReporte'>"
                    . "<span style='color:#009BDD; padding-left:30px' class='glyphicon glyphicon-eye-open'></span>"
                    . "</a>";
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

    public function VerReporte($idreporte) {
        switch ($idreporte) {
            case 1:
                return View::make('ReportesController.reporteestados');
                break;
            case 2:
                return View::make('ReportesController.reportevlans');
                break;
            case 3:
                return View::make('ReportesController.reporteinconsistencias');
                break;
            case 5:
                return View::make('ReportesController.reportegraficas');
                break;
            default :
                return Redirect::to('listareportes');
                break;
        }
    }

    public function getReporteEstadosUp() {
        $pais = (Input::get('filtro')) ? Input::get('filtro') : null;
        $conn = DB::connection('atlas');
        $datosa = array();

        $select = "SELECT DI.Location AS Pais,  
                    ISNULL(ST.Name,'-') AS EstadoServicio, 
                    Count(*) as val
                    FROM DashboardInterfaces DI 
                    LEFT JOIN TypeInterfaces TI ON TI.ID = DI.IdTypeInterface 
                    LEFT JOIN Services SE WITH (NOLOCK) ON SE.Id = DI.ServiceId 
                    LEFT JOIN Companies CO WITH (NOLOCK) ON CO.Id = SE.CompanyID 
                    LEFT JOIN ServiceStates ST WITH (NOLOCK) ON ST.Id = SE.StateId 
                    LEFT JOIN Segments SG WITH (NOLOCK) ON SG.Id = SE.SegmentId 
                    LEFT JOIN MediaTypes MT ON MT.Id = SE.MediaTypeId 
                    LEFT JOIN TypeMedio TM ON TM.ID = SE.MediaTypeId WHERE CAST(DI.[Date] AS DATE) = 
                    (SELECT MAX(CAST(DI.[Date] AS DATE)) FROM DashboardInterfaces DI WITH (NOLOCK)) AND DI.ServiceId != 0 AND DI.State = 'Up' ";
        if ($pais['Pais']) {
            $select .= "and DI.Location = '{$pais['Pais']}' ";
        }
        $select .= "group by DI.Location, ISNULL(ST.Name,'-') ";

        $result = $conn->select($select);

        $labels = array('COLOMBIA', 'ARGENTINA', 'BRASIL', 'MEXICO', 'PERU', 'CHILE', 'ECUADOR', 'PANAMA', 'PUERTORICO', 'URUGUAY', 'USA', 'VENEZUELA');
        $series = array('Activo', 'Breakage', 'Cancelado', 'Demo', 'Suspendido', 'Vendido');

        foreach ($result as $estado) {
            $datosa[$estado->Pais][$estado->EstadoServicio] = $estado->val;
        }

        $labels = (isset($pais['Pais'])) ? array($pais['Pais']) : $labels;

        $datospre = array();

        foreach ($series as $serie) {
            foreach ($labels as $label) {
                if (isset($datosa[$label][$serie])) {
                    $datospre[$serie][] = intval($datosa[$label][$serie]);
                } else {
                    $datospre[$serie][] = null;
                }
            }
        }

        $datos = array();
        foreach ($datospre as $value) {
            $datos['data'][] = $value;
        }
        $datos['labels'] = $labels;
        $datos['series'] = $series;
        $datos = json_encode($datos);
        DB::disconnect('atlas');

        return $datos;
    }

    public function getReporteEstadosDown() {
        $pais = (Input::get('filtro')) ? Input::get('filtro') : null;
        $conn = DB::connection('atlas');
        $datosa = array();

        $select = "SELECT DI.Location AS Pais,  
                    ISNULL(ST.Name,'-') AS EstadoServicio, 
                    Count(*) as val
                    FROM DashboardInterfaces DI 
                    LEFT JOIN TypeInterfaces TI ON TI.ID = DI.IdTypeInterface 
                    LEFT JOIN Services SE WITH (NOLOCK) ON SE.Id = DI.ServiceId 
                    LEFT JOIN Companies CO WITH (NOLOCK) ON CO.Id = SE.CompanyID 
                    LEFT JOIN ServiceStates ST WITH (NOLOCK) ON ST.Id = SE.StateId 
                    LEFT JOIN Segments SG WITH (NOLOCK) ON SG.Id = SE.SegmentId 
                    LEFT JOIN MediaTypes MT ON MT.Id = SE.MediaTypeId 
                    LEFT JOIN TypeMedio TM ON TM.ID = SE.MediaTypeId WHERE CAST(DI.[Date] AS DATE) = 
                    (SELECT MAX(CAST(DI.[Date] AS DATE)) FROM DashboardInterfaces DI WITH (NOLOCK)) AND DI.ServiceId != 0 AND DI.State = 'Down' ";
        if ($pais['Pais']) {
            $select .= "and DI.Location = '{$pais['Pais']}' ";
        }
        $select .= "group by DI.Location, ISNULL(ST.Name,'-') ";

        $result = $conn->select($select);

        $labels = array('COLOMBIA', 'ARGENTINA', 'BRASIL', 'MEXICO', 'PERU', 'CHILE', 'ECUADOR', 'PANAMA', 'PUERTORICO', 'URUGUAY', 'USA', 'VENEZUELA');
        $series = array('Activo', 'Breakage', 'Cancelado', 'Demo', 'Suspendido', 'Vendido');

        foreach ($result as $estado) {
            $datosa[$estado->Pais][$estado->EstadoServicio] = $estado->val;
        }

        $labels = (isset($pais['Pais'])) ? array($pais['Pais']) : $labels;

        $datospre = array();

        foreach ($series as $serie) {
            foreach ($labels as $label) {
                if (isset($datosa[$label][$serie])) {
                    $datospre[$serie][] = intval($datosa[$label][$serie]);
                } else {
                    $datospre[$serie][] = null;
                }
            }
        }

        $datos = array();
        foreach ($datospre as $value) {
            $datos['data'][] = $value;
        }
        $datos['labels'] = $labels;
        $datos['series'] = $series;
        $datos = json_encode($datos);
        DB::disconnect('atlas');

        return $datos;
    }
    
    public function getReporteInconsistencias() {
        $pais = (Input::get('filtro')) ? Input::get('filtro') : null;
        $conn = DB::connection('atlas');
        $datosa = array();

        $select = "SELECT DI.Location AS Pais,  
                    ISNULL(ST.Name,'-') AS EstadoServicio, 
                    Count(*) as val
                    FROM DashboardInterfaces DI 
                    LEFT JOIN TypeInterfaces TI ON TI.ID = DI.IdTypeInterface 
                    LEFT JOIN Services SE WITH (NOLOCK) ON SE.Id = DI.ServiceId 
                    LEFT JOIN Companies CO WITH (NOLOCK) ON CO.Id = SE.CompanyID 
                    LEFT JOIN ServiceStates ST WITH (NOLOCK) ON ST.Id = SE.StateId 
                    LEFT JOIN Segments SG WITH (NOLOCK) ON SG.Id = SE.SegmentId 
                    LEFT JOIN MediaTypes MT ON MT.Id = SE.MediaTypeId 
                    LEFT JOIN TypeMedio TM ON TM.ID = SE.MediaTypeId WHERE CAST(DI.[Date] AS DATE) = 
                    (SELECT MAX(CAST(DI.[Date] AS DATE)) FROM DashboardInterfaces DI WITH (NOLOCK)) AND DI.ServiceId != 0 AND DI.State = 'Down' ";
        if ($pais['Pais']) {
            $select .= "and DI.Location = '{$pais['Pais']}' ";
        }
        $select .= "group by DI.Location, ISNULL(ST.Name,'-') ";

        $result = $conn->select($select);

        $labels = array('COLOMBIA', 'ARGENTINA', 'BRASIL', 'MEXICO', 'PERU', 'CHILE', 'ECUADOR', 'PANAMA', 'PUERTORICO', 'URUGUAY', 'USA', 'VENEZUELA');
        $series = array('Activo', 'Breakage', 'Cancelado', 'Demo', 'Suspendido', 'Vendido');

        foreach ($result as $estado) {
            $datosa[$estado->Pais][$estado->EstadoServicio] = $estado->val;
        }

        $labels = (isset($pais['Pais'])) ? array($pais['Pais']) : $labels;

        $datospre = array();

        foreach ($series as $serie) {
            foreach ($labels as $label) {
                if (isset($datosa[$label][$serie])) {
                    $datospre[$serie][] = intval($datosa[$label][$serie]);
                } else {
                    $datospre[$serie][] = null;
                }
            }
        }

        $datos = array();
        foreach ($datospre as $value) {
            $datos['data'][] = $value;
        }
        $datos['labels'] = $labels;
        $datos['series'] = $series;
        $datos = json_encode($datos);
        DB::disconnect('atlas');

        return $datos;
    }

    public function getPaises() {
        $conn = DB::connection('atlas');
        $datosa = array();

        $select = "SELECT DI.Location AS Pais
                    FROM DashboardInterfaces DI 
                    LEFT JOIN TypeInterfaces TI ON TI.ID = DI.IdTypeInterface 
                    LEFT JOIN Services SE WITH (NOLOCK) ON SE.Id = DI.ServiceId 
                    LEFT JOIN Companies CO WITH (NOLOCK) ON CO.Id = SE.CompanyID 
                    LEFT JOIN ServiceStates ST WITH (NOLOCK) ON ST.Id = SE.StateId 
                    LEFT JOIN Segments SG WITH (NOLOCK) ON SG.Id = SE.SegmentId 
                    LEFT JOIN MediaTypes MT ON MT.Id = SE.MediaTypeId 
                    LEFT JOIN TypeMedio TM ON TM.ID = SE.MediaTypeId WHERE CAST(DI.[Date] AS DATE) = 
                    (SELECT MAX(CAST(DI.[Date] AS DATE)) FROM DashboardInterfaces DI WITH (NOLOCK)) AND DI.ServiceId != 0 AND DI.State = 'Down' 
                    group by DI.Location ";

        $result = $conn->select($select);

        foreach ($result as $pais) {
            $datosa[]['pais'] = $pais->Pais;
        }
        $datos = json_encode($datosa);
        DB::disconnect('atlas');

        return $datos;
    }

    public function getReporteEstadosGrafica() {
        $pais = (Input::get('filtro')) ? Input::get('filtro') : null;
        $conn = DB::connection('atlas');
        $datosa = array();

        $select = "SELECT DI.Location as Pais, TM.Description, COUNT(*) as Val 
                    FROM [dbo].[DashboardGraficasInterfaces] DI 
                    LEFT JOIN TypeMedio TM ON TM.ID = DI.IdTypeMedio	
                    WHERE CAST(DI.[Date] AS DATE) = (SELECT MAX(CAST(DI.[Date] AS DATE)) FROM [DashboardGraficasInterfaces] DI WITH (NOLOCK)) 
                    AND DI.Grafica = 0 ";
        if ($pais['Pais']) {
            $select .= "and DI.Location = '{$pais['Pais']}' ";
        }

        $select .= "GROUP BY DI.Location, TM.Description 
                    ORDER BY Pais ";

        $result = $conn->select($select);

        $labels = array('COLOMBIA', 'ARGENTINA', 'BRASIL', 'MEXICO', 'PERU', 'CHILE', 'ECUADOR', 'PANAMA', 'PUERTORICO', 'URUGUAY', 'USA', 'VENEZUELA');
        $series = array('Cobre', 'Fibra', 'Wireless', 'NoAplica');

        foreach ($result as $estado) {
            $datosa[$estado->Pais][$estado->Description] = $estado->Val;
        }

        $labels = (isset($pais['Pais'])) ? array($pais['Pais']) : $labels;

        $datospre = array();

        foreach ($series as $serie) {
            foreach ($labels as $label) {
                if (isset($datosa[$label][$serie])) {
                    $datospre[$serie][] = intval($datosa[$label][$serie]);
                } else {
                    $datospre[$serie][] = null;
                }
            }
        }

        $datos = array();
        foreach ($datospre as $value) {
            $datos['data'][] = $value;
        }
        $datos['labels'] = $labels;
        $datos['series'] = $series;
        $datos = json_encode($datos);
        DB::disconnect('atlas');

        return $datos;
    }

}
