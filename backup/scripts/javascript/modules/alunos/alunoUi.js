import AlunoAPI from '../../api/alunoApi.js'

const nomeInpt = document.querySelector("#nome-aluno"),
    emailInpt = document.querySelector('#email-aluno'),
    turmaInpt = document.querySelector("#turma-aluno"),
    statusInpt = document.querySelector('#status-aluno'),
    salvarBtn = document.querySelector("#salvar-mudancas-aluno"),
    descartarBtn = document.querySelector('#descartar-mudancas-aluno'),
    inpts = document.querySelectorAll(".inpt"),
    selects = document.querySelectorAll(".select")

let valoresIniciais = null;

// Armazena valores iniciais para comparações
function armazenarValoresIni(alunoDados){
    valoresIniciais = {
        nome: alunoDados.nome,
        email: alunoDados.email,
        turma: alunoDados.turma_id,
        status: alunoDados.status
    };
}

// Preenche inputs com dados do aluno
async function preencherDados(id) {
    const aluno = await AlunoAPI.buscarAluno(id),
        alunoDados = aluno.result;

    if (!aluno.success || !alunoDados) return;

    nomeInpt.value = alunoDados.nome || '';
    emailInpt.value = alunoDados.email || '';
    turmaInpt.value = alunoDados.turma_id || '';
    statusInpt.value = alunoDados.status || '';

    armazenarValoresIni(alunoDados);
}

// Pega ID do aluno da URL
function getId(){
    const URLParams = new URLSearchParams(window.location.search);
    return URLParams.get("id");
}

// Inicialização
function init () {
    const id = getId();
    if(id) preencherDados(id);
}

// Habilita/desabilita botão
function enableBtn(btn){ btn.disabled = false; }
function disableBtn(btn){ btn.disabled = true; }

// Verifica se input mudou
function isInptChanged(input, name){
    return input.value !== valoresIniciais[name];
}

function inptChanged(input, name){
    const changed = isInptChanged(input, name);
    changed ? (enableBtn(salvarBtn), enableBtn(descartarBtn)) : (disableBtn(salvarBtn), disableBtn(descartarBtn));
}

// Chama API pra editar aluno
async function editarAluno() {
    const id = getId(),
        nome = nomeInpt.value,
        email = emailInpt.value,
        turma = turmaInpt.value,
        status = statusInpt.value;

    if (!Object.keys(valoresIniciais).some(key => valoresIniciais[key] !== eval(key))) return;

    try {
        const result = await AlunoAPI.editarAluno(id, nome, email, turma, status);
        console.log(result);
        if(result.success){
            // Atualiza valores iniciais
            armazenarValoresIni({nome, email, turma_id: turma, status});
            disableBtn(salvarBtn);
            disableBtn(descartarBtn);
            alert('Aluno atualizado com sucesso!');
        } else {
            alert('Erro ao atualizar: ' + (result.error || ''));
        }
    } catch(e){
        console.error(e);
        alert('Erro inesperado.');
    }
}

// Descarta alterações
function descartarMudancas(){
    nomeInpt.value = valoresIniciais.nome;
    emailInpt.value = valoresIniciais.email;
    turmaInpt.value = valoresIniciais.turma;
    statusInpt.value = valoresIniciais.status;
    disableBtn(salvarBtn);
    disableBtn(descartarBtn);
}

// Eventos
if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

salvarBtn.addEventListener('click', editarAluno);
descartarBtn.addEventListener('click', descartarMudancas);

inpts.forEach((inpt)=>{
    inpt.addEventListener('input', () => { inptChanged(inpt, inpt.name); });
});

selects.forEach((select) => {
    select.addEventListener('change', () => { inptChanged(select, select.name); });
});