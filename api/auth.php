<?php
    include "../../db/conn.php";
    $DB = new Database();
    $sql = "SELECT * FROM `api_auth` WHERE status = 'active'";
    $api_auth_data = $DB->RetriveSingle($sql);
    $api_auth = $api_auth_data['auth_token'];
?>