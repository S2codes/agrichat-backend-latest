<?php
// Join group
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-with');


include "../auth.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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


        // echo  file_get_contents('php://input');
        $data = json_decode(file_get_contents('php://input'), true);

        $userId = $data['userid'];
        $groupsid = json_decode($data['groupsid'], true);
        $favoriteGroupsId = json_decode($data['favoriteGroupsId'], true);
  

        $sql_status = false;
        $already_in_group = false;
        $pin = 0;
        foreach ($groupsid as $key => $groupid) {

            if (in_array($groupid, $favoriteGroupsId)) {
                $pin = 1;
            } else {
                $pin = 0;
            }

            $check_sql = "SELECT * FROM `joinedgroups` WHERE userid = $userId AND groupid = $groupid";

            if (($DB->CountRows($check_sql)) > 0) {
                $already_in_group = true;
                // echo "present \n";
            } else {
                $sql = "INSERT INTO `joinedgroups` ( `userid`, `groupid`, `pin`, `selected`) VALUES ('$userId', '$groupid', '$pin', '1')";

                if ($DB->Query($sql)) {
                    $sql_status = true;
                }
            }
        }



        if ($sql_status) {
            echo json_encode(
                array(
                    'message' => 'Success! Joined Group',
                    'already in group' => $already_in_group,
                    'response' => true,
                    'status' => '200'
                )
            );
        } else {
            echo json_encode(
                array(
                    'message' => 'Already in Group',
                    'already in group' => $already_in_group,
                    'response' => false,
                    'status' => '400'
                )
            );
        }



    }
}
