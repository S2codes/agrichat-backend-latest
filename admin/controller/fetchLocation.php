<?php

    // fetch state name by sate id 
    function fetch_state($id, $DB){
        $sql_state = "SELECT `state` FROM `state` WHERE id = '$id'";
        $state = $DB->RetriveSingle($sql_state);
        return  $state['state'];

    }
    // fetch District name by District id 
    function fetch_district($id, $DB){
        $sql_state = "SELECT `district` FROM `districts` WHERE id = '$id'";
        $state = $DB->RetriveSingle($sql_state);
        return  $state['district'];

    }

    // fetch Block name by block id 
    function fetch_block($id, $DB){
        $sql_state = "SELECT `block` FROM `blocks` WHERE id = '$id'";
        $state = $DB->RetriveSingle($sql_state);
        return $state['block'];

    }

?>