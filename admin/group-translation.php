<?php
include "includes/config.php";

// if (!isset($_GET['id']) || !isset($_GET['status']) ) {
//     if (empty($_GET['id']) || empty($_GET['status'])) {
//         header("location: .././admin/chatgroups");
//     }
//     header("location: .././admin/chatgroups");
// }


function convertToString($DB, $LanguagesArray)
{
    $escapedLanguages = array_map([$DB, 'real_escape_string'], $LanguagesArray);
    $joinedLanguages = implode(', ', $escapedLanguages);
    return $joinedLanguages;
}

$exits = false;
if ($_GET['status'] == "update") {
    $groupId = $_GET['id'];
    $sql = "SELECT * FROM `chatgroups` WHERE id = '$groupId'";
    if ($DB->CountRows($sql) > 0) {
        $GROUP = $DB->RetriveSingle($sql);
        // echo "<pre>";
        // print_r($GROUP);
        // echo "</pre>";
        // $a = $GROUP['Hindi'];
        // echo $a[0];
        $exits = true;
    }
}

// post 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $groupCategory =  $_POST['English'][0];
    $groupName = $_POST['English'][1];
    $Hindi =  convertToString($DB, $_POST['Hindi']);
    $Assamese =  convertToString($DB, $_POST['Assamese']);
    $Bengali =   convertToString($DB, $_POST['Bengali']);
    $Gujarati =   convertToString($DB, $_POST['Gujarati']);
    $Kannada =   convertToString($DB, $_POST['Kannada']);
    $Khasi =   convertToString($DB, $_POST['Khasi']);
    $Konkani =   convertToString($DB, $_POST['Konkani']);
    $Konyak =   convertToString($DB, $_POST['Konyak']);
    $Lushai =  convertToString($DB, $_POST['Lushai']);
    $Malayalam = convertToString($DB, $_POST['Malayalam']);
    $Manipuri = convertToString($DB, $_POST['Manipuri']);
    $Marathi =  convertToString($DB, $_POST['Marathi']);
    $Nepali =  convertToString($DB, $_POST['Nepali']);
    $Nissi =  convertToString($DB, $_POST['Nissi']);
    $Odia =  convertToString($DB, $_POST['Odia']);
    $Punjabi =   convertToString($DB, $_POST['Punjabi']);
    $Shimla =  convertToString($DB, $_POST['Shimla']);
    $Tamil =  convertToString($DB, $_POST['Tamil']);
    $Telugu =  convertToString($DB, $_POST['Telugu']);


    if ($_POST['status'] == 'new') {

        $s = "INSERT INTO `chatgroups`(`groupCategory`, `groupName`, `Hindi`, `Assamese`, `Bengali`, `Gujarati`, `Kannada`, `Khasi`, `Konkani`, `Konyak`, `Lushai`, `Malayalam`, `Manipuri`, `Marathi`, `Nepali`, `Nissi`, `Odia`, `Punjabi`, `Shimla`, `Tamil`, `Telugu`) VALUES ('$groupCategory','$groupName','$Hindi','$Assamese','$Bengali','$Gujarati','$Kannada','$Khasi','$Konkani','$Konyak','$Lushai','$Malayalam','$Manipuri','$Marathi','$Nepali','$Nissi','$Odia','$Punjabi','$Shimla','$Tamil','$Telugu')";
    } else {
        $ID = $_POST['id'];
        $s = "UPDATE `chatgroups`
        SET `groupCategory` = '$groupCategory',
            `groupName` = '$groupName',
            `Hindi` = '$Hindi',
            `Assamese` = '$Assamese',
            `Bengali` = '$Bengali',
            `Gujarati` = '$Gujarati',
            `Kannada` = '$Kannada',
            `Khasi` = '$Khasi',
            `Konkani` = '$Konkani',
            `Konyak` = '$Konyak',
            `Lushai` = '$Lushai',
            `Malayalam` = '$Malayalam',
            `Manipuri` = '$Manipuri',
            `Marathi` = '$Marathi',
            `Nepali` = '$Nepali',
            `Nissi` = '$Nissi',
            `Odia` = '$Odia',
            `Punjabi` = '$Punjabi',
            `Shimla` = '$Shimla',
            `Tamil` = '$Tamil',
            `Telugu` = '$Telugu'
        WHERE `id` = '$ID'";
    }

    if ($DB->Query($s)) {
        // echo '<script>
        //     window.location="../admin/chatgroups";
        // </script>';
        echo 'success';
    } else {
        echo '<script>alert("Something Error Occured")</script>';
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

    <title>Graoup Translation | AgriChat</title>
</head>

<body id="body-pd">
    <?php
    include "partials/sidebar.php";
    ?>

    <section class="componentContainer">

        <!-- <h1>Component</h1> -->
        <div class="navigation mb-3">
            <span class="rootMenu"><a href="#">Home</a> / </span><Span class="mainMenu"><a href="#">Translate Group</a></Span>
        </div>

        <div class="row">
            <div class="col">
                <h3 style="font-weight: 600;">Translate Group</h3>
            </div>

            <!-- <div class="col d-flex flex-row-reverse">
                <a href="addTranslation?status=new" class="btn btn-primary mr-4">Add New</a>
            </div> -->
        </div>

        <div class="dataContainer mt-3">
            <div class="row ">
                <div class="col-md-12 col-12 mx-auto">
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">


                        <input type="hidden" name="status" value="<?php echo $_GET['status']; ?>">
                        <?php
                        if ($exits) {
                            echo '<input type="hidden" name="id" value="' . $groupId . '">';
                        }
                        ?>

                        <div class="row">
                            <div class="col-md-12 col-12">

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Group Category (English)</label>
                                        <input type="text" required class="form-control" name="English[]" placeholder="Enter Group Category" value="<?php echo $exits ? $GROUP['groupCategory'] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Group Name (English)</label>
                                        <input type="text" required class="form-control" name="English[]" placeholder="Enter Group Name" value="<?php echo $exits ? $GROUP['groupName'] : '' ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Hindi</label>
                                        <?php
                                        $array = explode(', ', $GROUP['Hindi']);
                                        
                                        ?>
                                        <input type="text" class="form-control" name="Hindi[]" placeholder="Enter Group Category" value="<?php echo $exits && count($array) > 1 ? $array[0] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Hindi</label>
                                        <input type="text" class="form-control" name="Hindi[]" placeholder="Enter Group Name" value="<?php echo $exits && count($array) > 1 ? $array[1] : '' ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <?php
                                    $array = explode(', ', $GROUP['Assamese']);
                                    ?>

                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Assamese,Bodo</label>
                                        <input type="text" class="form-control" name="Assamese[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Assamese,Bodo</label>
                                        <input type="text" class="form-control" name="Assamese[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <?php
                                    $array = explode(', ', $GROUP['Bengali']);
                                    ?>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Bengali</label>
                                        <input type="text" class="form-control" name="Bengali[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Bengali</label>
                                        <input type="text" class="form-control" name="Bengali[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <?php
                                    $array = explode(', ', $GROUP['Gujarati']);
                                    ?>

                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Gujarati</label>
                                        <input type="text" class="form-control" name="Gujarati[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Gujarati</label>
                                        <input type="text" class="form-control" name="Gujarati[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <?php
                                    $array = explode(', ', $GROUP['Kannada']);
                                    ?>

                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Kannada</label>
                                        <input type="text" class="form-control" name="Kannada[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Kannada</label>
                                        <input type="text" class="form-control" name="Kannada[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <?php
                                    $array = explode(', ', $GROUP['Khasi']);
                                    ?>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Khasi,Garo</label>
                                        <input type="text" class="form-control" name="Khasi[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Khasi,Garo</label>
                                        <input type="text" class="form-control" name="Khasi[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <?php
                                    $array = explode(', ', $GROUP['Konkani']);
                                    ?>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Konkani</label>
                                        <input type="text" class="form-control" name="Konkani[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label fw-bold">Konkani</label>
                                        <input type="text" class="form-control" name="Konkani[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3">

                                <?php
                                $array = explode(', ', $GROUP['Konyak']);
                                ?>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Konyak, Ao, Sema</label>
                                    <input type="text" class="form-control" name="Konyak[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Konyak, Ao, Sema</label>
                                    <input type="text" class="form-control" name="Konyak[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <?php
                                    $array = explode(', ', $GROUP['Lushai']);
                                    ?>
                                    <label for="" class="form-label fw-bold">Lushai/ Mizo</label>
                                    <input type="text" class="form-control" name="Lushai[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Lushai/ Mizo</label>
                                    <input type="text" class="form-control" name="Lushai[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                <?php
                                $array = explode(', ', $GROUP['Malayalam']);
                                ?>
                                    <label for="" class="form-label fw-bold">Malayalam</label>
                                    <input type="text" class="form-control" name="Malayalam[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Malayalam</label>
                                    <input type="text" class="form-control" name="Malayalam[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                <?php
                                $array = explode(', ', $GROUP['Manipuri']);
                                ?>
                                    <label for="" class="form-label fw-bold">Manipuri</label>
                                    <input type="text" class="form-control" name="Manipuri[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Manipuri</label>
                                    <input type="text" class="form-control" name="Manipuri[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <?php
                                $array = explode(', ', $GROUP['Marathi']);
                                ?>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Marathi</label>
                                    <input type="text" class="form-control" name="Marathi[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Marathi</label>
                                    <input type="text" class="form-control" name="Marathi[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <?php
                                $array = explode(', ', $GROUP['Nepali']);
                                ?>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Nepali</label>
                                    <input type="text" class="form-control" name="Nepali[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Nepali</label>
                                    <input type="text" class="form-control" name="Nepali[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <?php
                                $array = explode(', ', $GROUP['Nissi']);
                                ?>

                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Nissi/Dafla,Adi</label>
                                    <input type="text" class="form-control" name="Nissi[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Nissi/Dafla,Adi</label>
                                    <input type="text" class="form-control" name="Nissi[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="row mb-3">
                                <?php
                                $array = explode(', ', $GROUP['Odia']);
                                ?>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Odia</label>
                                    <input type="text" class="form-control" name="Odia[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Odia</label>
                                    <input type="text" class="form-control" name="Odia[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <?php
                                $array = explode(', ', $GROUP['Punjabi']);
                                ?>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Punjabi</label>
                                    <input type="text" class="form-control" name="Punjabi[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Punjabi</label>
                                    <input type="text" class="form-control" name="Punjabi[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <?php
                                $array = explode(', ', $GROUP['Shimla']);
                                ?>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Shimla</label>
                                    <input type="text" class="form-control" name="Shimla[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Shimla</label>
                                    <input type="text" class="form-control" name="Shimla[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <?php
                                $array = explode(', ', $GROUP['Tamil']);
                                ?>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Tamil</label>
                                    <input type="text" class="form-control" name="Tamil[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Tamil</label>
                                    <input type="text" class="form-control" name="Tamil[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <?php
                                $array = explode(', ', $GROUP['Telugu']);
                                ?>

                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Telugu</label>
                                    <input type="text" class="form-control" name="Telugu[]" placeholder="Enter Group Category" value="<?php echo $exits ? $array[0] : '' ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label fw-bold">Telugu</label>
                                    <input type="text" class="form-control" name="Telugu[]" placeholder="Enter Group Name" value="<?php echo $exits ? $array[1] : '' ?>">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3 btn-lg">Save Changes</button>

                        </div>

                </div>


                </form>





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