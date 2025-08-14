const AulaAPI = {
    criarAulaDoDia: async function (turmaId, horaInicio, horaFim){
        const formData = new FormData();
        formData.append('turma_id',turmaId)
        formData.append('hora_inicio',horaInicio)
        formData.append('hora_fim',horaFim)

        try {
            const response = await fetch('/projetos/chamada_digital/scripts/php/api/v1/criar_aula.php', {
                method: 'POST',
                body: formData}) 

                return await response.json();
        } catch (error) {
            console.log(error)
            return {'success': false}
        }
    }
}

export default AulaAPI