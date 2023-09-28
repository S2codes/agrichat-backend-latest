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


        $userid = $_GET['userid'];
        $sql = "SELECT * FROM `message` WHERE userid = $userid";

        $total_groups = $DB->CountRows($sql);
        if ($total_groups > 0) {
            $MessageDetails = $DB->RetriveSingle($sql);

            $us = "SELECT * FROM `users` WHERE id = $userid";
            $userdetails = $DB->RetriveSingle($us);
            $userName = $userdetails['name'];
            $userType = $userdetails['type'];
            
            $msgArray = array();

            foreach ($MessageDetails as $key => $item) {
                
                $date = date_create($item['stamp']);
                $d = date_format($date, "d/m/Y H:i A");

                $a = array(
                    "id" => $item['id'],
                    "user" => $userName,
                    "userid" => $userid,
                    "usertype" => $userType,
                    "message" => $item['msg'],
                    "attachment" => json_decode($item['attachment'], true),
                    "state" =>  $item['state'],
                    "language" =>  $item['language'],
                    "sendto" => array(
                        "farmer" => $item['farmer'],
                        "expert" => $item['expert'],
                        "student" => $item['student'],
                        "serviceProvider" => $item['serviceProvider'],
                        "startup" => $item['startup'],
                        "manufacturer" => $item['manufacturer']
                    ),
                    "date" => $d,
                );

                array_push($msgArray, $a);

            }

            echo json_encode(
                array(
                    'message' => 'Success',
                    'response' => true,
                    'status' => '200',
                    'messages' => $msgArray,
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
