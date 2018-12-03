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

$app->group('/comanda', function () {
    $this->get('/{id}',\personalApi::class . ':traerUno');
    $this->post('/',\personalApi::class . ':InsertarUno');
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

$app->group('/pedidos',function () {
    $this->get('/todos',\pedidosApi::class . ':TraerTodos');
    $this->post('/mesa',\pedidosApi::class . ':TraerUno');
    $this->post('/detalles', \pedidosApi::class . ':TraerUnoDetalles');
    $this->post('/alta', \pedidosApi::class . ':CargarUno');
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
$app->group('/detalles',function () {
    $this->post('/alta', \detallesApi::class . ':CargarUno');
    $this->post('/modificacion', \detallesApi::class . ':ModificarUno');
    $this->post('/pendientes', \detallesApi::class . ':TraerPendientes');
});
$app->group('/mesas',function () {
    $this->post('/esperando', \mesasApi::class . ':ModificarEsperando');
    $this->post('/servida', \mesasApi::class . ':ModificarServir');
    $this->post('/cuenta', \mesasApi::class . ':ModificarCuenta');
    $this->post('/cerrar', \mesasApi::class . ':ModificarCerrar');
    $this->post('/abrirencuesta', \encuestasApi::class . ':AbrirUno');
    
});
$app->group('/clientes',function () {
    $this->get('/pedido/{id}', \detallesApi::class . ':TraerUnoClientes');
    $this->post('/encuesta',\encuestasApi::class . ':ModificarEncuesta');
})->add(\MWparaCORS::class . ':HabilitarCORSTodos');
$app->run();
?>