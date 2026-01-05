<?php
    function validarEmail_helper($email, $nullable = false){
        if ($nullable && !$email){
            return null;
        }
        
        if(!$email) {
            throw new InvalidArgumentException("Email não informado");
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new InvalidArgumentException("Email inválido");
        }

        return $email;
    }
?>