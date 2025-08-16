import PresencaAPI from "../../api/presenca.js";

const buttons = document.querySelectorAll('.btn-presenca');

buttons.forEach(btn => {
    btn.addEventListener('click', async () => {
        const alunoId = btn.dataset.alunoId;
        const aulaId = document.getElementById('aula-id').value;
        const turmaId = document.getElementById('turma-id').value;
        const presente = parseInt(btn.dataset.presente, 10);

        const result = await PresencaAPI.marcar(alunoId, aulaId, turmaId, presente);

        if (result.status === 'success') {
            const presencaActionsContainer = btn.closest('.presenca-actions');
            const allButtonsForAluno = presencaActionsContainer.querySelectorAll('.btn-presenca');

            // Resetar todas
            allButtonsForAluno.forEach(otherBtn => {
                otherBtn.style.backgroundColor = '';
                otherBtn.classList.remove('is-success', 'is-danger');
                otherBtn.classList.add('is-light');
            });

            // Destacar o botão clicado
            if (presente === 1) {
                btn.style.backgroundColor = "#16C60C";
                btn.classList.remove('is-light');
            } else if (presente === 0) {
                btn.style.backgroundColor = "#F03A17";
                btn.classList.remove('is-light');
            }

            // Atualizar presenças e faltas
            const presencas = await PresencaAPI.buscarPresencas(alunoId);
            if (presencas.success) {
                const presencaData = presencas.data;
                const alunoContainer = btn.closest('.columns');

                if (alunoContainer) {
                    const presencasElement = alunoContainer.querySelector('.presencas-total');
                    const faltasElement = alunoContainer.querySelector('.faltas-total');

                    presencasElement.textContent = `Presenças: ${presencaData.presencas}`;
                    faltasElement.textContent = `Faltas: ${presencaData.faltas}`;
                }
            }
        }
    });
});
