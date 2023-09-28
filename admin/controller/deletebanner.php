<?php
    
    include "../../db/conn.php";
    $DB = new Database();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $bannerid = $_POST['id'];
    
        $sql = "DELETE FROM `banner` WHERE `id` = '$bannerid'";
        if ($DB->Query($sql)) {
            echo json_encode(
                array(
                    "msg" => "success",
                    "response" => true
                )
            );
        }else {
            echo json_encode(
                array(
                    "msg" => "something error ocuured",
                    "response" => false
                )
            );
        }

    }


?>