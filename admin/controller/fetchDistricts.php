<?php
    
    include "../../db/conn.php";
    $DB = new Database();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $state= $_POST['state_id'];

        $sql = "SELECT * FROM `districts` WHERE state_id = $state";
        $states = $DB->RetriveArray($sql);
        $state_list = array();
        if ($states > 0) {
            foreach ($states as $key => $s) {
                $state_item = array(
                    "district_id" => $s['id'],
                    "district" => $s['district'],
                );
                array_push($state_list, $state_item);
            }
            echo json_encode(
                array(
                    "msg" => "success",
                    "response" => true,
                    "data" => $state_list
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