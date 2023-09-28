<?php
include "includes/config.php";

if (!isset($_GET['status']) || empty($_GET['status'])) {
    echo '<script>
    window.location="../admin/translation";
</script>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if ($_POST['status'] == 'new') {
        $sql = "INSERT INTO `translation` (`English`, `Hindi`, `Assamese`, `Bengali`, `Gujarati`, `Kannada`, `Khasi`, `Konkani`, `Konyak`, `Lushai`, `Malayalam`, `Manipuri`, `Marathi`, `Nepali`, `Nissi`, `Odia`, `Punjabi`, `Shimla`, `Tamil`, `Telugu`) VALUES ('".$_POST['english']."', '".$_POST['Hindi']."', '".$_POST['Assamese']."', '".$_POST['Bengali']."', '".$_POST['Gujarati']."', '".$_POST['Kannada']."', '".$_POST['Khasi']."', '".$_POST['Konkani']."', '".$_POST['Konyak']."', '".$_POST['Lushai']."', '".$_POST['Malayalam']."', '".$_POST['Manipuri']."', '".$_POST['Marathi']."', '".$_POST['Nepali']."', '".$_POST['Nissi']."', '".$_POST['Odia']."', '".$_POST['Punjabi']."', '".$_POST['Shimla']."', '".$_POST['Tamil']."', '".$_POST['Telugu']."');";
    }
    if ($_POST['status'] == "update") {
        $id = $_POST['id'];
        $sql = "UPDATE `translation` SET `English`='".$_POST['english']."',`Hindi`='".$_POST['Hindi']."',`Assamese`='".$_POST['Assamese']."',`Bengali`='".$_POST['Bengali']."',`Gujarati`='".$_POST['Gujarati']."',`Kannada`='".$_POST['Kannada']."',`Khasi`='".$_POST['Khasi']."',`Konkani`='".$_POST['Konkani']."',`Konyak`='".$_POST['Konyak']."',`Lushai`='".$_POST['Lushai']."',`Malayalam`='".$_POST['Malayalam']."',`Manipuri`='".$_POST['Manipuri']."',`Marathi`='".$_POST['Marathi']."',`Nepali`='".$_POST['Nepali']."',`Nissi`='".$_POST['Nissi']."',`Odia`='".$_POST['Odia']."',`Punjabi`='".$_POST['Punjabi']."',`Shimla`='".$_POST['Shimla']."',`Tamil`='".$_POST['Tamil']."',`Telugu`='".$_POST['Telugu']."' WHERE `id` = '$id'";
    }


    if ($DB->Query($sql)) {
        echo '<script>
            window.location="../admin/translation";
        </script>';
    } else {
        echo '<script>alert("Something Error Occured")</script>';
    }
}

$exits = false;
if (isset($_GET['status']) && $_GET['status'] == 'update') {
    if (isset($_GET['id'])) {

        $id = $_GET['id'];
        $q = "SELECT * FROM `translation` WHERE id = $id";
        if ($DB->Query($q) > 0) {
            $data = $DB->RetriveSingle($q);
            $exits = true;
        }
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

    <title>Add New Label Translation</title>
</head>

<body id="body-pd">
    <?php
    include "partials/sidebar.php";
    ?>
    <section class="componentContainer">

        <div class="navigation mb-3">
            <span class="rootMenu"><a href="#">Home</a> / </span><Span class="mainMenu"><a href="#">Add New Label Translation</a></Span>
        </div>

        </div>

        <div class="dataContainer mt-3">
            <div class="row ">
                <div class="col-md-12 col-12 mx-auto">


                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" class="row">

                        <input type="hidden" name="status" value="<?php echo $_GET['status']; ?>">
                        <?php
                        if ($exits) {
                            echo '<input type="hidden" name="id" value="' . $_GET['id'] . '">';
                        }
                        ?>

                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="" class="fw-bold">English</label>
                                    <input type="text" name="english" required placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['English'] :"" ?>" >
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Hindi</label>
                                    <input type="text" name="Hindi" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Hindi'] :"" ?>" >
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Assamese,Bodo</label>
                                    <input type="text" name="Assamese" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Assamese'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Bengali</label>
                                    <input type="text" name="Bengali" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Bengali'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Gujarati</label>
                                    <input type="text" name="Gujarati" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Gujarati'] :"" ?>" >
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Kannada</label>
                                    <input type="text" name="Kannada" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Kannada'] :"" ?>" >
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Khasi,Garo</label>
                                    <input type="text" name="Khasi" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Khasi'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Konkani</label>
                                    <input type="text" name="Konkani" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Konkani'] :"" ?>">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Konyak, Ao, Sema</label>
                                    <input type="text" name="Konyak" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Konyak'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Lushai/ Mizo</label>
                                    <input type="text" name="Lushai" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Lushai'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Malayalam</label>
                                    <input type="text" name="Malayalam" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Malayalam'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Manipuri</label>
                                    <input type="text" name="Manipuri" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Manipuri'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Marathi</label>
                                    <input type="text" name="Marathi" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Marathi'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Nepali</label>
                                    <input type="text" name="Nepali" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Nepali'] :"" ?>"> 
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Nissi/Dafla,Adi</label>
                                    <input type="text" name="Nissi" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Nissi'] :"" ?>">
                                </div>

                            </div>

                            <div class="col-md-4 col-12">
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Odia</label>
                                    <input type="text" name="Odia" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Odia'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Punjabi</label>
                                    <input type="text" name="Punjabi" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Punjabi'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Shimla</label>
                                    <input type="text" name="Shimla" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Shimla'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Tamil</label>
                                    <input type="text" name="Tamil" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Tamil'] :"" ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="fw-bold">Telugu</label>
                                    <input type="text" name="Telugu" placeholder="Enter Your Label" class="form-control" value="<?php echo $exits? $data['Telugu'] :"" ?>">
                                </div>

                                <button type="submit" class="btn-primary btn btn-lg w-100 mx-auto"> Submit</button>

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