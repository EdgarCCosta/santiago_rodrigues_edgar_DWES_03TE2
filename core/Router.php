<?php

class Router
{
    private $routes = []; // Almacena las rutas definidas
    private $params = []; // Almacena los parametros de la ruta coincidente

    // Agregar una nueva ruta al enrutador
    public function add($route, $params)
    {
        $params['method'] = $params['method'] ?? 'GET';
        $this->routes[$route] = $params;
    }

    // Comprobar si la URL y el metodo coinciden con alguna ruta definida
    public function matchRoutes($url, $method)
    {

        // Registrar todas las rutas definidas en el enrutador
        foreach ($this->routes as $route => $params) {
            // Convertir la ruta a un patrón de expresion regular para capturar parametros
            $routePattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $route);
            $routePattern = str_replace('/', '\/', $routePattern);
            $routePattern = '/^' . $routePattern . '$/';

            // Comprobar si la URL coincide con el pattern
            if (preg_match($routePattern, $url, $matches)) {

                // Verificar si el metodo HTTP también coincide
                if ($params['method'] === $method) {
                    $this->params = $params;
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $this->params[$key] = $value;
                        }
                    }
                    return true;
                } else {
                    http_response_code(405);
                    echo json_encode(['error' => 'Metodo no permitido']);
                    return false;
                }
            }
        }
        return false;
    }

    // Obtener los parametros de la ruta coincidente
    public function getParams()
    {
        return $this->params;
    }
}
?>