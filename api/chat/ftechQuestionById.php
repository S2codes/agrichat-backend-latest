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


        $questionid = $_GET['querry'];
        $sql = "SELECT * FROM `questions` WHERE id = $questionid";

        $total_groups = $DB->CountRows($sql);
        if ($total_groups > 0) {
            $questionDetails = $DB->RetriveSingle($sql);

            $userid = $questionDetails['userid'];
            $us = "SELECT * FROM `users` WHERE id = $userid";
            $userdetails = $DB->RetriveSingle($us);
            $userName = $userdetails['name'];
            $userType = $userdetails['type'];

            $date = date_create($item['stamp']);
            $d = date_format($date, "d/m/Y H:i A");

            $questionArr = array(
                "id" => $questionDetails['id'],
                "group" => $userDetails['groupid'],
                "user" => $userName,
                "userid" => $userid,
                "usertype" => $userType,
                "question" => $questionDetails['question'],
                "attachment" => json_decode($questionDetails['attachment'], true),
                "state" =>  $questionDetails['state'],
                "type" => $questionDetails['type'],
                "date" => $d,
            );

            $qsql = "SELECT * FROM `reply` WHERE questionid = '$questionid' ORDER BY `reply`.`id` DESC";
            $replyDetails = $DB->RetriveArray($qsql);
            $replyArr = array();

            foreach ($replyDetails as $key => $item) {
                $ruserid = $item['userid'];
                $rus = "SELECT * FROM `users` WHERE id = $ruserid";
                $ruserdetails = $DB->RetriveSingle($rus);
                $ruserName = $ruserdetails['name'];
                $ruserType = $ruserdetails['type'];

                $date = date_create($item['stamp']);
                $d = date_format($date, "d/m/Y H:i A");
                $a = array(
                    "id" => $item['id'],
                    "user" => $ruserName,
                    "userid" => $ruserid,
                    "usertype" => $ruserType,
                    "type" => $item['type'],
                    "reply" => $item['reply'],
                    "attachment" => json_decode($item['attachment'], true),
                    "language" => $item['language'],
                    "state" => $item['state'],
                    "date" => $d,
                );

                array_push($replyArr, $a);
            }


            echo json_encode(
                array(
                    'message' => 'Success',
                    'response' => true,
                    'status' => '200',
                    'question' => $questionArr,
                    'replies' => $replyArr
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
