const AulaAPI = {
    criarAulaDoDia: async function (turmaId, horaInicio, horaFim) {
        const formData = new FormData();
        formData.append('turma_id', turmaId);
        formData.append('hora_inicio', horaInicio);
        formData.append('hora_fim', horaFim);

        try {
            const response = await fetch('/projetos/chamada_digital/scripts/php/api/v1/criar_aula.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return { success: false, error: response.statusText };
            }

            const data = await response.json();

            // Retorna padrão: { success: boolean, dados/error: object/string }
            return data;
        } catch (error) {
            console.error('Erro ao conectar com a API:', error);
            return { success: false, error: error.message };
        }
    }
};

export default AulaAPI;
