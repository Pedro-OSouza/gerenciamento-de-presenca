<?php

namespace Core;

class Request{
    private string $method;
    private string $uri;
    private array $query = [];
    private array $body = [];
    private array $headers = [];

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        $this->query = $_GET ?? [];
        $this->headers = $this->parseHeaders();

        //corpo normal 
        $this->body = $_POST ?? [];

        //se JSon sobrescrever
        $this->tryParseJson();
    }

    private function parseHeaders(): array{
        $h = [];

        foreach($_SERVER as $key => $value){
            if(str_starts_with($key, 'HTTP_')){
                $name = str_replace('_','-', strtolower(substr($key, 5)));
                $h[$name] = $value;
            }
        }

        return $h;
    }

    private function tryParseJson(): void{
        $contentType = $this->headers['content-type'] ?? '';

        if(stripos($contentType, 'application/json') !== false){
            $raw = file_get_contents('php://input');
            $decoded = json_decode($raw, true);

            if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)){
                $this->body = $decoded;
            }
        }
    }

    // GETTERS

    public function method(): string { return $this->method; }
    public function uri(): string { return $this->uri; }
    public function query(): array { return $this->query;}
    public function body(): array {return $this->body;}
    public function headers(): array {return $this->headers;}

    public function input(string $key, $default = null){
        return $this->body[$key] ?? $this->query[$key] ?? $default;
    }
}