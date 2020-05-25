
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'Welcome';
//$route['userAccess']='Ctrl_bienvenida/met_useraccess';
//$route['(:any)/userAccess']='Ctrl_bienvenida/met_useraccess';
$route['default_controller'] = 'Ctrl_bienvenida';
$route['home'] = 'Ctrl_bienvenida';
$route['(:any)/home'] = 'Ctrl_bienvenida';

$route['homeAdmin'] = 'Ctrl_bienvenidaAdmin';
$route['(:any)/homeAdmin'] = 'Ctrl_bienvenidaAdmin';

$route['homeUser'] = 'Ctrl_bienvenidaUsuario';
$route['(:any)/homeUser'] = 'Ctrl_bienvenidaUsuario';

$route['userAccess'] = 'Ctrl_accesodeusuarios/met_useraccess';
$route['(:any)/userAccess'] = 'Ctrl_accesodeusuarios/met_useraccess';

//rutas para ingreso general
$route['verificacionIngreso'] = 'Ctrl_accesodeusuarios/met_loginverification';
$route['(:any)/verificacionIngreso'] = 'Ctrl_accesodeusuarios/met_loginverification';

//rutas para administrador
$route['adminLogout'] = 'Ctrl_bienvenidaAdmin/met_logout';
$route['(:any)/adminLogout'] = 'Ctrl_bienvenidaAdmin/met_logout';

$route['adminPanel'] = 'Ctrl_panelAdministrador';
$route['(:any)/adminPanel'] = 'Ctrl_panelAdministrador';

$route['rut_panelUsuarios'] = 'Ctrl_panelUsuarios';
$route['(:any)/rut_panelUsuarios'] = 'Ctrl_panelUsuarios';

$route['rut_panelProductos'] = 'Ctrl_producto';
$route['(:any)/rut_panelProductos'] = 'Ctrl_producto';

$route['rut_panelImagenesGenerales'] = 'Ctrl_panelImagenesGenerales';
$route['(:any)/rut_panelImagenesGenerales'] = 'Ctrl_panelImagenesGenerales';

$route['rut_panelImagenesProductos'] = 'Ctrl_panelImagenesProductos';
$route['(:any)/rut_panelImagenesProductos'] = 'Ctrl_panelImagenesProductos';

$route['rut_panelTemas'] = 'Ctrl_panelTemas';
$route['(:any)/rut_panelTemas'] = 'Ctrl_panelTemas';

$route['rut_panelBitacora'] = 'Ctrl_Bitacora';
$route['(:any)/rut_panelBitacora'] = 'Ctrl_Bitacora';

$route['rut_panelMensajes'] = 'Ctrl_panelMensajes';
$route['(:any)/rut_panelMensajes'] = 'Ctrl_panelMensajes';

//rutas para receta 
$route['rut_panelReceta'] = 'Ctrl_panelReceta';
$route['(:any)/rut_panelReceta'] = 'Ctrl_panelReceta';
$route['rut_RecetasUsuarios'] = 'Ctrl_recetasUsuarios';
$route['(:any)/rut_RecetasUsuarios'] = 'Ctrl_recetasUsuarios';  

//rutas para categorias
$route['rut_panelCategorias'] = 'Ctrl_panelCategoria';
$route['(:any)/rut_panelCategorias'] = 'Ctrl_panelCategoria';
$route['rut_Categorias'] = 'Ctrl_Categorias';
$route['(:any)/rut_Categorias'] = 'Ctrl_Categorias';


$route['rut_panelTransacciones'] = 'Ctrl_ConfirmarPago';
$route['(:any)/rut_panelTransacciones'] = 'Ctrl_ConfirmarPago';

//rutas para usuario
$route['userLogout'] = 'Ctrl_bienvenidaUsuario/met_logout';
$route['(:any)/userLogout'] = 'Ctrl_bienvenidaUsuario/met_logout';
$route['userProfile'] = 'Ctrl_perfilUsuario';
$route['(:any)/userProfile'] = 'Ctrl_perfilUsuario';
$route['forgotPass'] = 'Ctrl_recupcontra';
$route['(:any)/forgotPass'] = 'Ctrl_recupcontra';
$route['checkAddress'] = 'Ctrl_direcciones';
$route['(:any)/checkAddress'] = 'Ctrl_direcciones';
/*$route['changePassword'] = 'Ctrl_contrasenas';	
$route['(:any)/changePassword'] = 'Ctrl_contrasenas';*/

//rutas para transacciones y factura Usuario
$route['userTransactions'] = 'Ctrl_transaccionesUsuarios';
$route['(:any)/userTransactions'] = 'Ctrl_transaccionesUsuarios';
$route['rut_transacAprobadas'] = 'Ctrl_transaccionesUsuarios/met_transacAprobadas';
$route['(:any)/rut_transacAprobadas'] = 'Ctrl_transaccionesUsuarios/met_transacAprobadas';
$route['rut_transacProceso'] = 'Ctrl_transaccionesUsuarios/met_transancProceso';
$route['(:any)/rut_transacProceso'] = 'Ctrl_transaccionesUsuarios/met_transancProceso';
$route['rut_transacRechazadas'] = 'Ctrl_transaccionesUsuarios/met_transacRechazadas';
$route['(:any)/rut_transacRechazadas'] = 'Ctrl_transaccionesUsuarios/met_transacRechazadas';
$route['rut_facturaUsuario'] = 'Ctrl_transaccionesUsuarios/met_facturaUsuario';
$route['(:any)/rut_facturaUsuario'] = 'Ctrl_transaccionesUsuarios/met_facturaUsuario';

//rutas para productos
$route['productos'] = 'Ctrl_producto';
$route['(:any)/productos'] = 'Ctrl_producto';
$route['productosUsuarios'] = 'Ctrl_productosUsuarios';
$route['(:any)/productosUsuarios'] = 'Ctrl_productosUsuarios';
$route['productosUsuariosTEST'] = 'Ctrl_productosUsuariosTEST';
$route['(:any)/productosUsuariosTEST'] = 'Ctrl_productosUsuariosTEST';


//Unit test
$route['unittest'] = 'testBitacora';
$route['(:any)/unittest'] = 'testBitacora';
$route['unittestTrans'] = 'Ctrl_testTransacciones';
$route['(:any)/unittestTrans'] = 'Ctrl_testTransacciones';


//rutas para invitado
$route['userRegistration'] = 'Ctrl_registroUsuario';
$route['(:any)/userRegistration'] = 'Ctrl_registroUsuario';
$route['rut_Nosotras'] = 'Ctrl_nosotras';
$route['(:any)/rut_Nosotras'] = 'Ctrl_nosotras';
$route['rut_Contactenos'] = 'Ctrl_contactenos';
$route['(:any)/rut_Contactenos'] = 'Ctrl_contactenos';


//Rutas para Carrito
$route['carrito'] = 'Ctrl_Carrito';
$route['(:any)/carrito'] = 'Ctrl_Carrito';

//promos
$route['promo'] = 'Ctrl_promociones';
$route['(:any)/promo'] = 'Ctrl_promociones';
$route['rut_panelPromociones'] = 'Ctrl_panelPromociones';
$route['(:any)/rut_panelPromociones'] = 'Ctrl_panelPromociones';


//DEFAULT ROUTES
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
