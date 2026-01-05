<?php 
    function getIdInput_helper(){
        return filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    }