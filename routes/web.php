<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('perfiles', 'PerfilController');

Route::get('sucursales/clientes/', 'SucursalesController@getclientesucursales');
Route::resource('sucursales', 'SucursalesController');

Route::resource('clientes', 'ClientesController');

Route::get('usuarios/clientes/{id}', 'UsuarioController@usuariosclientes');
Route::post('usuarios/clientes/', 'UsuarioController@save_usuariosclientes');
Route::resource('usuarios', 'UsuarioController');

Route::get('regiones', 'RegionesCiudadesComunasController@getregiones');

Route::get('ciudades/{id}', 'RegionesCiudadesComunasController@getciudades');

Route::get('comunas/{id}', 'RegionesCiudadesComunasController@getcomunas');

Route::resource('categorias', 'CategoriasController');

Route::get('productos_mov/{id}','ProductosController@getmovimiento');
Route::resource('productos', 'ProductosController');

Route::get('movproductos/productos/{id}', 'MovProductosController@productos');
Route::get('movproductos/getproducto/{id}', 'MovProductosController@getproducto');
Route::resource('movproductos', 'MovProductosController');

Route::get('ordenes/sucursales/{id}', 'OrdenesController@sucursales');
Route::get('ordenes/productos/{id}', 'OrdenesController@productos');
Route::get('ordenes/usuarios/{id}', 'OrdenesController@usuarios');
Route::get('ordenes/getproducto/{id}', 'OrdenesController@getproducto');
Route::get('ordenes/getactualizar/{id}', 'OrdenesController@getactualizar');
Route::get('ordenesdetalle/{id}','OrdenesController@getordenedetalle');
Route::get('ordenes/tracking/{id}','OrdenesController@tracking');
Route::post('ordenes/actualizar', 'OrdenesController@actualizar');
Route::get('ordenes/archivo/{id}','OrdenesController@getarchivos');
Route::get('ordenes/getorden/{id}','OrdenesController@getorden');
Route::post('ordenes/update_orden/{id}', 'OrdenesController@update_orden');
Route::get('ordenes/list','OrdenesController@getordenes');

Route::resource('ordenes', 'OrdenesController');

Route::get('clientepresupuesto/sucursales/{id}', 'ClientePresupuestosController@sucursales');
Route::get('clientepresupuesto/productos/{id}', 'ClientePresupuestosController@productos');
Route::get('clientepresupuesto/getproducto/{id}', 'ClientePresupuestosController@getproducto');
Route::get('clientepresupuesto/actualizar/{id}', 'ClientePresupuestosController@actualizar');
Route::get('clientepresupuesto/archivo/{id}','ClientePresupuestosController@getarchivos');
Route::post('clientepresupuesto/update_presupuesto/{id}', 'ClientePresupuestosController@update_presupuesto');
Route::post('clientepresupuesto/actualizar', 'ClientePresupuestosController@actualizar_estado');
Route::post('clientepresupuesto/autorizar', 'ClientePresupuestosController@cliente_autorizar');
Route::resource('clientepresupuesto','ClientePresupuestosController');
	
Route::resource('clienteproductos','ClienteProductosController');