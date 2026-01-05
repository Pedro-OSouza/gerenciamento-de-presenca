<nav class="navbar is-dark is-fixed-top">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item has-text-weight-bold" href="#">Sistema de Chamada Online</a>
        </div>

        <div class="navbar-menu">
            <div class="navbar-end">
                <a href="<?= url('/turmas') ?>" class="navbar-item">
                    Turmas
                </a>
                <a href="<?= url('/lista') ?>" class="navbar-item">
                    Alunos
                </a>
<!-- =================================== Menu Dropdown ===========================================-->
                <div class="navbar-item dropdown is-hoverable">
                    <div class="dropdown-trigger">
                        <button aria-haspopup="true" aria-controls="dropdown-menu4">
                            <span>Cadastrar</span>
                            <span class="icon is-small">
                                <i class="fas fa-angle-down" aria-hidden="true"></i>
                            </span>
                        </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu4" role="menu">
                        <div class="dropdown-content">
                        <div class="dropdown-item">
                            <a href="<?= url('/cadastro/aluno') ?>" class="navbar-item">Cadastrar Aluno</a>
                            <a href="<?= url('/cadastro/turma') ?>" class="navbar-item">Cadastrar Turma</a>
                        </div>
                        </div>
                    </div>
                </div>
<!-- ============================================================================================-->
                <a href="./cadastro_rapido.php" class="navbar-item">
                    Cadastro rápido
                </a>                
                <a href="#" class="navbar-item">
                    Sair
                </a>
            </div>
        </div>
    </div>
</nav>