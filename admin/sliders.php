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

    <title>Sliders | AgriChat </title>
</head>

<body id="body-pd">
    <?php
    include "partials/sidebar.php";

    $a="SELECT * FROM `banner` WHERE `bannerID` = 1";
    $bannerNo_1 = $DB->CountRows($a);
    
    $b="SELECT * FROM `banner` WHERE `bannerID` = 2";
    $bannerNo_2 = $DB->CountRows($b);

    ?>

    <section class="componentContainer">
        <!-- <h1>Component</h1> -->
        <div class="navigation mb-3">
            <span class="rootMenu"><a href="#">Home</a> / </span><Span class="mainMenu"><a href="#">All Sliders</a></Span>
        </div>

        <div class="row">
            <div class="col">
                <h3 style="font-weight: 600;">All Sliders</h3>
            </div>
            <!-- <div class="col d-flex flex-row-reverse">
                <button type="button" class="btn btn-primary mr-2" data-bs-toggle="modal" data-bs-target="#districtModal">
                    Add New District
                </button>
            </div> -->

        </div>

        <div class="dataContainer mt-3">
            <div class="row ">
                <div class="col-md-11 col-12 mx-auto">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Banner</th>
                                <th>No of Slider</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><a href="addBanner?id=1">Banner 1</a></td>
                                <td><?php echo $bannerNo_1; ?></td>
                                <td><a href="addBanner?id=1" class="btn btn-info">View</a></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><a href="addBanner?id=2">Banner 2</a></td>
                                <td><?php echo $bannerNo_2; ?></td>
                                <td><a href="addBanner?id=2" class="btn btn-info">View</a></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>

  

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