<?php
    
    include "../../db/conn.php";
    $DB = new Database();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $bannerid = $_POST['id'];
    
        $sql = "SELECT * FROM `banner` WHERE `id` = '$bannerid'";
        $data = $DB->RetriveSingle($sql);
        if ($DB->CountRows($sql) > 0) {
            echo json_encode(
                array(
                    "msg" => "success",
                    "response" => true,
                    "data" => $data
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