const AlunoAPI = {
    buscarAluno: async (id) => {
        const formData = new FormData()
        formData.append("id", id)
        
            try {
                const response = await fetch('/projetos/chamada_digital/scripts/php/api/v1/aluno.php', {
                    method: 'POST',
                    body: formData
                })

                return await response.json()
            } catch (error) {
                console.log('Erro', error)
                return {success: false}
            }
    },
    editarAluno: async (nome, email, turma, status, id) => {
        const formData = new FormData()
        formData.append("alunoNome", nome)
        formData.append("alunoEmail", email)
        formData.append("alunoTurma", turma)
        formData.append("alunoStatus", status)
        formData.append("alunoId", id)

        try {
            const response = await fetch('/projetos/chamada_digital/scripts/php/api/v1/editar_aluno.php', {
                method: 'POST',
                body: formData
            })

            return await response.json()
        } catch (error) {
            console.log("Erro", error)            
            return {success: false}
        }
    }
}

export default AlunoAPI