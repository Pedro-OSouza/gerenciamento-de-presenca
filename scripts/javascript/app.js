// Carrega módulos conforme a página
if (document.querySelector('.btn-presenca')) {
    import('./modules/turmas/presencaUi.js');
}

if (document.querySelector('.button-criar-aula')) {
    import('./modules/turmas/aulaUi.js')
}