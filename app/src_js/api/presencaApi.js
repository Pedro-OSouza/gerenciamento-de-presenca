const PresencaAPI = {
    // Marcar presença ou falta de um aluno em uma aula
    marcar: async (alunoId, aulaId, turmaId, tipo, presente) => {
        try {
            const response = await fetch(`/projetos/chamada_digital/public/api/v1/presenca/marcar?idAluno=${alunoId}&idAula=${aulaId}&idTurma=${turmaId}&presenca=${presente}&tipo=${tipo}`, {
                method: 'PUT',
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
            const response = await fetch(`/projetos/chamada_digital/public/api/v1/presenca/historico?id=${alunoId}`, {
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