import autoDismiss from './ui/componentes/autoDismiss/autoDismiss.js';
import closer from './ui/componentes/closer/closer.js';



// Carrega módulos conforme a página
if (document.querySelector('.btn-presenca')) {
    import('./ui/turmas/presencaUi.js');
    import('./ui/turmas/btnPresencaUi.js')
}

if(document.querySelector("#tabela-lista-alunos")){
    import('./ui/alunos/listaAlunoUi.js')
    import('./ui/alunos/deletarAlunoUi.js')
}

if (document.querySelector('.button-criar-aula')) {
    import('./ui/turmas/aulaUi.js')
}

if (document.querySelector('#nome-aluno')) {
    import('./ui/alunos/alunoUi.js')
}

if(document.querySelector(".toggle-closer") && document.querySelector(".toggle-closer-btn")){
    closer('.toggle-closer', '.toggle-closer-btn')

}

if(document.querySelector('.auto-dismiss')){
    autoDismiss('.auto-dismiss')
}

if(document.querySelector('#openModal')){
    import("./ui/componentes/modalAlunos/openCloseModal.js")
}

if(document.querySelector("#enviarAvulsa")){
    import('./ui/turmas/presencaAvulsaUi.js')
}

if(document.querySelector("#alunoAvulso")){
    import('./ui/turmas/listarTurmasAluno.js')
}

if(document.querySelector("#data-hoje")){
    import('./ui/componentes/home/timer.js')
}