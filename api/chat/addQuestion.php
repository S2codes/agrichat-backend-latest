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
        $mtype = $_POST['messagetype'];
        $groupId = $_POST['groupid'];
        $question = $_POST['question'];
        // $attacthment = $_POST['attacthment'];
        $language = $_POST['language'];
        $state = $_POST['state'];

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

                $attachment_name = time() . "-" . date('dmYHis') . "img.jpg";
                $path = "../../attachments/" . $attachment_name;
                imagejpeg($newImage, $path, 10);
            } else {
                $extension = "pdf";
                $attachment_name = time() . "pdf-" . date('dmYHis') . "." . $extension;
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

        $question = $extension;

        $sql = "INSERT INTO `questions` ( `userid`, `type`, `groupid`, `question`, `attachment`, `language`, `state`) VALUES ('$userId', '$mtype', '$groupId', '$question', '$attachmentFile', '$language', '$state')";

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
