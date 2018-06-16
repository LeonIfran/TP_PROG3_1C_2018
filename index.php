<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require_once "src/clases/personal.php";
require_once "src/clases/personalApi.php";
require_once "src/clases/MWparaAutentificar.php";
require_once "src/clases/MWparaCORS.php";
//MWparaCORS

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/* $app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});
$app->run(); */
//echo var_dump(Personal::TraerUnEmpleado(2));

$app = new \Slim\App(["settings" => $config]);



$app->group('/comanda', function () {
    $this->get('/{id}',\personalApi::class . ':traerUno');
    $this->post('/',\personalApi::class . ':InsertarUno');
    $this->post('/logear',\personalApi::class . ':LogearUno');
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->run();
?>