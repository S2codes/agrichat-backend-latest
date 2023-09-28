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
        $sql = "SELECT COLUMN_NAME
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = 'chatgroups'
        AND COLUMN_NAME NOT IN ('id', 'select_chat', 'pin_to_chat', 'fvrt')
        ";

        if ($DB->CountRows($sql) > 0) {
            $data = $DB->RetriveArray($sql);
            $values = array_column($data, 'COLUMN_NAME'); // Extract only the values

            echo json_encode(
                array(
                    'message' => 'Success',
                    'response' => true,
                    'status' => '200',
                    'data' => $values
                )
            );
        } else {
            echo json_encode(array('message' => 'No record Found',
            'response' => false,
             'status' => '401'));
        }
    }
}


?>