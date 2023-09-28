<?php
include "includes/config.php";

if (isset($_GET['remove']) && $_GET['remove'] != '') {
    $id = $_GET['remove'];
    $qry = "DELETE FROM `translation` WHERE id = $id";
    if ($DB->Query($qry)) {
        header("location: .././admin/translation");
    }else{
        echo '<script>alert("Something error occurred")</script>';
    }
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

    <title>Label Translation</title>
</head>

<body id="body-pd">
    <?php
    include "partials/sidebar.php";
    ?>

    <section class="componentContainer">

        <!-- <h1>Component</h1> -->
        <div class="navigation mb-3">
            <span class="rootMenu"><a href="#">Home</a> / </span><Span class="mainMenu"><a href="#">Label Translation</a></Span>
        </div>

        <div class="row">
            <div class="col">
                <h3 style="font-weight: 600;">Label Translation</h3>
            </div>
            
            <div class="col d-flex flex-row-reverse">
                <a href="addTranslation?status=new" class="btn btn-primary mr-4">Add New</a>
            </div>

        </div>

        <div class="dataContainer mt-3">
            <div class="row ">
                <div class="col-md-12 col-12 mx-auto" style="overflow-x: scroll;">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Engilsh</th>
                                <th>Hindi</th>
                                <th>Assamese,Bodo</th>
                                <th>Bengali</th>
                                <th>Gujarati</th>
                                <th>Kannada</th>
                                <th>Khasi,Garo</th>
                                <th>Konkani</th>
                                <th>Konyak, Ao, Sema</th>
                                <th>Lushai/ Mizo</th>
                                <th>Malayalam</th>
                                <th>Manipuri</th>
                                <th>Marathi</th>
                                <th>Nepali</th>
                                <th>Nissi/Dafla,Adi</th>
                                <th>Odia</th>
                                <th>Punjabi</th>
                                <th>Shimla</th>
                                <th>Tamil</th>
                                <th>Telugu</th>
                                <th>Update</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                                $sn = 1;
                                $q = "SELECT * FROM `translation`";
                                $enquiries = $DB->RetriveArray($q);

                                foreach ($enquiries as $enq) {

                                    echo '<tr>
                                    <td>'. $sn . '</td>
                                    <td>'. $enq['English'] .'</td>
                                    <td>'. $enq['Hindi'] .'</td>
                                    <td>'. $enq['Assamese'] .'</td>
                                    <td>'. $enq['Bengali'] .'</td>
                                    <td>'. $enq['Gujarati'] .'</td>
                                    <td>'. $enq['Kannada'] .'</td>
                                    <td>'. $enq['Khasi'] .'</td>
                                    <td>'. $enq['Konkani'] .'</td>
                                    <td>'. $enq['Konyak'] .'</td>
                                    <td>'. $enq['Lushai'] .'</td>
                                    <td>'. $enq['Malayalam'] .'</td>
                                    <td>'. $enq['Manipuri'] .'</td>
                                    <td>'. $enq['Marathi'] .'</td>
                                    <td>'. $enq['Nepali'] .'</td>
                                    <td>'. $enq['Nissi'] .'</td>
                                    <td>'. $enq['Odia'] .'</td>
                                    <td>'. $enq['Punjabi'] .'</td>
                                    <td>'. $enq['Shimla'] .'</td>
                                    <td>'. $enq['Tamil'] .'</td>
                                    <td>'. $enq['Telugu'] .'</td>
                                    <td><a href="addTranslation?id='.$enq['id'].'&status=update" class="btn btn-warning">Update</a></td>
                                    <td><a href="translation?remove='.$enq['id'].'" class="btn btn-danger">Delete</a></td>
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