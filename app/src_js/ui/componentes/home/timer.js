const dataEl = document.querySelector("#data-hoje");
const diaEl = document.querySelector("#dia-semana");
const horaEl = document.querySelector("#hora-atual");

function atualizarData() {
    const hoje = new Date();
    const dia = String(hoje.getDate()).padStart(2, "0");
    const mes = String(hoje.getMonth() + 1).padStart(2, "0"); // meses começam em 0
    const ano = hoje.getFullYear();

    dataEl.textContent = `${dia}/${mes}/${ano}`;
}

function atualizarDiaSemana() {
    const hoje = new Date();
    const dias = [
        "Domingo",
        "Segunda-feira",
        "Terça-feira",
        "Quarta-feira",
        "Quinta-feira",
        "Sexta-feira",
        "Sábado"
    ];
    diaEl.textContent = dias[hoje.getDay()];
}

function atualizarHora() {
    const agora = new Date();
    const horas = String(agora.getHours()).padStart(2, "0");
    const minutos = String(agora.getMinutes()).padStart(2, "0");

    horaEl.textContent = `${horas}:${minutos}`;
}

// Chama uma vez ao carregar
atualizarData();
atualizarDiaSemana();
atualizarHora();

// Atualiza a hora a cada minuto
setInterval(atualizarHora, 60000);
