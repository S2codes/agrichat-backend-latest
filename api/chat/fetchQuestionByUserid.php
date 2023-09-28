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
        $lang = isset($_GET['lang'])? $_GET['lang']: 'English';
        
        $sql = "SELECT * FROM `questions` WHERE userid = $userid";

        $total_groups = $DB->CountRows($sql);
        if ($total_groups > 0) {
            $data = $DB->RetriveArray($sql);
            $arr = array();

            $us = "SELECT * FROM `users` WHERE userid = $userid";
            // echo $DB->CountRows()
            $userdetails = $DB->RetriveSingle($us);
            print_r($userdetails);
            $userName = $userdetails['name'];
            $userType = $userdetails['type'];

            foreach ($data as $key => $item) {

                $groupid = $item['groupid'];

                if ($item['type'] == 'chat') {

                    $gs = "SELECT * FROM `chatgroups` WHERE id = $groupid";
                    $groupData = $DB->RetriveSingle($gs);

                    $langCategory = explode(', ', $groupData[$lang]);
                    $GROUP_CATEGORY = count($langCategory) > 1 ?  $langCategory[0] :  $groupData['groupCategory'];
                    $GROUP_NAME = count($langCategory) > 1 ?  $langCategory[1] :  $groupData['groupName'];

                    $groupName = $GROUP_NAME;
                    $groupCategory = $GROUP_CATEGORY;
                    // $groupName = $groupData['groupName'];
                    $defaultgroupCategory = $groupData['groupCategory'];

                } elseif ($item['type'] == 'state') {
                    $ss = "SELECT * FROM `state` WHERE id = $groupid";
                    $groupData = $DB->RetriveSingle($ss);
                    $groupName = $groupData['state'];
                    $groupCategory = "My State";
                    $defaultgroupCategory='';
                } elseif ($item['type'] == 'district') {
                    $ds = "SELECT * FROM `districts` WHERE id = $groupid";
                    $groupData = $DB->RetriveSingle($ds);
                    $groupName =  $groupData['district'];
                    $groupCategory = 'My District';
                    $defaultgroupCategory='';
                } elseif ($item['type'] == 'block') {
                    $bs = "SELECT * FROM `blocks` WHERE id = $groupid";
                    $groupData = $DB->RetriveSingle($bs);
                    $groupName = $groupData['block'];
                    $groupCategory = 'My Block';
                } elseif ($item['type'] == 'support') {
                    $groupName = "Agrichat Help";
                    $groupCategory = 'Support';
                    $defaultgroupCategory='';
                } else {
                    $groupName = "My Group" . $item['type'];
                    $groupCategory = 'Support';
                    $defaultgroupCategory='';
                }

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
                    "groupname" => $groupName,
                    "groupcategory" => $groupCategory,
                    "defaultgroupCategory" => $defaultgroupCategory,
                    "question" => $item['question'],
                    "attachment" => $item['attachment'],
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
