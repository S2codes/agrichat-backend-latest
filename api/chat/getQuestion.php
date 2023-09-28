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


        $groupid = $_GET['groupid'];
        $grouptype = $_GET['grouptype'];
        $state = $_GET['stateid'];

        $sql = "SELECT * FROM `questions` WHERE `groupid` = '$groupid' AND `type` = '$grouptype' AND `state` = '$state' ORDER BY `questions`.`id` DESC";

        $total_groups = $DB->CountRows($sql);
        if ($total_groups > 0) {
            $data = $DB->RetriveArray($sql);
            $arr = array();

            foreach ($data as $key => $item) {
                $userid = $item['userid'];
                $us = "SELECT * FROM `users` WHERE id = $userid";
                $userdetails = $DB->RetriveSingle($us);
                $userName = $userdetails['name'];
                $userType = $userdetails['type'];

                $qid = $item['id'];
                $rsql = "SELECT * FROM `reply` WHERE questionid = $qid";
                $NoOfReply = $DB->CountRows($rsql);

                $date = date_create($item['stamp']);
                $d = date_format($date, "d/m/Y H:i A");
                $a = array(
                    "id" => $item['id'],
                    "user" => $userName,
                    "userid" => $userid,
                    "usertype" => $userType,
                    "type" => $item['type'],
                    "groupid" => $item['groupid'],
                    "question" => $item['question'],
                    "attachment" => $item['attachment'],
                    "attachment_downloadlink" => readfile($item['attachment']),
                    "reply" => $NoOfReply,
                    "language" => $item['language'],
                    "state" => $item['state'],
                    "date" => $d,
                );

                array_push($arr, $a);
            }


            echo json_encode(
                array(
                    'message' => 'Success',
                    'response' => true,
                    'status' => '200',
                    'data' => $arr
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
