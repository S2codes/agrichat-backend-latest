<?php
// fetch all blocks
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-with');

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
        $isSuccess = false;
        $bannerid = (int)$_GET['bannerid'];
        $userState = (int)$_GET['state'];

        $data = array();

        // $sql = "SELECT * FROM `banner` WHERE `bannerID` = '$bannerid' AND (`state` = '$userState' OR `state` = 0)";
        $sql = "SELECT * FROM `banner` WHERE `bannerID` = '$bannerid' ";

        if ($DB->CountRows($sql) > 0) {
            $data = $DB->RetriveArray($sql);
            $isSuccess = true;

            $bannerArr = array();
            $currentDateTime =  date('Y-m-d H:i');

            foreach ($data as $key => $value) {

                if ($value['state'] == $userState ||  $value['state'] == 0) {


                    // $currentDateTime = date('d-m-Y: h:i A');

                    // $startDate = date('d-m-Y: h:i A', strtotime($value['start']));

                    // $endDate = date('d-m-Y: h:i A', strtotime($value['end']));

                    // Check if the current date is within the valid range
                    // if ($currentDateTime >= $startDate && $currentDateTime <= $endDate) {

                    // $s = date_create($value['start']);
                    // $start = date_format($s, 'Y-m-d H:i');

                    // $e = date_create($value['end']);
                    // $end = date_format($e, 'Y-m-d H:i');


                    if ($currentDateTime  >= $value['start']) {
                        if ($currentDateTime <= $value['end']) {

                            $a = array(
                                "id" =>  $value['id'],
                                "img" => "https://odishakrushi.in/agrichatapp/slider/" . $value['img'],
                                "link" => $value['link']
                            );
                            array_push($bannerArr, $a);


                        }
                    }


                }
            }

            echo json_encode(
                array(
                    'message' => 'Success',
                    'response' => true,
                    'status' => '200',
                    'data' => $bannerArr,
                    "d" => $data
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
