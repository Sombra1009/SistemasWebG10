<?php
/* */
/* Parámetros de configuración de la aplicación */
/* */

// Parámetros de configuración generales
define('RUTA_APP', './');
define('RUTA_IMGS', RUTA_APP . '/img');
define('RUTA_CSS', RUTA_APP);
define('RUTA_JS', RUTA_APP . '/js');
define('INSTALADA', true);

// Parámetros de configuración de la BD
//define('BD_HOST', 'vm002.db.swarm.test');
define('BD_HOST', 'localhost');
define('BD_NAME', 'virtualventure');
define('BD_USER', 'virtualventure');
define('BD_PASS', 'virtualventure');
/*
define('BD_USER', 'ejercicio02');
define('BD_PASS', 'ejercicio02');
*/
/* */
/* Utilidades básicas de la aplicación */
/* */

require_once __DIR__.'/src/Utils.php';

/* */
/* Inicialización de la aplicación */
/* */

if (!INSTALADA) {
	Utils::paginaError(502, 'Error', 'Oops', 'La aplicación no está configurada. Tienes que modificar el fichero config.php');
}

/* */
/* Configuración de Codificación y timezone */
/* */

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

/* */
/* Clases y Traits de la aplicación */
/* */
require_once 'src/Arrays.php';
require_once 'src/MagicProperties.php';

/* */
/* Clases que simulan una BD almacenando los datos en memoria */
/*
require_once 'src/usuarios/memoria/Usuario.php';
require_once 'src/mensajes/memoria/Mensaje.php';
*/

/*
 * Configuramos e inicializamos la sesión para todas las peticiones
 */
session_start([
	'cookie_path' => RUTA_APP, // Para evitar problemas si tenemos varias aplicaciones en htdocs
]);

/* */
/* Inicialización de las clases que simulan una BD en memoria */
/*
Usuario::init();
Mensaje::init();
*/

/* */
/* Clases que usan una BD para almacenar el estado */
/* */
require_once 'src/BD.php';
require_once 'formularios/FormularioLogin.php';
require_once 'formularios/FormularioRegistro.php';
require_once 'formularios/FormularioPerfil.php';
require_once 'formularios/FormularioCompra.php';
require_once 'formularios/FormularioSubirPost.php';
require_once 'formularios/FormularioSubidaSorteo.php';
require_once 'formularios/FormularioModificarSorteo.php';
require_once 'formularios/FormularioSubidaProducto.php';
require_once 'formularios/FormularioModificarProducto.php';
require_once 'formularios/FormularioSubidaNoticia.php';
require_once 'formularios/FormularioModificarNoticia.php';
require_once 'formularios/FormularioSubidaUsuario.php';
require_once 'formularios/FormularioModificarUsuario.php';
require_once 'formularios/FormularioParticiparSorteo.php';
require_once 'formularios/FormularioJuegoCarrito.php';
require_once 'formularios/FormularioValidarCompra.php';
require_once 'formularios/FormularioTarjeta.php';
require_once 'formularios/FormularioResenna.php';
require_once 'src/Usuario.php';
require_once 'src/Producto.php';
require_once 'src/Orders.php';
require_once 'src/OrdersItem.php';
require_once 'src/Noticia.php';
require_once 'src/Categoria.php';
require_once 'src/Sorteo.php';
require_once 'src/Niveles.php';
require_once 'src/Monedas.php';
require_once 'src/Comentario.php';
require_once 'src/Foro.php';
require_once 'src/Post.php';