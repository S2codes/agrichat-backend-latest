<?php
include "includes/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $district = $_POST['district'];
    $state_id = $_POST['state'];
    $qry = "INSERT INTO `districts`(`district`, `state_id`) VALUES ('$district','$state_id')";
    $DB->Query($qry);
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

    <title>All Districts </title>
</head>

<body id="body-pd">
    <?php
    include "partials/sidebar.php";
    ?>

    <section class="componentContainer">
        <!-- <h1>Component</h1> -->
        <div class="navigation mb-3">
            <span class="rootMenu"><a href="#">Home</a> / </span><Span class="mainMenu"><a href="#">All Districts</a></Span>
        </div>

        <div class="row">
            <div class="col">
                <h3 style="font-weight: 600;">All Districts</h3>
            </div>
            <div class="col d-flex flex-row-reverse">
                <button type="button" class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#districtModal">
                    Add New District
                </button>
            </div>


        </div>

        <div class="dataContainer mt-3">
            <div class="row ">
                <div class="col-md-11 col-12 mx-auto">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>District Id</th>
                                <th>District Name</th>
                                <th>State</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            include "./controller/fetchLocation.php";

                            $sn = 1;
                            $q = "SELECT * FROM `districts` ORDER BY `districts`.`id` DESC";
                            $enquiries = $DB->RetriveArray($q);

                            foreach ($enquiries as $enq) {
                                // $status = "<button class='btn btn-success'>Active</button>";
                                // if ($enq['status'] !== 'active') {
                                //     $status = "<button class='btn btn-danger'>Blocked</button>";
                                // }

                                // <td>'.fetch_district($enq['district'], $DB).'</td>
                                // <td>'.fetch_block($enq['block'], $DB).'</td>
                                // <td>'.$enq['standard'].'</td>
                                // <td>'.$enq['district'].'</td>
                                // <td>'.$status.'</td>

                                echo '<tr>
                                <td>' . $enq['id'] . '</td>
                                <td>' . $enq['district'] . '</td>
                                <td>' . fetch_state($enq['state_id'], $DB) . '</td>
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
    <div class="modal fade" id="districtModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add District</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <label class="form-label" for="">State</label>
                        <select name="state" required id="" class="form-select mb-2">
                            <option value="">Select State</option>
                            <?php
                                $sql = "SELECT * FROM `state`";
                                $states = $DB->RetriveArray($sql);
                                foreach ($states as $key => $state) {
                                    echo '<option value="'.$state['id'].'">'.$state['state'].'</option>';
                                }
                            ?>
                        </select>
                        <label class="form-label" for="">District</label>
                        <input type="text" name="district" class="form-control" placeholder="Enter District Name">

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