const PresencaAPI = {
    marcar: async (alunoId, aulaId, turmaId, presente) => {
        const formData = new FormData();
        formData.append('aluno_id', alunoId);
        formData.append('aula_id', aulaId);
        formData.append('turma_id', turmaId)
        formData.append('presente', presente);
        console.log({'aluno_id': alunoId, 'aula_id': aulaId, 'turma_id': turmaId, 'presente': presente})
        console.log(formData)

        try {
            const response = await fetch('/projetos/chamada_digital/scripts/php/api/v1/presenca.php', {
                method: 'POST',
                body: formData
            });
            return await response.json();
        } catch (error) {
            console.error('Erro:', error);
            return { success: false };
        }
    }
};

export default PresencaAPI