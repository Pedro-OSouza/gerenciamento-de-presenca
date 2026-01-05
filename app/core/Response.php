<?php
namespace Core;

class Response{
    private int $status = 200;
    private array $headers = [];
    private mixed $content = null;

    public function status(int $code): self{
        $this->status = $code;
        return $this;
    }

    public function header(string $name, string $value):self{
        $this->headers[$name] = $value;
        return $this;
    }

    public function json(array $data):self {
        $this->header("Content-Type", "application/json; charset=utf-8");
        $this->content = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $this;
    }

    public function html(string $html):self{
        $this->header("Content-Type", "text/html; charset=utf-8");
        $this->content = $html;
        return $this;
    }

    public function redirect(string $url): void{
        header("Location {$url}");
        exit();
    }

    public function view(string $path, array $data = []): self{
        extract($data);
        ob_start();
        require __DIR__ . "/../views{$path}.php";
        $html = ob_get_clean();

        return $this->html($html);
    }

    public function send():void {
        http_response_code($this->status);

        foreach($this->headers as $name => $value){
            header("$name: $value");
        }

        echo $this->content;
    }
}