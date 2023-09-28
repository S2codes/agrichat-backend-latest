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

        $sql = "SELECT * FROM `users` WHERE id = $userid";

        $userDetails = $DB->RetriveSingle($sql);

        if ($userDetails) {
            
            $state = $userDetails['state'];
            $district = $userDetails['district'];
            $block = $userDetails['block'];

            $ss = "SELECT * FROM `state` WHERE id = $state";
            $stateData =   $DB->RetriveSingle($ss); 
            $stateName = $stateData['state'];
            
            $ds = "SELECT * FROM `districts`WHERE id = $district";
            $districtData =   $DB->RetriveSingle($ds); 
            $districtName = $districtData['district'];
            
            $bs = "SELECT * FROM `blocks` WHERE id = $block";
            $blockData =   $DB->RetriveSingle($bs); 
            $blockName = $blockData['block'];

            $arr = array(
                "id" => $userDetails['id'],
                "name" => $userDetails['name'],
                "type" => $userDetails['type'],
                "state" => $stateName,
                "stateid" => $state,
                "district" => $districtName,
                "districtid" => $district,
                "block" => $blockName,
                "blockid" => $block,
                "email" => $userDetails['email'],
                "mobile" => $userDetails['mobile'],
            );


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
