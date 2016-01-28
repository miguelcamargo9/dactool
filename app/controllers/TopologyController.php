<?php

class TopologyController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Topology Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/topology', array('as' => 'topology', 'uses' => 'TopologyController@VerTopologia', 'before' => 'authM'));
      |
     */

    public function VerTopologia() {
        return View::make('TopologyController.viewtopology');
    }

    public function getTopology() {
        $conn = DB::connection('sqlsrvtest');
        $select = "exec GetTopologyRing";
        $result = $conn->select($select);
        $datos = json_encode($result);
        DB::disconnect('sqlsrvtest');
        return $datos;
    }
        
    public function getDevice() {
        $nodoObj = Nodes::select('Caption')->where('NodeId', '=', intval(Input::get('nodeId')))->first();
        $deviceObj = Equipos::with('Fabricante')->with('Ubicacion')->with('Tipo')->where('name', '=', $nodoObj->Caption)->first();
        $datos = json_encode($deviceObj->toArray());
        return $datos;
    }

}
