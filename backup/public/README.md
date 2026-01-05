# gerenciamento-de-presenca
Um sistema de Gerenciamento de presença para escolas e cursos.

```
backup
├─ aluno_detalhes.php
├─ cadastro_aluno.php
├─ cadastro_rapido.php
├─ database
│  └─ inforescola.sql
├─ lista_alunos.php
├─ README.md
├─ scripts
│  ├─ javascript
│  │  ├─ api
│  │  │  ├─ alunoApi.js
│  │  │  ├─ aulaAPI.js
│  │  │  └─ presencaApi.js
│  │  ├─ app.js
│  │  └─ modules
│  │     ├─ alunos
│  │     │  ├─ alunoUi.js
│  │     │  ├─ deletarAlunoUi.js
│  │     │  └─ listaAlunoUi.js
│  │     ├─ autoDismiss
│  │     │  └─ autoDismiss.js
│  │     ├─ closer
│  │     │  └─ closer.js
│  │     ├─ home
│  │     │  └─ timer.js
│  │     ├─ modalAlunos
│  │     │  └─ openCloseModal.js
│  │     └─ turmas
│  │        ├─ aulaUi.js
│  │        ├─ btnPresencaUi.js
│  │        ├─ listarTurmasAluno.js
│  │        ├─ presencaAvulsaUi.js
│  │        └─ presencaUi.js
│  └─ php
│     ├─ api
│     │  └─ v1
│     │     ├─ aluno.php
│     │     ├─ aluno_por_status.php
│     │     ├─ criar_aula_api.php
│     │     ├─ deletar_aluno.php
│     │     ├─ editar_aluno.php
│     │     ├─ presenca.php
│     │     ├─ presencas_acumuladas.php
│     │     └─ turmas_aluno.php
│     ├─ classes
│     │  ├─ aluno.php
│     │  ├─ aula.php
│     │  ├─ core
│     │  │  └─ model.php
│     │  ├─ presenca.php
│     │  └─ turma.php
│     ├─ config
│     │  └─ database.php
│     ├─ helpers
│     │  ├─ getIdInput.php
│     │  ├─ validator.php
│     │  └─ validators
│     │     ├─ index.php
│     │     ├─ validarDiaSemana_helper.php
│     │     ├─ validarEmail_helper.php
│     │     ├─ validarHora_helper.php
│     │     ├─ validarId_helper.php
│     │     └─ validarTexto_helper.php
│     ├─ includes
│     │  ├─ footer.php
│     │  ├─ head.php
│     │  ├─ navbar.php
│     │  └─ notify.php
│     └─ services
│        ├─ aluno_services.php
│        ├─ aula_services.php
│        ├─ presenca_services.php
│        └─ turma_services.php
├─ style
│  └─ style.css
├─ turmas.php
└─ turma_detalhes.php

```