const modal = document.getElementById('alunoModal');
const openBtn = document.getElementById('openModal');
const closeBtn = document.getElementById('closeModal');
const cancelBtn = document.getElementById('cancelModal');
const form = document.getElementById('alunoForm');

// Abrir modal
openBtn.addEventListener('click', () => modal.classList.add('is-active'));

// Fechar modal
const closeModal = () => {
    modal.classList.remove('is-active');
    form.reset();
};

closeBtn.addEventListener('click', closeModal);
cancelBtn.addEventListener('click', (e) => {
    e.preventDefault();
    closeModal();
});