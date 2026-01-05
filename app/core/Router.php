<?php

namespace Core;

class Router {
    private array $routes = [
        "GET" => [],
        "POST" => [],
        "PUT" => [],
        "PATCH" => [],
        "DELETE" => []
    ];
    

    public function get(string $path, callable $handler){
        $this->routes['GET'][$path] = $handler;    
    }

    public function post(string $path, callable $handler){
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, callable $handler){
        $this->routes['PUT'][$path] = $handler;
    }
    
    public function patch(string $path, callable $handler){
        $this->routes['PATCH'][$path] = $handler;
    }
    
    public function delete(string $path, callable $handler){
        $this->routes['DELETE'][$path] = $handler;
    }
    

    public function dispatch(){

        $request = new Request();
        $response = new Response();
        $factory = new ControllerFactory($request, $response);

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        //detect subdir 
        $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

        if($basePath !== '/'){
            $uri = preg_replace('#^'.preg_quote($basePath).'#', '', $uri);
        }

        if($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        if(isset($this->routes[$method][$uri])){
            $handler = $this->routes[$method][$uri];
            return $handler([], $factory); 
        }

        foreach($this->routes[$method] as $path => $handler){
            $pattern = preg_replace('#\{([a-zA-Z_]+)\}#', '(?P<$1>[a-zA-Z0-9_-]+)', $path);
            $pattern = "#^{$pattern}$#";

            if(preg_match($pattern, $uri, $matches)){
                return $handler($matches, $factory); 
            }
        }

        /* $handler = $this->routes[$method][$uri] ?? null;

        if($handler){
            return $handler();
        } */

        http_response_code(404);
        echo "404 - Página não encontrada";
    }


}