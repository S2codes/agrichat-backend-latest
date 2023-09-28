<?php
include "includes/config.php";

// if (isset($_GET['remove']) && $_GET['remove'] != '') {
//     $id = $_GET['remove'];
//     $qry = "DELETE FROM `translation` WHERE id = $id";
//     if ($DB->Query($qry)) {
//         header("location: .././admin/translation");
//     }else{
//         echo '<script>alert("Something error occurred")</script>';
//     }
// }
// ?>

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

    <title>Chat Groups | AgriChat</title>
</head>

<body id="body-pd">
    <?php
    include "partials/sidebar.php";
    ?>

    <section class="componentContainer">

        <!-- <h1>Component</h1> -->
        <div class="navigation mb-3">
            <span class="rootMenu"><a href="#">Home</a> / </span><Span class="mainMenu"><a href="#">All Chat Groups</a></Span>
        </div>

        <div class="row">
            <div class="col">
                <h3 style="font-weight: 600;">All Chat Groups</h3>
            </div>
            
            <div class="col d-flex flex-row-reverse">
                <a href="group-translation?status=new" class="btn btn-primary mr-4">Add New</a>
            </div>


        </div>

        <div class="dataContainer mt-3">
            <div class="row ">
                <div class="col-md-12 col-12 mx-auto">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>Sn No</th>
                                <th>Category</th>
                                <th>Group</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                             <?php
                                $sn = 1;
                                $q = "SELECT * FROM `chatgroups`";
                                $enquiries = $DB->RetriveArray($q);

                                foreach ($enquiries as $enq) {

                                    echo '<tr>
                                    <td>'. $sn . '</td>
                                    <td>'. $enq['groupCategory'] .'</td>
                                    <td>'. $enq['groupName'] .'</td>
                                    <td><a href="group-translation?id='.$enq['id'].'&status=update" class="btn btn-info">Update</a></td>
                                    </tr>';
                                    $sn = $sn + 1;
                                }

                            ?> 

                        </tbody>
                    </table>


                </div>

            </div>
        </div>


    </section>




    <?php
    include "partials/footer.php";
    ?>


    <!--===== MAIN JS =====-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <script src="assets/js/main.js"></script>

</body>

</html>