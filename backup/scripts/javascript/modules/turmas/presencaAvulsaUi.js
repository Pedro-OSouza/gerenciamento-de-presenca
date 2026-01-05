import PresencaAPI from "../../api/presencaApi.js";
import '../modalAlunos/openCloseModal.js'

const btn  = document.querySelector("#enviarAvulsa")

btn.addEventListener("click", async () => {
    const idAlunoAvulso = document.querySelector("#alunoAvulso").value
    const tipoAlunoAvulso = document.querySelector("#tipoAvulso").value
    const aulaId = document.querySelector('#aula-id').value;
    const turmaId = document.querySelector('#turmaAluno').value;
    const presente = 1;

    if (idAlunoAvulso && tipoAlunoAvulso && aulaId && turmaId){
        const result = await PresencaAPI.marcar(idAlunoAvulso, aulaId, turmaId, tipoAlunoAvulso, presente)
        closeModal()
        return result
    }
})