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
    $name = $data['name'];
    $state = $data['state'];
    $district = $data['district'];
    $block = $data['block'];
    $mobile = $data['mobile'];
    $email = $data['email'];
    $password = $data['password'];
    $type = $data['userType'];

    $validation_sql_by_email = "SELECT * FROM `users` WHERE `email` = '$email'";
    
    if ($type == 'farmer') {
      $validation_sql_by_email = "SELECT * FROM `users` WHERE `mobile` = '$mobile'";
    }

    //   return if user's mobile number already exits 
    if ($DB->CountRows($validation_sql_by_email) > 0) {
      echo json_encode(
        array(
          'message' => "User already exits",
          "exits" => true,
          'response' => false,
          'status' => '401'
        )
      );
      return;
    }

    $token = bin2hex(random_bytes(10));
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $str =  substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 5);
    $str = $str . date('his');
    $token = bin2hex(base64_encode($str));

    $sql = "INSERT INTO `users`(`name`, `state`, `district`, `block`, `mobile`, `email`, `password`, `type`, `status`, `token`) VALUES ('$name','$state','$district','$block','$mobile','$email', '$hash', '$type', 'active', '$token')";

    if ($DB->Query($sql)) {

      $s = "SELECT * FROM `users` WHERE `email` = '$email'";

      if ($type == 'farmer') {
        $s = "SELECT * FROM `users` WHERE `mobile` = '$mobile'";
      }

      $data = $DB->RetriveArray($s);
      echo json_encode(
        array(
          'message' => 'Registered Successfuly',
          "exits" => false,
          'response' => true,
          'status' => '200',
          'data' => $data
        )
      );
      return;
    } else {
      echo json_encode(
        array(
          'message' => 'Error! Query Failed',
          'response' => false,
          'status' => '500'
        )
      );
      return;
    }
  }
}
