<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/hello', 'HomeController@showWelcome', function()
{
	return View::make('hello');
});

/*Routes Home Controller*/
Route::get('/index', array('as' => 'index', 'uses' => 'HomeController@showIndex', 'before' => 'authM'));
Route::get('/', array('as' => 'index', 'uses' => 'HomeController@showIndex', 'before' => 'authM'));
Route::get('/login', array('as' => 'login', 'uses' => 'HomeController@showLogIn'));
Route::get('/logout', array('as' => 'logout', 'uses' => 'HomeController@Logout'));
Route::post('/login', array('as' => 'login', 'uses' => 'HomeController@Login', 'before' => 'csrf'));
Route::get('/getrcs', array('as' => 'getrcs', 'uses' => 'HomeController@getRCS', 'before' => 'authM'));
Route::get('/getinteroutersfbr', array('as' => 'getinteroutersfbr', 'uses' => 'HomeController@getInterfacesRoutersFbr', 'before' => 'authM'));
Route::get('/getnobackup', array('as' => 'getnobackup', 'uses' => 'HomeController@getDeviceNoBackUp', 'before' => 'authM'));
Route::get('/generategraphs', array('as' => 'generategraphs', 'uses' => 'HomeController@generateGraphsView', 'before' => 'authM'));
Route::get('/deletevlan', array('as' => 'deletevlan', 'uses' => 'HomeController@deleteVlanView', 'before' => 'authM'));
Route::post('/generategraphsre', array('as' => 'generategraphsre', 'uses' => 'HomeController@generateGraphsResult', 'before' => 'authM'));
Route::post('/deletevlanre', array('as' => 'deletevlanre', 'uses' => 'HomeController@deleteVlanResult', 'before' => 'authM'));
Route::post('/generategraphs', array('as' => 'generategraphs', 'uses' => 'HomeController@generateGraphs', 'before' => 'authM'));
Route::post('/deletevlan', array('as' => 'deletevlan', 'uses' => 'HomeController@deleteVlan', 'before' => 'authM'));
Route::any('/autoserviceid', array('as' => 'autoserviceid', 'uses' => 'HomeController@autoServiceid', 'before' => 'authM'));
Route::any('/organismoshijos', array('as' => 'organismoshijos', 'uses' => 'HomeController@organismosHijos', 'before' => 'authM'));

/*Routes Equipos Controller*/
Route::any('/equipos', array('as' => 'equipos', 'uses' => 'EquiposController@NuevoEquipo', 'before' => 'authM'));
Route::any('/activarEquipo', array('as' => 'activarEquipo', 'uses' => 'EquiposController@ActivarEquipo', 'before' => 'authM'));
Route::get('/listaequiposper', array('as' => 'listaequiposper', 'uses' => 'EquiposController@VerEquiposPermisos', 'before' => 'authM'));
Route::get('/listaequipos', array('as' => 'listaequipos', 'uses' => 'EquiposController@VerEquipos', 'before' => 'authM|veriPerf'));
Route::post('/datosequipos', array('as' => 'datosequipos', 'uses' => 'EquiposController@DatosEquipos', 'before' => 'authM'));
Route::post('/datosinterfaces', array('as' => 'datosinterfaces', 'uses' => 'EquiposController@DatosInterfaces', 'before' => 'authM'));
Route::post('/verbackup', array('as' => 'buscarbackup', 'uses' => 'EquiposController@VerBackEquipo', 'before' => 'authM'));
Route::get('/verbackup/{device}', array('as' => 'verbackup', 'uses' => 'EquiposController@VerBackEquipo', 'before' => 'authM'));
Route::get('/verinterfaces/{device}', array('as' => 'verinterfaces', 'uses' => 'EquiposController@VerInterfacesEquipo', 'before' => 'authM'));
Route::get('/savedeviceview/{device}', array('as' => 'savedeviceview', 'uses' => 'EquiposController@BackupEquipoVista', 'before' => 'authM'));
Route::get('/syslogdeviceview/{device}', array('as' => 'syslogdeviceview', 'uses' => 'EquiposController@SysLogEquipoVista', 'before' => 'authM'));
Route::post('/savedevice', array('as' => 'savedevice', 'uses' => 'EquiposController@BackupEquipo', 'before' => 'authM'));
Route::post('/syslogequipo', array('as' => 'syslogequipo', 'uses' => 'EquiposController@SysLogEquipo', 'before' => 'authM'));
Route::any('/eliminarequipo', array('as' => 'eliminarequipo', 'uses' => 'EquiposController@EliminarEquipo', 'before' => 'authM'));
Route::get('/editarequipo/{device}', array('as' => 'editarequipo', 'uses' => 'EquiposController@EditarEquipoVista', 'before' => 'authM'));
Route::post('/editarequipo', array('as' => 'editarequipo', 'uses' => 'EquiposController@EditarEquipo', 'before' => 'authM'));
Route::get('/listainterfaces', array('as' => 'listainterfaces', 'uses' => 'EquiposController@VerInterfaces', 'before' => 'authM'));
Route::any('/getequipo', array('as' => 'getequipo', 'uses' => 'EquiposController@getEquipo', 'before' => 'authM'));


/*Routes Tareas Controller */
Route::any('/listatareas', array('as' => 'listatareas', 'uses' => 'TareasController@VerTareas', 'before' => 'authM'));
Route::any('/tareasdatos', array('as' => 'datostareas', 'uses' => 'TareasController@DatosTareas', 'before' => 'authM'));
Route::any('/nuevatarea', array('as' => 'nuevatarea', 'uses' => 'TareasController@NuevaTarea', 'before' => 'authM'));

/*Routes Usuarios Controller */
Route::any('/listausuarios', array('as' => 'listausuarios', 'uses' => 'UsuariosController@VerUsuarios', 'before' => 'authM'));

/*Routes Scripts Controller */
Route::any('/listascripts', array('as' => 'listascripts', 'uses' => 'ScriptsController@VerScripts', 'before' => 'authM'));
Route::get('/verdependencia/{script}', array('as' => 'verdependencia', 'uses' => 'ScriptsController@VerDependenciaScripts', 'before' => 'authM'));

/*Routes Reportes Controller */
Route::any('/listareportes', array('as' => 'listareportes', 'uses' => 'ReportesController@VerReportes', 'before' => 'authM'));
Route::any('/verreporte/{id}', array('as' => 'verreporte', 'uses' => 'ReportesController@VerReporte', 'before' => 'authM'));
Route::any('/reporteestadosup', array('as' => 'reporteestadosup', 'uses' => 'ReportesController@getReporteEstadosUp', 'before' => 'authM'));
Route::any('/reporteestadosdown', array('as' => 'reporteestadosdown', 'uses' => 'ReportesController@getReporteEstadosDown', 'before' => 'authM'));
Route::any('/reporteserviciosgrafica', array('as' => 'reporteserviciosgrafica', 'uses' => 'ReportesController@getReporteEstadosGrafica', 'before' => 'authM'));
Route::any('/reporteInconsistencias', array('as' => 'reporteInconsistencias', 'uses' => 'ReportesController@getReporteInconsistencias', 'before' => 'authM'));
Route::any('/reportes/paises', array('as' => 'reportespaises', 'uses' => 'ReportesController@getPaises', 'before' => 'authM'));

/*Routes Notificaciones Controller */
Route::any('/listanotifiaciones', array('as' => 'listanotifiaciones', 'uses' => 'NotificacionesController@VerNotificaciones', 'before' => 'authM'));

/*Routes WebServices Controller */
Route::any('/listawebservicios', array('as' => 'listawebservicios', 'uses' => 'WebServicesController@VerWebServices', 'before' => 'authM'));

/*Redireccion Pafina 404*/
App::missing(function ($exception){
   return Response::view('error.error404', array(), 404);
});
