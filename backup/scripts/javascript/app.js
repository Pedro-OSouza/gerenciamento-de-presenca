import autoDismiss from './modules/autoDismiss/autoDismiss.js';
import closer from './modules/closer/closer.js';



// Carrega módulos conforme a página
if (document.querySelector('.btn-presenca')) {
    import('./modules/turmas/presencaUi.js');
    import('./modules/turmas/btnPresencaUi.js')
}

if(document.querySelector("#tabela-lista-alunos")){
    import('./modules/alunos/listaAlunoUi.js')
    import('./modules/alunos/deletarAlunoUi.js')
}

if (document.querySelector('.button-criar-aula')) {
    import('./modules/turmas/aulaUi.js')
}

if (document.querySelector('#nome-aluno')) {
    import('./modules/alunos/alunoUi.js')
}

if(document.querySelector(".toggle-closer") && document.querySelector(".toggle-closer-btn")){
    closer('.toggle-closer', '.toggle-closer-btn')

}

if(document.querySelector('.auto-dismiss')){
    autoDismiss('.auto-dismiss')
}

if(document.querySelector('#openModal')){
    import("./modules/modalAlunos/openCloseModal.js")
}

if(document.querySelector("#enviarAvulsa")){
    import('./modules/turmas/presencaAvulsaUi.js')
}

if(document.querySelector("#alunoAvulso")){
    import('./modules/turmas/listarTurmasAluno.js')
}

if(document.querySelector("#data-hoje")){
    import('./modules/home/timer.js')
}