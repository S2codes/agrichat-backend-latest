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


        $messageId = $_POST['messageid'];

        $sql = "DELETE FROM `message` WHERE `id` = $messageId";

        if ($DB->Query($sql)) {
            
            echo json_encode(
                array(
                    'message' => 'Success! message is deleted',
                    'response' => true,
                    'status' => '200'
                )
            );
        } else {
            echo json_encode(
                array(
                    'message' => 'Error ! Something went wrong',
                    'response' => false,
                    'status' => '400'
                )
            );
        }


    }
}
