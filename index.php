<?php 

require_once __DIR__ . '/SRC/Controller/Controller.php';
require_once __DIR__ . '/SRC/Model/APIClient.php';
require_once __DIR__ . '/SRC/Request/Request.php';
require_once __DIR__ . '/SRC/Router/Router.php';


$method = $_SERVER['REQUEST_METHOD']; # Extração do método HTTP da requisição.
$route = $_SERVER['REQUEST_URI']; # Extração da rota para qual foi endereçada a requisição.


$request = new Request($method, $route);


$apiClient = new APIClient();


$controller = new Controlador($apiClient);


$router = new Router();


$router->route($request, $controller);





?>