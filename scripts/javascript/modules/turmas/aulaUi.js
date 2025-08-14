import AulaAPI from "../../api/criarAula.js";

const buttonCriarAula = document.querySelector('.button-criar-aula')

function init(){
    const turma = document.getElementById("turma-id").value
    const aulaCriada = carregarAulaCriadaLocal(turma)
    console.log(aulaCriada)

    if(aulaCriada){
        mostrarAulaCriadaUi(aulaCriada.dataFormatada)
    }
}

function formatarData(data){
    console.log(data)
    const [ano, mes, dia] = data.split('-')
    return `${dia}/${mes}/${ano}`
}

function salvarDataCriadaLocal(turmaId, data, aulaId){
    const dados = JSON.stringify({
        dataFormatada: formatarData(data),
        data,
        aulaId
    })

    localStorage.setItem(`aulaCriada_turma_${turmaId}`, dados)
}

function carregarAulaCriadaLocal(turmaId){
    const dados = localStorage.getItem(`aulaCriada_turma_${turmaId}`)

    if(!dados) return null

    try {
        const obj = JSON.parse(dados)

        /* compara as datas */
        const hoje = new Date().toISOString().slice(0, 10)
        if(obj.data === hoje) {
            return obj
        } else {
            localStorage.removeItem(`aulaCriada_turma_${turmaId}`)
            return null
        }
    } catch (error) {
            localStorage.removeItem(`aulaCriada_turma_${turmaId}`)
            return null
    }
}

function mostrarAulaCriadaUi(dataFormatada){
    const dataAulaTexto = document.getElementById('data-aula-atual')
        buttonCriarAula.style.display = "none"
        dataAulaTexto.style.display = "block"
        dataAulaTexto.innerText = `Aula do dia: ${dataFormatada}`
}

async function enviarDados(){
    const turma = document.getElementById("turma-id").value
    const horaInicio = document.getElementById("turma-hora-inicio").value
    const horaFim = document.getElementById("turma-hora-fim").value

    const result = await AulaAPI.criarAulaDoDia(turma, horaInicio, horaFim)

    console.log(result)

    if(result.success) {
        console.log(result.dados.data)
        const dadosResult = result.dados
        salvarDataCriadaLocal(turma, dadosResult.data, dadosResult.aula_id)
        mostrarAulaCriadaUi(formatarData(dadosResult.data))
    } else {
        alert("Erro ao criar aula!")
    }
    
    return result
}

if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init)
} else {
    init();
}

buttonCriarAula.addEventListener('click', enviarDados)