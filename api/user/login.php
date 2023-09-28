<?php
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
        
        $data = json_decode(file_get_contents('php://input'), true);
        $usertype = $data['type'];
        $email = $data['email'];
        $user_password = $data['password'];


            $sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `type` = '$usertype'";
            if ($usertype == 'farmer') {
                $sql = "SELECT * FROM `users` WHERE `mobile` = '$email' AND `type` = 'farmer'";
            }


            if ($DB->CountRows($sql) > 0) {
                $userData = $DB->RetriveSingle($sql);
                $password_verify = password_verify($user_password, $userData['password']);
                if ($password_verify) {
                    $userId = $userData['id'];
                    $q = "SELECT * FROM `users`  WHERE id = $userId";
                    if ($DB->Query($q)) {
                        $userData = $DB->RetriveSingle($sql);
                        echo json_encode(
                            array(
                                'message' => "Validate Success",
                                'response' => true,
                                'status' => '200',
                                "data" => [
                                    'id' => $userData['id'],
                                    'name' => $userData['name'],
                                    'user_type' => 'student',
                                    'state' => $userData['state'],
                                    'district' => $userData['district'],
                                    'block' => $userData['block'],
                                    'mobile' => $userData['mobile'],
                                    'email' => $userData['email'],
                                    'status' => $userData['status'],
                                    'userType' => $userData['type']
                                ]
                            )
                        );
                    } else {
                        echo json_encode(
                            array(
                                'message' => "Query Failed",
                                'response' => false,
                                'status' => '500'
                            )
                        );
                    }
                } else {
                    // if password not matched 
                    echo json_encode(
                        array(
                            'message' => "Invalid credentials",
                            'response' => false,
                            'status' => '401'
                        )
                    );
                }
            }
            
            else {
                // if mobile number not found 
                echo json_encode(
                    array(
                        'message' => "Invalid Credentials",
                        'response' => false,
                        'status' => '401'
                    )
                );
                return;
            }


        }
       

    
}


?>