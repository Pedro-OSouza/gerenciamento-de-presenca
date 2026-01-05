<?php

namespace Core;

class ControllerFactory{
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }

    public function make(string $controllerClass):Controller{
        if(!class_exists($controllerClass)){
            throw new \Exception("Controller {$controllerClass} não encontrado");
        }

        return new $controllerClass($this->request, $this->response);
    }
}