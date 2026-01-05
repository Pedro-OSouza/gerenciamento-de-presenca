const AlunoAPI = {
    // Buscar um aluno por ID
    buscarAluno: async (id) => {
        try {
            const response = await fetch(`/projetos/chamada_digital/scripts/php/api/v1/aluno.php?id=${id}`, {
                method: 'GET'
            });

            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return { success: false, error: response.statusText };
            }

            return await response.json();
        } catch (error) {
            console.log('Erro', error);
            return { success: false, error: error.message };
        }
    },

    // Editar um aluno existente
    editarAluno: async (id, nome, email, turma, status) => {
        const payload = {
            alunoNome: nome,
            alunoEmail: email,
            alunoTurma: turma,
            alunoStatus: status,
            alunoId: id 
        };

        try {
            const response = await fetch(`/projetos/chamada_digital/scripts/php/api/v1/editar_aluno.php?id=${id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return { success: false, error: response.statusText };
            }

            return await response.json();
        } catch (error) {
            console.log("Erro", error);
            return { success: false, error: error.message };
        }
    },

    // Criar um novo aluno
    criarAluno: async (nome, email, turma, status) => {
        const payload = {
            nome,
            email,
            turma,
            status
        };

        try {
            const response = await fetch(`/projetos/chamada_digital/scripts/php/api/v1/aluno.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return { success: false, error: response.statusText };
            }

            return await response.json();
        } catch (error) {
            console.log("Erro", error);
            return { success: false, error: error.message };
        }
    },

    // Deletar aluno
    deletarAluno: async (id) => {
        try {
            const response = await fetch(`/projetos/chamada_digital/scripts/php/api/v1/deletar_aluno.php?id=${id}`, {
                method: 'DELETE'
            });

            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return { success: false, error: response.statusText };
            }

            return await response.json();
        } catch (error) {
            console.log("Erro", error);
            return { success: false, error: error.message };
        }
    },

    // Listar todos os alunos (opcional: de uma turma específica)
    listarAlunos: async (turmaId = null) => {
        const query = turmaId ? `?turma_id=${turmaId}` : '';
        try {
            const response = await fetch(`/projetos/chamada_digital/scripts/php/api/v1/aluno.php${query}`, {
                method: 'GET'
            });

            if (!response.ok) {
                console.error('Erro na requisição:', response.statusText);
                return { success: false, error: response.statusText };
            }

            return await response.json();
        } catch (error) {
            console.log("Erro", error);
            return { success: false, error: error.message };
        }
    },

    listarPorStatus: async (status) => {
        try {
            const response = await fetch(`/projetos/chamada_digital/public/api/v1/aluno/filter?status=${status}`, {
                method: 'GET'
            })

            if(!response.ok){
                console.error("Erro na requisição", response.statusText)
                return {success: false, error: response.statusText}
            }

            return await response.json();
        } catch (error) {
            console.log("Erro", error)
            return {success: false, error: error.message}
        }
    },

    listarTurmas: async (alunoId) => {
        try {
            const response = await fetch(`/projetos/chamada_digital/scripts/php/api/v1/turmas_aluno.php?aluno_id=${alunoId}`, {
                method: 'GET'
            })

            if (!response.ok){
                console.error("Erro na requisição", response.statusText)
                return {success: false, error: response.statusText}
            }

            return await response.json();
        } catch (error) {
            console.log("Erro", error)
            return {success: false, error: error.message}
        }
    }
};

export default AlunoAPI;