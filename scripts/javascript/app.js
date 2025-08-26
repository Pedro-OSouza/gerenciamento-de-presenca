import autoDismiss from './modules/autoDismiss/autoDismiss.js';
import closer from './modules/closer/closer.js';

// Carrega módulos conforme a página
if (document.querySelector('.btn-presenca')) {
    import('./modules/turmas/presencaUi.js');
}

if (document.querySelector('.button-criar-aula')) {
    import('./modules/turmas/aulaUi.js')
}

if(document.querySelector(".toggle-closer") && document.querySelector(".toggle-closer-btn")){
    closer('.toggle-closer', '.toggle-closer-btn')

}

if(document.querySelector('.auto-dismiss')){
    autoDismiss('.auto-dismiss')
}

/* Todo: ADicionar o css com fade-out effect */