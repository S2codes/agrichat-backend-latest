<?php
// fetch all districts  
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

include "../auth.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET['api_key'])) {
        echo json_encode(
            array(
                'message' => 'Invalid api key',
                'response' => false,
                'status' => '401'
            )
        );
        exit();
    }

    if ($api_auth != $_GET['api_key']) {
        echo json_encode(
            array(
                'message' => 'Invalid api key',
                'response' => false,
                'status' => '401'
            )
        );
        exit();
    } else {


        $questionid = $_GET['questionid'];
        $sql = "SELECT * FROM `reply` WHERE questionid = $questionid";

        $total_groups = $DB->CountRows($sql);
        if ($total_groups > 0) {
            $replyDetails = $DB->RetriveSingle($sql);

            foreach ($replyDetails as $key => $item) {


                $userid = $replyDetails['userid'];
                $us = "SELECT * FROM `users` WHERE id = $userid";
                $userdetails = $DB->RetriveSingle($us);
                $userName = $userdetails['name'];
                $userType = $userdetails['type'];

                $date = date_create($item['stamp']);
                $d = date_format($date, "d/m/Y H:i A");

                $questionArr = array(
                    "id" => $replyDetails['id'],
                    "questionid" => $userDetails['questionid'],
                    "user" => $userName,
                    "userid" => $userid,
                    "usertype" => $userType,
                    "reply" => $questionDetails['reply'],
                    "attachment" => json_decode($questionDetails['attachment'], true),
                    "state" =>  $questionDetails['state'],
                    "type" => $questionDetails['type'],
                    "date" => $d,
                );
                
            }


            echo json_encode(
                array(
                    'message' => 'Success',
                    'response' => true,
                    'status' => '200',
                    'question' => $questionArr,
                    'replies' => []
                )
            );
        } else {
            echo json_encode(array(
                'message' => 'No record Found',
                'response' => false,
                'status' => '401'
            ));
        }
    }
}
