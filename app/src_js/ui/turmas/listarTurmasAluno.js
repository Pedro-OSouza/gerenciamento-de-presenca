import AlunoAPI from '../../api/alunoApi.js'
const idAlunoAvulso = document.querySelector("#alunoAvulso")
const turmasSelectEl = document.querySelector("#turmaAluno")

const listaTurmasAluno = async (id) => {
    const response =  await AlunoAPI.buscarAluno(id)
    return response.result
}

idAlunoAvulso.addEventListener('change', async () => {
    const lista = await listaTurmasAluno(idAlunoAvulso.value)
    const turmaId = lista.turma_id
    const turmaNome = lista.turma_nome

    turmasSelectEl.add(new Option(`${turmaNome}`, `${turmaId}`))
    turmasSelectEl.value = turmaId
})