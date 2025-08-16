const PresencaAPI = {
    marcar: async (alunoId, aulaId, turmaId, presente) => {
        const formData = new FormData();
        formData.append('aluno_id', alunoId);
        formData.append('aula_id', aulaId);
        formData.append('turma_id', turmaId)
        formData.append('presente', presente);

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
    },
    buscarPresencas: async(alunoId) => {
        const formData = new FormData()
        formData.append('aluno_id', alunoId)

        try{
            const response = await fetch('/projetos/chamada_digital/scripts/php/api/v1/presencas_acumuladas.php', {
                method: 'POST',
                body: formData
            })

            if(!response.ok){
                throw new Error(`Erro na rede: ${response.statusText}`)
            }

            return response.json()
        } catch (error) {
            console.log('Error', error)
            return {success: false, error: error.message}
        }
    }
};

export default PresencaAPI