import AulaAPI from "../../api/aulaAPI.js";

const buttonCriarAula = document.querySelector('.button-criar-aula'),
    dataAulaTexto = document.getElementById('data-aula-atual'),
    turma = document.getElementById("turma-id").value,
    horaInicio = document.getElementById("turma-hora-inicio").value,
    horaFim = document.getElementById("turma-hora-fim").value;

async function init() {
    const turma = document.getElementById("turma-id").value;
    const aulaCriada = carregarAulaCriadaLocal(turma);
    if(aulaCriada) mostrarAulaCriadaUi(aulaCriada.dataFormatada);
    const aulaIdInput = document.querySelector('#aula-id')
    const dadosApi = await conectaApi(turma, horaInicio, horaFim)
    aulaIdInput.value = dadosApi.result.aula_id
}

function formatarData(data){
    console.log(data)
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

async function conectaApi(turma, horaInicio, horaFim) {
    try {
        const result = await AulaAPI.criarAulaDoDia(turma, horaInicio, horaFim);
        return result
    } catch (error) {
        console.log(error)
    }

}

async function enviarDados(){


    const result = await conectaApi(turma, horaInicio, horaFim);
    
    document.querySelector('#aula-id').value = result.result.aula_id

    if(result.success) {
        const dadosResult = result.result;
        /* aqui data corresponde a data retornada no resultado. então dadosResult.data é a data que o backend retorna */
        salvarDataCriadaLocal(turma, dadosResult.date, dadosResult.aula_id);
        mostrarAulaCriadaUi(formatarData(dadosResult.date));
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
