import AlunoAPI from '../../api/alunoApi.js';

const tabela = document.querySelector('.table');

tabela.addEventListener('click', async (e) => {
    const btn = e.target.closest('.delete-btn');
    if (!btn) return;

    const alunoId = btn.dataset.alunoId;
    console.log(alunoId)

    if (!confirm("Tem certeza que quer deletar este aluno?")) return;

    try {
        await AlunoAPI.deletarAluno(alunoId);
        // remove a linha
        const tr = btn.closest('tr');
        if (tr) tr.remove();
    } catch (err) {
        console.error(err);
        alert('Erro ao deletar aluno');
    }
});
