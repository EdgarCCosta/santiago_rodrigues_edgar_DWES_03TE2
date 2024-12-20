<?php
// Incluir las clases necesarias para el enrutamiento y los controladores
require_once '../core/Router.php';
require_once "../app/controllers/ProductsController.php";

// Definir las rutas del API y los parámetros asociados (controlador, acción y método HTTP)
$routes = [
    '/DWES/v1/public/products/get' => [
        'controller' => 'ProductsController',
        'action' => 'getAllProducts',
        'method' => 'GET'
    ],
    '/DWES/v1/public/products/get/{id}' => [
        'controller' => 'ProductsController',
        'action' => 'getProduct',
        'method' => 'GET'
    ],
    '/DWES/v1/public/products/add' => [
        'controller' => 'ProductsController',
        'action' => 'addProduct',
        'method' => 'POST'
    ],
    '/DWES/v1/public/products/update/{id}' => [
        'controller' => 'ProductsController',
        'action' => 'updateProduct',
        'method' => 'PUT'
    ],
    '/DWES/v1/public/products/delete/{id}' => [
        'controller' => 'ProductsController',
        'action' => 'deleteProduct',
        'method' => 'DELETE'
    ]
];

// Crear una nueva instancia del enrutador
$router = new Router();

// Registrar las rutas definidas en el enrutador
foreach ($routes as $route => $params) {
    $router->add($route, $params);
}

// Obtener la URI solicitada y el metodo HTTP de la query actua;
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = strtok($requestUri, '?');

// Comprobar si la URI y el metodo coinciden con alguna de las rutas definidas
if ($router->matchRoutes($requestUri, $requestMethod)) {

    // Obtener el nombre del controlador y la accion desde los parametros
    $controllerNombre = $router->getParams()['controller'];
    $actionNombre = $router->getParams()['action'];

    $controller = new $controllerNombre();

    // Llamar a la acción en el controlador y pasarle los parámetros necesarios
    $controller->$actionNombre($router->getParams());
} else {
    http_response_code(404);
    echo json_encode(['error' => '404 Not Found']);
}
?>