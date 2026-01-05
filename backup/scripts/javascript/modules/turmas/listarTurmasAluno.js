import AlunoAPI from '../../api/alunoApi.js'
const idAlunoAvulso = document.querySelector("#alunoAvulso")
const turmasSelectEl = document.querySelector("#turmaAluno")

const listaTurmasAluno = async (id) => {
    return await AlunoAPI.listarTurmas(id)
}

idAlunoAvulso.addEventListener('change', async () => {
    const lista = await listaTurmasAluno(idAlunoAvulso.value)
    const turmaId = lista[0].turma_id
    const turmaNome = lista[0].turma_nome

    turmasSelectEl.add(new Option(`${turmaNome}`, `${turmaId}`))
    turmasSelectEl.value = turmaId
})