<<<<<<< HEAD
## Mini Documentação Oficial do Projeto
(sync did)

```
    project/
├─ public/
│  ├─ index.php
│  ├─ assets/
│  │  ├─ css/
│  │  ├─ js/
│  │  └─ images/
│  └─ uploads/
│
├─ app/
│  ├─ core/
│  │  ├─ Router.php
│  │  ├─ Controller.php
│  │  ├─ Model.php
│  │  ├─ Response.php
│  │  └─ Request.php
│  │
│  ├─ controllers/
│  │  ├─ AlunoController.php
│  │  ├─ TurmaController.php
│  │  ├─ AulaController.php
│  │  └─ PresencaController.php
│  │
│  ├─ models/
│  │  ├─ Aluno.php
│  │  ├─ Turma.php
│  │  ├─ Aula.php
│  │  └─ Presenca.php
│  │
│  ├─ services/
│  │  ├─ AlunoService.php
│  │  ├─ TurmaService.php
│  │  ├─ AulaService.php
│  │  └─ PresencaService.php
│  │
│  ├─ views/
│  │  ├─ aluno/
│  │  │  ├─ lista.php
│  │  │  ├─ detalhes.php
│  │  │  └─ cadastro.php
│  │  ├─ turma/
│  │  │  ├─ lista.php
│  │  │  └─ detalhes.php
│  │  ├─ includes/
│  │  │  ├─ head.php
│  │  │  ├─ navbar.php
│  │  │  └─ footer.php
│  │  └─ home.php
│
├─ routes/
│  ├─ web.php
│  └─ api.php
│
├─ config/
│  ├─ database.php
│  └─ env.php
│
├─ src_js/            ← JS modular, organizado e profissional
│  ├─ api/
│  │  ├─ aluno.js
│  │  ├─ aula.js
│  │  ├─ presenca.js
│  │  └─ turma.js
│  ├─ ui/
│  │  ├─ alunos/
│  │  ├─ turmas/
│  │  └─ componentes/
│  └─ main.js
│
├─ database/
│  └─ schema.sql
│
└─ README.md
```

### 📌 1. Visão Geral

Este projeto usa um MVC minimalista, inspirado em micro-frameworks, mas 100% PHP puro para manter performance máxima em servidores antigos.

Fluxo:

Request → Router → Controller → Service → Model → View → Response

### 📌 2. Public Folder

public/ contém apenas:

index.php — ponto de entrada do sistema.

assets/ — CSS, JS compilado, imagens.

uploads/ — arquivos enviados pelo usuário.

O servidor (Apache ou Nginx) deve apontar PARA ESSA pasta.

### 📌 3. Core (motor do sistema)

app/core/

Arquivo	Função
Router.php	Define e executa rotas web e API
Controller.php	Classe base de todos controllers
Model.php	Classe base dos models (CRUD essencial)
Request.php	Abstrai GET/POST/JSON/AJAX
Response.php	Padroniza respostas (view, JSON, redirect)

### 📌 4. Controllers

app/controllers/

Responsáveis por receber requests, acionar serviços e retornar views ou JSON.

Ex.: AlunoController.php

index() → lista alunos

show($id) → detalhes

store() → criar

update($id) → editar

delete($id) → excluir

Controllers não acessam o banco diretamente.

### 📌 5. Services

app/services/

Aqui fica a regra de negócio.

validações

cálculos

lógica de presença

lógica de turma

criação de aulas

regras específicas

Controllers chamam Services.
Services chamam Models.

### 📌 6. Models

app/models/

Aqui está:

acesso ao banco

métodos CRUD

consultas específicas

Cada model representa uma tabela.

### 📌 7. Views

app/views/

Somente renderizam página.
Sem regras.
Sem require de service.
Sem SQL.
Sem manipulação de dados.

Organizadas por módulo:

views/
  aluno/
    lista.php
    detalhes.php
    cadastro.php


Partials reaproveitáveis ficam em:

views/partials/
  head.php
  navbar.php
  footer.php

### 📌 8. Rotas

routes/web.php — páginas HTML da aplicação
routes/api.php — JSON usado pelo AJAX

Formato:

$router->get('/alunos', 'AlunoController@index');
$router->get('/aluno/{id}', 'AlunoController@show');
$router->post('/aluno', 'AlunoController@store');

### 📌 9. JavaScript Modular

src_js/ contém o código organizado:

api/ → chamadas AJAX

ui/ → componentes e lógica visual

main.js → inicialização geral

Os arquivos são copiados ou compilados para public/assets/js.

### 📌 10. Config

config/database.php — conexão PDO
config/env.php — central de variáveis (futuramente lida pelo Node se quiser)

📌 11. Database

database/schema.sql contém toda a estrutura do banco.
=======
# gerenciamento-de-presenca
### Em desenvolvimento
Um sistema de Gerenciamento de presença para escolas e cursos.
>>>>>>> 7dc3845b0cf5259bb6681020d5e94aa52513eecf
