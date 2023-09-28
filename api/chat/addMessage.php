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


        $userId = $_POST['userid'];
        $userType = $_POST['usertype'];
        $groupData = $_POST['sender'];
        $msg = $_POST['msg'];
        $language = $_POST['language'];
        $state = $_POST['state'];


        $isFarmer = 0;
        $isServiceProvider = 0;
        $isExpert = 0;
        $isStartup = 0;
        $isManufacturer = 0;
        $isStudent = 0;

        $group = explode(",", $groupData);

        if (in_array("farmer", $group, true)){
            $isFarmer = 1;
            
        }
        if (in_array("expert", $group, true)){
            $isExpert = 1;
        }
        if (in_array("service provider", $group, true)){
            $isServiceProvider = 1;
        }
        if (in_array("manufacturer / dealer", $group, true)){
            $isManufacturer = 1;
        }
        if (in_array("startup / entrepreneur", $group, true)){
            $isStartup = 1;
        }
        if (in_array("student", $group, true)){
            $isStudent = 1;
        }

        

        $attachment_name = "";
        $extension = "none";
        

        if (isset($_FILES['file'])) {
            $file_name = $_FILES['file']['name'];
            $file_type = $_FILES['file']['type'];
            $file_tmp = $_FILES['file']['tmp_name'];

            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $source = "";

            if ($file_type == 'image/jpeg') {
                $source = imagecreatefromjpeg($file_tmp);
            }
            if ($file_type == 'image/png') {
                $source = imagecreatefrompng($file_tmp);
            }
            if ($file_type == 'image/gif') {
                $source = imagecreatefromgif($file_tmp);
            }
            if ($file_type == 'image/webp') {
                $source = imagecreatefromwebp($file_tmp);
            }


            if ($source != '') {
                list($width, $height) = getimagesize($file_tmp);
                $newImage = imagecreatetruecolor($width, $height);
                imagecopyresized($newImage, $source, 0, 0, 0, 0, $width, $height, $width, $height);

                $attachment_name = time() . "-" . date('dmYHis') . ".jpg";
                $path = "../../attachments/" . $attachment_name;
                imagejpeg($newImage, $path, 10);
            } else {
                $attachment_name = time() . "-" . date('dmYHis') . "." . $extension;
                move_uploaded_file($file_tmp, "../../attachments/" . $attachment_name);
            }

            if ($file_name == '' || !isset($file_name)) {
                $attachment_name = "";
            }


        }

        $attachmentFile =  array(
            "type" => $extension,
            "attachment" => "https://odishakrushi.in/agrichatapp/attachments/".$attachment_name
        );
        $attachmentFile = json_encode($attachmentFile);

        $sql ="INSERT INTO `message` (`userid`, `usertype`, `msg`, `attachment`, `state`, `language`, `farmer`, `expert`, `serviceProvider`, `startup`, `manufacturer`, `student`) VALUES ( '$userId', '$userType', '$msg', '$attachmentFile', '$state', '$language',  '$isFarmer', '$isExpert', '$isServiceProvider', '$isStartup', '$isManufacturer', '$isStudent')";


        if ($DB->Query($sql)) {

            echo json_encode(
                array(
                    'message' => 'Success! Question submitted',
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
