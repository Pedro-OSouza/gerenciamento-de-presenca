<?php

function validarId_helper($id, $repositorio, $entidade = "entidade"){
    if (!$id) {
        throw new InvalidArgumentException("Id não informado");
    }

    $result = $repositorio->buscarPorId($id);

    if (!$result) {
        throw new InvalidArgumentException("$entidade inexistente");
    }

    return $result;
}

?>