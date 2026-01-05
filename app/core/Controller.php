<?php

namespace Core;

abstract class Controller{
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    // * Redenriza uma  view dentro de /app/view
    protected function view(string $template, array $data = []):void {
        $viewPath = __DIR__ . "/../views/" . $template . '.php';

        if(!file_exists($viewPath)){
            throw new \Exception("View {$template} não encontrada");
        }

        extract($data);

        require $viewPath;
    }

    // * retorna JSON para chamadas AJAX/API

    protected function json(mixed $data, int $status = 200):void{
        $this->response->status($status)->json($data)->send();
    }

    protected function redirect(string $url):void{
        $this->response->redirect($url);
    }
}