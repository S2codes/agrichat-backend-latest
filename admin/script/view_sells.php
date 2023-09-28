<?php
    
    // include "includes/db.php";
    $DAO = new Database();
    $q = "SELECT * FROM `allsells` ORDER BY `allsells`.`id` DESC";
    $data = $DAO->RetriveArray($q);
    $sn = 1;
    foreach ($data as $d) {
        $status = '';
        if ($d['paymentStatus'] == 'success') {
            $status = '<span class="bg-success text-light p-2">Success</span>';
        }else{
            $status = '<span class="bg-danger text-light p-2">Pending</span>';
        }
        echo ' <tr>
        <td>'.$sn.'</td>
        <td>'.$d['purchesid'].'</td>
        <td>'.$d['courseid'].'</td>
        <td>'.$d['userName'].'</td>
        <td>'.$d['coursePrice'].'</td>
        <td>'.$d['cuponCode'].'</td>
        <td>'.$d['discount'].'</td>
        <td>'.$d['grandPrice'].'</td>
        <td>'.$d['paymentId'].'</td>
        <td>'.$status.'</td>
        <td>'.$d['date'].'</td>
        </tr>';
        $sn += 1;

    }



?>