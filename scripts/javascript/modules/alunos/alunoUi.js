import AlunoAPI from './../../api/fetchAluno.js'

const nomeInpt = document.querySelector("#nome-aluno"),
    emailInpt = document.querySelector('#email-aluno'),
    turmaInpt = document.querySelector("#turma-aluno"),
    statusInpt = document.querySelector('#status-aluno'),
    salvarBtn = document.querySelector("#salvar-mudancas-aluno"),
    descartarBtn = document.querySelector('#descartar-mudancas-aluno'),
    inpts = document.querySelectorAll(".inpt"),
    selects = document.querySelectorAll(".select")

    let valoresIniciais = null;

function armazenarValoresIni(alunoDados){
    /* valores armazenados uma única vez */
    valoresIniciais = {
        nome: alunoDados.nome,
        email: alunoDados.email,
        turma: alunoDados.turma_nome,
        status: alunoDados.status
    };
}

async function preencherDados(id) {
    const aluno = await AlunoAPI.buscarAluno(id),
    alunoDados = aluno.result

    nomeInpt.value = alunoDados.nome
    emailInpt.value = alunoDados.email
    turmaInpt.value = alunoDados.turma_id
    statusInpt.value = alunoDados.status

    armazenarValoresIni(alunoDados)
}

function getId(){
    const searchString = window.location.search
    const URLParams = new URLSearchParams(searchString)
    const id = URLParams.get("id")

    return id
}

function init () {
    const id = getId()
    preencherDados(id)
}

function enableBtn(btn){
    btn.disabled = false
}

function disableBtn(btn){
    btn.disabled = true
}

function isInptChanged(input, name){
    const inputValue = input.value

    return inputValue !== valoresIniciais[name] 
}

function inptChanged(input, name){
    const changed = isInptChanged(input, name);
    changed ? (enableBtn(salvarBtn), enableBtn(descartarBtn)) : (disableBtn(salvarBtn), disableBtn(descartarBtn));
}

async function editarAluno() {
    if(isInptChanged){
        const id = getId(),
        nome = nomeInpt.value,
        email = emailInpt.value,
        turma = turmaInpt.value,
        status = statusInpt.value

        console.log(nome, email, turma, status, id)

        const result = await AlunoAPI.editarAluno(nome, email, turma, status, id)

        console.log(result)
    }
}

function descartarMudancas(){
    nomeInpt.value = valoresIniciais.nome
    emailInpt.value = valoresIniciais.email
    turmaInpt.value = valoresIniciais.turma
    statusInpt.value = valoresIniciais.status
}


if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init)
    console.log('evento adicionado')
} else {
    init();
    console.log('evento disparado')
}

salvarBtn.addEventListener('click', editarAluno)
descartarBtn.addEventListener('click', descartarMudancas)

inpts.forEach((inpt)=>{
    inpt.addEventListener('input', () => {
        inptChanged(inpt, inpt.name)
    })
})

selects.forEach((select) => {
    select.addEventListener('change', () => {
        inptChanged(select, select.name)
        console.log("evento")
    })
})