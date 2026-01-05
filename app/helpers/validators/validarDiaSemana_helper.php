<?php
    function validarDiaSemana_helper($dia){
        $diasValidos = ['Segunda','Terça','Quarta','Quinta','Sexta','Sábado'];

        if(!in_array($dia, $diasValidos, true)) {
            throw new InvalidArgumentException("Dia da semana inválido");
        }

        return $dia;
    }
?>