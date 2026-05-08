<?php 

use Core\Router;
use Core\ControllerFactory;
use Controllers\AlunoController;
use Controllers\CadastroController;
use Controllers\HomeController;
use Controllers\TurmasController;

/** @var $router \Core\Router */

$router->get('/', function($params, $factory){
    $factory->make(HomeController::class)->index();
});

$router->get('/turmas', function($params, $factory){
    $factory->make(TurmasController::class)->index();
});

$router->get('/turmas/{id}', function($params, $factory){
    $factory->make(TurmasController::class)->show($params['id']);
});

$router->get('/aluno/{id}', function($params, $factory){
    $factory->make(AlunoController::class)->index($params['id']);
});

$router->get('/lista', function($params, $factory){
    $factory->make(AlunoController::class)->lista();
});

$router->get('/cadastro/aluno', function($params, $factory){
    $factory->make(CadastroController::class)->aluno();
});

$router->post('/cadastro/aluno/post', function($params, $factory){
    $factory->make(CadastroController::class)->aluno_post();
});

$router->get('/cadastro/turma', function($params, $factory){
    $factory->make(CadastroController::class)->turma();
});

$router->post('/cadastro/turma/post', function($params, $factory){
    $factory->make(CadastroController::class)->turma_post();
});

return $router;