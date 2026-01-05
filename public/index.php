<?php

require_once __DIR__ . '/../autoload.php';

require __DIR__ . '/../app/helpers/url.php';

$router = new \Core\Router();

// Carrega rotas web
require __DIR__ . '/../app/routes/web.php';

// Carrega rotas api
require __DIR__ . '/../app/routes/api.php';

// Despacha
$router->dispatch();