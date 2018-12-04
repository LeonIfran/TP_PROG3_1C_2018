<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
date_default_timezone_set('America/Argentina/Buenos_Aires');
require './vendor/autoload.php';
require_once "src/clases/personal.php";
require_once "src/clases/personalApi.php";
require_once "src/clases/pedidosApi.php";
require_once "src/clases/detallesApi.php";
require_once "src/clases/detalles.php";
require_once "src/clases/mesasApi.php";
require_once "src/clases/encuestasApi.php";

require_once "src/clases/MWparaAutentificar.php";
require_once "src/clases/MWparaCORS.php";
//MWparaCORS

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});
/* $app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
}); */

$app->group('/login', function () {
    $this->post('/',\personalApi::class . ':LogearUno');

});

$app->group('/pedidos',function () {
    $this->post('/alta', \pedidosApi::class . ':CargarUno');
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

$app->group('/detalles',function () {
    $this->post('/alta', \detallesApi::class . ':CargarUno');
    $this->post('/modificacion', \detallesApi::class . ':ModificarUno');
    $this->post('/pendientes', \detallesApi::class . ':TraerPendientes');
    $this->post('/preparar', \detallesApi::class . ':PrepararPedido');
    $this->post('/terminar', \detallesApi::class . ':TerminarPedido');
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

$app->group('/socios',function () {
    $this->post('/pedidos', \pedidosApi::class . ':TraerTodosConDetalle');
    $this->post('/cerrar', \mesasApi::class . ':ModificarCerrar');
    $this->post('/factura', \mesasApi::class . ':CargarFactura');
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

$app->group('/mesas',function () {
    $this->post('/esperando', \mesasApi::class . ':ModificarEsperando');
    $this->post('/servida', \mesasApi::class . ':ModificarServir');
    $this->post('/cuenta', \mesasApi::class . ':ModificarCuenta');
    $this->post('/abrirencuesta', \encuestasApi::class . ':AbrirUno');   
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

$app->group('/clientes',function () {
    $this->get('/pedido/{id}', \detallesApi::class . ':TraerUnoClientes');
    $this->post('/encuesta',\encuestasApi::class . ':EncuestaCalificar');
})->add(\MWparaCORS::class . ':HabilitarCORSTodos');

$app->group('/admin',function () {
    $this->post('/empleados/logeos', \personalApi::class . ':TraerLogs');
    $this->post('/operaciones/areas', \detallesApi::class . ':TraerPorArea');
    $this->post('/operaciones/areas/empleado', \detallesApi::class . ':TraerPorAreaID');
    $this->post('/operaciones/individual', \detallesApi::class . ':TraerOperacionesEmpIndv');
    $this->post('/empleados/alta',\personalApi::class . ':InsertarUno');
    $this->post('/empleados/estado', \personalApi::class . ':CambiarEstado');
    $this->post('/empleados/borrar', \personalApi::class . ':BorrarUno');
    $this->post('/pedidos/vendidos',\detallesApi::class . ':TraerVendidos');
    $this->post('/pedidos/tardios',\detallesApi::class . ':TraerTarde');
    $this->post('/pedidos/cancelados',\detallesApi::class . ':TraerEstados');
    $this->post('/mesas/alta',\mesasApi::class . ':CargarUno');
    $this->post('/mesas/facturacion',\mesasApi::class . ':TraerFacturados');
    $this->post('/mesas/facturas',\mesasApi::class . ':TraerFacturaMayorMenor');
    $this->post('/mesas/fechas',\mesasApi::class . ':TrearFechas');
    $this->post('/mesas/comentarios',\mesasApi::class . ':TraerComentarios');
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
$app->run();
?>