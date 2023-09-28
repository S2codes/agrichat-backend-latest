<?php
    include "includes/config.php";
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ===== BOX ICONS ===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <!-- ===== CSS ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">

    <title>All Bussiness </title>
</head>

<body id="body-pd">
    <?php
        include "partials/sidebar.php";
    ?>

    <section class="componentContainer">
        <!-- <h1>Component</h1> -->
        <div class="navigation mb-3">
            <span class="rootMenu"><a href="#">Home</a> / </span><Span class="mainMenu"><a href="#">All Business</a></Span>
        </div>

        <div class="row">
            <div class="col">
                <h3 style="font-weight: 600;">All Business</h3>
            </div>
            <!-- <div class="col d-flex flex-row-reverse">
                <a href="category.php" class="btn btn-primary mr-2 ">Add New</a>
            </div> -->
           
           
        </div>
       
        <div class="dataContainer mt-3">
            <div class="row ">
                <div class="col-md-11 col-12 mx-auto">
                    <table class="table" id="myTable">
                       <thead>
                           <tr>
                               <th>#</th>
                               <th>Name</th>
                               <th>Company</th>
                               <th>State</th>
                               <th>District</th>
                               <th>Mobile</th>
                               <th>Email</th>
                               <th>Activity</th>
                               <th>Status</th>
                               <th>Action</th>
                           </tr>
                       </thead>
                        <tbody>

                           <?php

                           include "./controller/fetchLocation.php";

                           $sn = 1;
                            $q = "SELECT * FROM `business` ORDER BY `business`.`id` DESC";
                            $enquiries = $DB->RetriveArray($q);
                          
                            foreach ($enquiries as $enq) {
                                $status = "<button class='btn btn-success'>Active</button>";
                                if ($enq['status'] !== 'active') {
                                    $status = "<button class='btn btn-danger'>Blocked</button>";
                                }

                                echo '<tr>
                                <td>'.$sn.'</td>
                                <td>'.$enq['name'].'</td>
                                <td>'.$enq['company_name'].'</td>
                                <td>'.fetch_state($enq['state'], $DB).'</td>
                                <td>'.fetch_district($enq['district'], $DB).'</td>
                                <td>'.$enq['mobile'].'</td>
                                <td>'.$enq['email'].'</td>
                                <td>'.$enq['activity'].'</td>
                                <td>'.$status.'</td>
                                <td><a href="view-details?user='.$enq['id'].'&type=business" class="btn btn-info">View</a></td>
                                </tr>';
                                $sn = $sn +1;
                            }

                           ?>
                        </tbody>
                    </table>

                    
                    

                </div>
               
            </div>
        </div>
    </section >


  <?php
      include "partials/footer.php";
  ?>

    <!--===== MAIN JS =====-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
    <script src="assets/js/main.js"></script>
    
</body>

</html>