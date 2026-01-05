const PresencaAPI = {
    // Marcar presença ou falta de um aluno em uma aula
    marcar: async (alunoId, aulaId, turmaId, tipo, presente) => {
        const payload = {
            aluno_id: alunoId,
            aula_id: aulaId,
            turma_id: turmaId,
            tipo: tipo || "normal",
            presente: presente ? 1 : 0
        };

        try {
            const response = await fetch('/projetos/chamada_digital/scripts/php/api/v1/presenca.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                throw new Error(`Erro na rede: ${response.statusText}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Erro:', error);
            return { success: false, error: error.message };
        }
    },

    // Buscar presenças/faltas acumuladas de um aluno
    buscarPresencas: async (alunoId) => {

        try {
            const response = await fetch(`/projetos/chamada_digital/scripts/php/api/v1/presencas_acumuladas.php?aluno_id=${alunoId}`, {
                method: 'GET',
            });

            if (!response.ok) {
                throw new Error(`Erro na rede: ${response.statusText}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Erro:', error);
            return { success: false, error: error.message };
        }
    }
};

export default PresencaAPI;