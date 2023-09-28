<?php
include "../db/conn.php";
$DB = new Database();

    session_start();
    if(!isset($_SESSION['admin'])){
        if (!$_SESSION['admin']) {
            header('location: sign-in.php');
        }
    }


?>