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


        $questionId = $_POST['questionid'];

        $sql = "DELETE FROM `questions` WHERE id = $questionId";

        if ($DB->Query($sql)) {

            $ds = "DELETE FROM `reply` WHERE `questionid` = $questionId";
            $DB->Query($ds);

            echo json_encode(
                array(
                    'message' => 'Success! Question is deleted',
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
