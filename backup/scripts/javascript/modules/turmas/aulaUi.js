import AulaAPI from "../../api/aulaAPI.js";

const buttonCriarAula = document.querySelector('.button-criar-aula'),
    dataAulaTexto = document.getElementById('data-aula-atual');

function init() {
    const turma = document.getElementById("turma-id").value;
    const aulaCriada = carregarAulaCriadaLocal(turma);
    if(aulaCriada) mostrarAulaCriadaUi(aulaCriada.dataFormatada);
}

function formatarData(data){
    const [ano, mes, dia] = data.split('-');
    return `${dia}/${mes}/${ano}`;
}

function salvarDataCriadaLocal(turmaId, data, aulaId){
    const dados = JSON.stringify({
        dataFormatada: formatarData(data),
        data,
        aulaId
    });
    localStorage.setItem(`aulaCriada_turma_${turmaId}`, dados);
}

function carregarAulaCriadaLocal(turmaId){
    const dados = localStorage.getItem(`aulaCriada_turma_${turmaId}`);
    if(!dados) return null;

    try {
        const obj = JSON.parse(dados);
        const hoje = (() => {
            const d = new Date();
            const ano = d.getFullYear();
            const mes = String(d.getMonth() + 1).padStart(2, '0'); // mês de 0–11
            const dia = String(d.getDate()).padStart(2, '0');
            return `${ano}-${mes}-${dia}`;
        })();
        if(obj.data === hoje) return obj;
        localStorage.removeItem(`aulaCriada_turma_${turmaId}`);
        return null;
    } catch (error) {
        localStorage.removeItem(`aulaCriada_turma_${turmaId}`);
        return null;
    }
}

function mostrarAulaCriadaUi(dataFormatada){
    buttonCriarAula.style.display = "none";
    dataAulaTexto.style.display = "block";
    dataAulaTexto.innerText = `Aula do dia: ${dataFormatada}`;
}

async function enviarDados(){
    const turma = document.getElementById("turma-id").value,
        horaInicio = document.getElementById("turma-hora-inicio").value,
        horaFim = document.getElementById("turma-hora-fim").value;

    const result = await AulaAPI.criarAulaDoDia(turma, horaInicio, horaFim);
    console.log(result)

    if(result.success) {
        const dadosResult = result.dados;
        salvarDataCriadaLocal(turma, dadosResult.data, dadosResult.aula_id);
        mostrarAulaCriadaUi(formatarData(dadosResult.data));
    } else {
        alert("Erro ao criar aula! " + (result.error || ""));
    }
    
    return result;
}

if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}

buttonCriarAula.addEventListener('click', enviarDados);
