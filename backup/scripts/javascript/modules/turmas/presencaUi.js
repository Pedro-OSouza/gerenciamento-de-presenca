import PresencaAPI from "../../api/presencaApi.js";

const buttons = document.querySelectorAll('.btn-presenca');

buttons.forEach(btn => {
    btn.addEventListener('click', async () => {
        const alunoId = btn.dataset.alunoId;
        const aulaId = document.getElementById('aula-id').value;
        const turmaId = document.getElementById('turma-id').value;
        const presente = Number(btn.dataset.presente);

        if (![0, 1].includes(presente)) return;

        
        const result = await PresencaAPI.marcar(alunoId, aulaId, turmaId, "normal", presente);
        const presencas = await PresencaAPI.buscarPresencas(alunoId);
        console.table(presencas)

        if (result.status === 'success') {
            const presencaActionsContainer = btn.closest('.presenca-actions');
            if (!presencaActionsContainer) return;

            const allButtonsForAluno = presencaActionsContainer.querySelectorAll('.btn-presenca');

            // Resetar todos os botões
            allButtonsForAluno.forEach(otherBtn => {
                otherBtn.classList.remove('is-success', 'is-danger');
                otherBtn.classList.add('is-light');
            });

        }
        
        // Atualizar presenças e falta    
        /* if (presencas.success && presencas.data) {
            const alunoContainer = btn.closest('.columns');
            if (!alunoContainer) return;

            const presencasElement = alunoContainer.querySelector('.presencas-total');
            const faltasElement = alunoContainer.querySelector('.faltas-total');

            if (presencasElement) presencasElement.textContent = `Presenças: ${presencas.data.presencas}`;
            if (faltasElement) faltasElement.textContent = `Faltas: ${presencas.data.faltas}`;
        } */
    });
});
