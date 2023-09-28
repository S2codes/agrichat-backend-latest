<?php
    
    include "../../db/conn.php";
    $DB = new Database();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $uid = $_POST['userid'];
        $userType = $_POST['type'];
        $status= $_POST['status'];
        $reason= $_POST['reason'];
        if ($status === 'active') {
            $reason = "";
        }


        $sql = "UPDATE `users` SET `status`='$status', `blockReason` = '$reason' WHERE id = '$uid'";
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