<?php
include "includes/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $state = $_POST['state'];
    $q = "INSERT INTO `state`(`state`) VALUES ('$state')";
    $DB->Query($q);
}

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

    <title>User Data | AgriChat </title>
</head>

<body id="body-pd">
    <?php
    include "partials/sidebar.php";
    ?>

    <section class="componentContainer">
        <!-- <h1>Component</h1> -->
        <div class="navigation mb-3">
            <span class="rootMenu"><a href="#">Home</a> / </span><Span class="mainMenu"><a href="#">User Data</a></Span>
        </div>

        <!-- <div class="row">
            <div class="col">
                <h3 style="font-weight: 600;">User Data</h3>
            </div>
            <div class="col d-flex flex-row-reverse">
                <button class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#stateModal">Add New State</button>
            </div>
        </div> -->

        <div class="dataContainer mt-3">
            <div class="row ">
                <div class="col-md-12 col-12 mx-auto">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>Sn</th>
                                <th>State / UT</th>
                                <th>Farmer</th>
                                <th>Expert</th>
                                <th>Manufacturer/Dealer</th>
                                <th>Service provider</th>
                                <th>Startup/ Entrepreneur</th>
                                <th>Student</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $sn = 1;
                            $q = "SELECT * FROM `state`";
                            $enquiries = $DB->RetriveArray($q);

                            foreach ($enquiries as $enq) {

                                $Fsql = "SELECT * FROM `users` WHERE `state` = '".$enq['id']."' AND `type` = 'farmer'";
                                $farmerInState = $DB->CountRows($Fsql);
                                $Esql = "SELECT * FROM `users` WHERE `state` = '".$enq['id']."' AND `type` = 'expert'";
                                $expertInState = $DB->CountRows($Esql);
                                $MDsql = "SELECT * FROM `users` WHERE `state` = '".$enq['id']."' AND `type` = 'manufacturer / dealer'";
                                $manFuDealerInState = $DB->CountRows($MDsql);
                                $SPsql = "SELECT * FROM `users` WHERE `state` = '".$enq['id']."' AND `type` = 'service provider'";
                                $serviceProviderInState = $DB->CountRows($SPsql);
                                $SEsql = "SELECT * FROM `users` WHERE `state` = '".$enq['id']."' AND `type` = 'startup / entrepreneur'";
                                $startupInState = $DB->CountRows($SEsql);
                                $Ssql = "SELECT * FROM `users` WHERE `state` = '".$enq['id']."' AND `type` = 'student'";
                                $studentInState = $DB->CountRows($SEsql);

                                echo '<tr>
                                <td>' . $sn . '</td>
                                <td>' . $enq['state'] . '</td>
                                <td>' . $farmerInState . '</td>
                                <td>' . $expertInState . '</td>
                                <td>' . $manFuDealerInState . '</td>
                                <td>' . $serviceProviderInState . '</td>
                                <td>' . $startupInState . '</td>
                                <td>' . $studentInState . '</td>
                                <td>' . ($farmerInState+ $expertInState + $manFuDealerInState + $serviceProviderInState+ $startupInState + $studentInState) . '</td>
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


    <!-- Modal -->
    <div class="modal fade" id="stateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="states.php" method="post">
                    <div class="modal-body">
                        <label class="form-label" for="">State</label>
                        <input type="text" name="state" class="form-control" placeholder="Enter State Name">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php
    include "partials/footer.php";
    ?>

    <!-- Button trigger modal -->



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