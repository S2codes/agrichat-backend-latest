<?php
// fetch all districts  
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

include "../auth.php";

// fetch group details 
function fetch_group_details($groupId, $DB, $language)
{
    $qry = "SELECT * FROM `chatgroups` WHERE id = $groupId";

    $g = $DB->RetriveSingle($qry);
    // if ($lang != "") {
    // $langCategory = explode(', ', $g['Hindi']);
    $langCategory = explode(', ', $g[$language]);
    $GROUP_CATEGORY = count($langCategory) > 1 ?  $langCategory[0] :  $g['groupCategory'];

    $GROUP_NAME = count($langCategory) > 1 ?  $langCategory[1] :  $g['groupName'];
    // }

    return array(
        "id" => $g['id'],
        "defaultGroupCategory" => $g['groupCategory'],
        "groupCategory" => $GROUP_CATEGORY,
        "groupName" => $GROUP_NAME,
    );
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // api authentication 
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

        // get parameters 
        $userid = $_GET['user_id'];
        $lang = isset($_GET['lang'])? $_GET['lang']: 'English';

        if (!isset($userid) || $userid == '') {
            echo json_encode(
                array(
                    'message' => 'Invalid User',
                    'response' => false,
                    'status' => '400'
                )
            );
        }

        $s = "SELECT * FROM `joinedgroups` WHERE userid = '$userid' AND `selected` = 1";
        $userjoinedGroups = $DB->RetriveArray($s);

        $pinnedGroup = array();
        $selectedGroup = array();

        $pinnedGroupId = array();
        $selectedGroupId = array();

        foreach ($userjoinedGroups as $key => $group) {
            array_push($selectedGroupId, $group['groupid']);

            if ($group['pin'] != "0" || $group['pin'] == "1") {
                $g = fetch_group_details($group['groupid'], $DB, $lang);
                array_push($pinnedGroup, $g);
                array_push($pinnedGroupId, $group['groupid']);
            } else {
                $g = fetch_group_details($group['groupid'], $DB, $lang);
                array_push($selectedGroup, $g);
            }
        }


        echo json_encode(
            array(
                'message' => 'Success',
                'response' => true,
                'status' => '200',
                "selectedGroups" => $selectedGroup,
                "selectedGroupsId" => $selectedGroupId,
                "pinnedGroups" => $pinnedGroup,
                "pinnedGroupsId" => $pinnedGroupId
            )
        );
    }
}
