<?php

use Core\Router;
use Controllers\API\AlunoAPIController;
use Controllers\API\AulaAPIController;
use Controllers\Api\PresencasAPIController;

/** @var $router \Core\Router */

$router->get('/api/v1/aluno', function($params, $factory){
    $factory->make(AlunoAPIController::class)->getAluno();
});

$router->get('/api/v1/aluno/filter', function($params, $factory){
    $factory->make(AlunoAPIController::class)->filterByStatus();
});

$router->post('/api/v1/aluno/edit', function($params, $factory){
    $factory->make(AlunoAPIController::class)->editAluno();
});

$router->delete('/api/v1/aluno/delete', function($params, $factory){
    $factory->make(AlunoAPIController::class)->deleteAluno();
});

$router->post('/api/v1/aula/criar', function($params, $factory){
    $factory->make(AulaAPIController::class)->criarAula();
});

$router->put('/api/v1/presenca/marcar', function($params, $factory){
    $factory->make(PresencasAPIController::class)->setPresenca();
});

$router->get('/api/v1/presenca/historico', function($params, $factory){
    $factory->make(PresencasAPIController::class)->getHistory();
});

return $router;