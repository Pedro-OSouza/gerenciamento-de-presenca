<?php

function validarHora_helper($hora_inicio, $hora_fim){
    $regExHora = '/^\d{2}:\d{2}(:\d{2})?$/';

    if (!$hora_inicio || !$hora_fim) {
        throw new InvalidArgumentException("Informe turma_id, hora_inicio, hora_fim");
    }
    // valida formato de hora (regex simplificado)
    if (
        !preg_match($regExHora, $hora_inicio) ||
        !preg_match($regExHora, $hora_fim)
    ) {
        throw new InvalidArgumentException("Formato de hora inválido. Use HH:MM ou HH:MM:SS.");
    }

    if ($hora_inicio >= $hora_fim) {
        throw new InvalidArgumentException("Hora de início deve ser menor do que hora de fim");
    }

    return true;
}

?>