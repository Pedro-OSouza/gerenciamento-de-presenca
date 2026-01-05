const AulaAPI = {
    // Criar uma nova aula
    criarAulaDoDia: async function (id, horaInicio, horaFim) {
        

        try {
            const response = await fetch(`/projetos/chamada_digital/public/api/v1/aula/criar?id=${id}&horaInicio=${horaInicio}&horaFim=${horaFim    }`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
            });

            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return { success: false, error: response.statusText };
            }

            const data = await response.json();
            return data; // { success: true/false, dados/error }
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            return { success: false, error: error.message };
        }
    },

    // Editar uma aula existente
    editarAula: async function (aulaId, turmaId, horaInicio, horaFim) {
        const payload = { turma_id: turmaId, hora_inicio: horaInicio, hora_fim: horaFim };

        try {
            const response = await fetch(`/projetos/chamada_digital/scripts/php/api/v1/aulas.php?id=${aulaId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return { success: false, error: response.statusText };
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            return { success: false, error: error.message };
        }
    },

    // Deletar uma aula
    deletarAula: async function (aulaId) {
        try {
            const response = await fetch(`/projetos/chamada_digital/scripts/php/api/v1/aulas.php?id=${aulaId}`, {
                method: 'DELETE'
            });

            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return { success: false, error: response.statusText };
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            return { success: false, error: error.message };
        }
    },

    // Listar todas as aulas de uma turma
    listarAulas: async function (turmaId) {
        try {
            const response = await fetch(`/projetos/chamada_digital/scripts/php/api/v1/aulas.php?turma_id=${turmaId}`);

            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return { success: false, error: response.statusText };
            }

            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            return { success: false, error: error.message };
        }
    }
};

export default AulaAPI;