const hoje = new Date().toISOString().slice(0, 10);

const salvarPresenca = (alunoId, presente) =>
    localStorage.setItem(`presenca_aluno_${alunoId}`, JSON.stringify({ presente, data: hoje }));

const carregarPresenca = (alunoId) => {
    const dados = localStorage.getItem(`presenca_aluno_${alunoId}`);
    if (!dados) return null;
    try {
        const { presente, data } = JSON.parse(dados);
        if (data === hoje) return presente;
        localStorage.removeItem(`presenca_aluno_${alunoId}`);
        return null;
    } catch {
        localStorage.removeItem(`presenca_aluno_${alunoId}`);
        return null;
    }
};

const atualizarBotao = (btn, estado) => {
    btn.classList.remove('is-light', 'is-success', 'is-danger');
    if (estado === "1") btn.classList.add('is-success'), btn.innerText = "✅ Presente";
    else if (estado === "0") btn.classList.add('is-danger'), btn.innerText = "❌ Ausente";
    else btn.classList.add('is-light'), btn.innerText = btn.dataset.presente === "1" ? "✅Presente" : "❌Ausente";
};

// Inicialização
document.querySelectorAll('.btn-presenca').forEach((btn) => {
    const alunoId = btn.dataset.alunoId;
    const container = btn.parentElement;
    const estadoSalvo = carregarPresenca(alunoId);

    // Reset de todos os botões da linha primeiro
    container.querySelectorAll('.btn-presenca').forEach(b => atualizarBotao(b, null));

    // Aplica estado salvo, se houver
    if (estadoSalvo !== null) {
        const btnAlvo = container.querySelector(`.btn-presenca[data-presente="${estadoSalvo}"]`);
        if (btnAlvo) atualizarBotao(btnAlvo, estadoSalvo);
    }

    // Listener de clique
    btn.addEventListener('click', () => {
        const presente = btn.dataset.presente;

        // Reset todos os botões da linha
        container.querySelectorAll('.btn-presenca').forEach(b => atualizarBotao(b, null));

        // Marca o clicado
        atualizarBotao(btn, presente);

        // Salva
        salvarPresenca(alunoId, presente);
    });
});
