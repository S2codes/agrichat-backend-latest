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


        
        $stateid = $_GET['stateid'];
        $userid = $_GET['userid'];
        
        $msgCatgory = "";
        switch ($_GET['type']) {
            case 'farmer':
                $msgCatgory= "farmer";
                break;
            case 'expert':
                $msgCatgory= "expert";
                break;
            case 'student':
                $msgCatgory= "student";
                break;
            case 'manufacturer / dealer':
                $msgCatgory= "manufacturer";
                break;
            case 'startup / entrepreneur':
                $msgCatgory= "startup";
                break;
            case 'service provider':
                $msgCatgory= "serviceProvider";
                break;
        }

        $sql = "SELECT * FROM `message` where `$msgCatgory` = 1 AND `state` = '$stateid' AND userid != '$userid'";
        


        $total_groups = $DB->CountRows($sql);
        if ($total_groups > 0) {
            $MessageDetails = $DB->RetriveArray($sql);

            $msgArray = array();

            foreach ($MessageDetails as $key => $item) {

                $userid = $item['userid'];

                $us = "SELECT * FROM `users` WHERE id = $userid";
                $userdetails = $DB->RetriveSingle($us);
                $userName = $userdetails['name'];
                $userType = $userdetails['type'];

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
                'status' => '401',
                'parameters' => array(
                    "userid" => $userid,
                    "stateid" => $stateid,
                    "msgCatg" => $msgCatgory
                )
            ));
        }
    }
}
