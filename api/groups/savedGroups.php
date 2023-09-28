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
        $limit = 3;
        $offset = ($page - 1) * $limit;
        $USERID = $_GET['userid'];


        $sql = "SELECT DISTINCT groupCategory FROM chatgroups LIMIT $offset, 3";
        $total_groups = $DB->CountRows($sql);

        if ($total_groups > 0) {
            $data = $DB->RetriveArray($sql);
            $all_group = array();
            $group = array();
            $selectedGroups = array();
            $pinnedGroups = array();

            foreach ($data as $key => $grp) {

                $groupCategory = $grp['groupCategory'];
                $sqlb = "SELECT * FROM `chatgroups` WHERE groupCategory ='$groupCategory' ";
                $groupName = $DB->RetriveArray($sqlb);

                $selected = 0;
                $pinned = 0;

                foreach ($groupName as $key => $g) {

                    $Group_id = $g['id'];
                    $asql = "SELECT * FROM `joinedgroups` WHERE `groupid` = '$Group_id' AND  `userid` = '$USERID'";

                    if ($DB->CountRows($asql) > 0) {
                        $JoinedGroups = $DB->RetriveSingle($asql);
                        $selected = $JoinedGroups['selected'];
                        $pinned = $JoinedGroups['pin'];
                        if ($selected != 0) {
                            array_push($selectedGroups, $JoinedGroups['groupid']);
                        }
                        if ($pinned != 0) {
                            array_push($pinnedGroups, $JoinedGroups['groupid']);
                        }
                    }

                    $arr = array(
                        "groupId" => $g['id'],
                        "groupName" => $g['groupName'],
                        "selected" => $selected,
                        "pinned" => $pinned
                    );
                    array_push($group, $arr);
                    $selected = 0;
                    $pinned = 0;
                }

                $newArr = array(
                    "groupCategory" => $groupCategory,
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
                    'data' => $all_group,
                    "selectedGroup" => $selectedGroups,
                    "pinnedGroup" => $pinnedGroups,

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
