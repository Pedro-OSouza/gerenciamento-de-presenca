<?php

    /* usado para validar nome em formulários */
    function validarTexto_helper($texto, $campo = "texto"): string{
        if (!$texto) {
            throw new InvalidArgumentException("$campo não informado");
        }

        if(!is_string($texto)) {
            throw new InvalidArgumentException("O $campo deve ser string");
        }

        return trim($texto);
    }
?>