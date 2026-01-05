import AlunoAPI from '../../api/alunoApi.js'
const tabelaAlunos = document.querySelector("#tabela-lista-alunos");
const filtroSelect = document.querySelector("#filtro-status");
const btnFiltrar = document.querySelector("#btn-filtrar");

async function carregarAlunos(status = 'todos') {
    const alunos = await AlunoAPI.listarPorStatus(status);
    if(alunos) renderizarTabela(alunos.result);
}

function renderizarTabela(alunos) {
    tabelaAlunos.innerHTML = '';
    if(!alunos || !Array.isArray(alunos)) return
    alunos.forEach(aluno => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
        <td>${aluno.aluno_id}</td>
        <td>${aluno.aluno_nome}</td>
        <td>${aluno.turma_nome}</td>
        <td class="has-text-centered" style="white-space: nowrap; width: 1%;">
            <a class="button is-small is-info is-light" href="http://localhost/projetos/chamada_digital/public/aluno/${aluno.aluno_id}">Editar</a>
            <a class="button is-small is-danger is-light delete-btn" data-aluno-id=${aluno.aluno_id}>Remover</a>
        </td>
    `;
        tabelaAlunos.appendChild(tr);
    });
}

btnFiltrar.addEventListener('click', () => {
    const status = filtroSelect.value;
    carregarAlunos(status);
});

carregarAlunos();
