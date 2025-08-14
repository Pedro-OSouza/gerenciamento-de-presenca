import PresencaAPI from "../../api/presenca.js"

const buttons = document.querySelectorAll('.btn-presenca');

buttons.forEach(btn => {
    btn.addEventListener('click', async () => {
        const alunoId = btn.dataset.alunoId;
        const aulaId = document.getElementById('aula-id').value;
        const turmaId = document.getElementById('turma-id').value
        const presente = btn.dataset.presente;

        const result = await PresencaAPI.marcar(alunoId, aulaId, turmaId, presente);

        if (result.success) {
            // Feedback visual
            btn.closest('.presenca-actions')
                .querySelectorAll('.button')
                .forEach(b => b.classList.remove('is-success', 'is-danger'));

            btn.classList.add(presente === '1' ? 'is-success' : 'is-danger');
        }
    });
});
