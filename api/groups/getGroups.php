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

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $lang = "Hindi";
        $limit = 3;
        $offset = ($page - 1) * $limit;

        $sql = "SELECT DISTINCT groupCategory FROM chatgroups LIMIT $offset, 3";

        $total_groups = $DB->CountRows($sql);

        global $GROUP_CATEGORY;

        if ($total_groups > 0) {
            $data = $DB->RetriveArray($sql);
            $all_group = array();
            $group = array();

            foreach ($data as $key => $grp) {
                
                $groupCategory = $grp['groupCategory'];
                $sqlb = "SELECT * FROM `chatgroups` WHERE groupCategory ='$groupCategory' LIMIT 5";
                $groupName = $DB->RetriveArray($sqlb);
                
                foreach ($groupName as $key => $g) {
                    if ($lang != "") {
                        $langCategory = explode(', ', $g['Hindi']);
                        $GROUP_CATEGORY = count($langCategory) > 1 ?  $langCategory[0] :  $g['groupCategory'];
                        
                        $GROUP_NAME = count($langCategory) > 1 ?  $langCategory[1] :  $g['groupName'];
                    }


                    $arr = array(
                        "group_id" => $g['id'],
                        "groupName" => $GROUP_NAME,
                    );
                    array_push($group, $arr);
                }
                

                $newArr = array(
                    "groupCategoryDefalt" => $groupCategory,
                    "groupCategory" => $GROUP_CATEGORY,
                    "groupData" => $group
                );

                $group = array();

                array_push($all_group, $newArr);
            }


            echo json_encode(
                array(
                    'message' => 'Success',
                    'response' => true,
                    'status' => '200',
                    'data' => $all_group

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
