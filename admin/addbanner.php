<?php
include "includes/config.php";
$GETbannerId = $_GET['id'];

$isSuccess = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $link = $_POST['link'];
    $state = $_POST['state'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $status = $_POST['status'];
    $bannerId = $_POST['bannerid'];

    if (empty($link) || $link == '') {
        $link = '#';
    }



    $file = $_FILES["image"]["name"];
    $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $attachment_name = time() . "-" . date('dmYH') . "." . $imageFileType;
    $path = "../slider/" . $attachment_name;
    $BannerId =  $_POST['bannerid'];
    move_uploaded_file($_FILES["image"]["tmp_name"], $path);

    if ($_POST['itemid'] != 0) {
        // update 
        $id = $_POST['itemid'];
        if ($_FILES['image']['size'] < 1 || $_FILES['image']['name'] == '') {
            $file = $_FILES["image"]["name"];
            $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $attachment_name = time() . "-" . date('dmYH') . "." . $imageFileType;
            $path = "../slider/" . $attachment_name;
            $BannerId =  $_POST['bannerid'];
            move_uploaded_file($_FILES["image"]["tmp_name"], $path);

            $sql = "UPDATE `banner` SET `link`='$link',`state`='$state',`start`='$start',`end`='$end',`status`='$status' WHERE `id` = '$id'";
        } else {
            $sql = "UPDATE `banner` SET `img`='$attachment_name',`link`='$link',`state`='$state',`start`='$start',`end`='$end',`status`='$status' WHERE `id` = '$id'";
        }
    } else {
        // add new 
        $file = $_FILES["image"]["name"];
        $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $attachment_name = time() . "-" . date('dmYH') . "." . $imageFileType;
        $path = "../slider/" . $attachment_name;
        $BannerId =  $_POST['bannerid'];
        move_uploaded_file($_FILES["image"]["tmp_name"], $path);
        $sql = "INSERT INTO `banner`(`bannerID`, `img`, `link`, `state`, `start`, `end`, `status`) VALUES ('$bannerId','$attachment_name','$link','$state','$start','$end','$status')";
    }


    if ($DB->Query($sql)) {
        $isSuccess = true;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- ===== CSS ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">

    <title>Add Banner | AgriChat</title>
</head>
<style>
    .bannerImgUpload {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<body id="body-pd">
    <?php
    include "partials/sidebar.php";
    ?>

    <section class="componentContainer">

        <!-- <h1>Component</h1> -->
        <div class="navigation mb-3">
            <span class="rootMenu"><a href="#">Home</a> / </span><Span class="mainMenu"><a href="#">Banner</a></Span>
        </div>

        <div class="row">
            <div class="col">
                <h3 style="font-weight: 600;">Banner <?php echo $GETbannerId; ?> </h3>
            </div>

            <div class="col d-flex flex-row-reverse">
                <button data-bs-toggle="modal" data-bs-target="#BannerModal" class="btn btn-primary mr-4 btnNewItem">Add Item</button>
            </div>
        </div>

        <?php
        if ($isSuccess) {
            echo '
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <strong>Success!</strong> Banner Image is Updated.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
                ';
        }
        ?>


        <div class="dataContainer mt-3">
            <div class="row ">
                <div class="col-md-11 col-12 mx-auto">

                    <?php
                    $currentDateTime =  date('Y-m-d H:i');

                    $q = "SELECT * FROM `banner` WHERE `state` = 0 AND `bannerID` = '$GETbannerId'";
                    if ($DB->CountRows($q)) {
                        $enquiries = $DB->RetriveArray($q);

                        echo '<h4>Default Banner</h4>
                        <div class="row row-cols-1 row-cols-md-3 g-4">';
                        foreach ($enquiries as $enq) {

                            $showlink = strlen($enq['link']) > 28 ? substr($enq['link'], 0, 28) . "..." : $enq['link'];

                            $s = date_create($enq['start']);
                            $start = date_format($s, 'Y-m-d H:i');

                            $e = date_create($enq['end']);
                            $end = date_format($e, 'Y-m-d H:i');


                            if ($currentDateTime  >= $enq['start']) {
                                if ($currentDateTime <= $enq['end']) {
                                    $status = true;
                                } else {
                                    $status = false;
                                }
                            } else {
                                $status = false;
                            }




                            echo '
                            <div class="col-md-3">
                                <div class="card">
                                    <img src="../slider/' . $enq['img'] . '" class="card-img-top" alt="banner">
                                    <div class="card-body">
                                        <p class="card-text m-0">link : <a href="' . $enq['link'] . '" target="_blank">' . $showlink . '</a> </p>
                                        <p class="m-0">Start : ' . $start . ' </p>
                                        <p class="m-0"> End : ' . $end . ' </p>
                                        <div class="d-flex justify-content-between">';
                            if ($enq['status'] == 'active') {
                                if ($status) {
                                    echo "<span class='text-success fw-bold'>Active</span>";
                                } else {
                                    echo "<span class='text-danger fw-bold'>Inactive</span>";
                                }
                            } else {
                                echo "<span class='text-danger fw-bold'>Inactive</span>";
                            }

                            echo '  
                                <div>
                            
                                        <a href="#" class="editBanner text-primary me-5" data-banner="' . $GETbannerId . '" data-id="' . $enq['id'] . '">
                                        <i class="bi bi-pencil-square"></i> </a>

                                        <a href="#" class="dltBanner text-danger" data-banner="' . $GETbannerId . '" data-id="' . $enq['id'] . '">
                                        <i class="bi bi-trash-fill"></i> </a>


                                        </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                        echo '</div>';

                    ?>
                    <?php

                        $ds = "SELECT DISTINCT `state` FROM `banner` WHERE `bannerID` = '$GETbannerId' AND `state` != '0'";
                        $states = $DB->RetriveArray($ds);
                        foreach ($states as $key => $value) {
                            $stateid = $value['state'];
                            $stS = "SELECT * FROM `state` WHERE `id` = '$stateid'";
                            $stData = $DB->RetriveSingle($stS);
                            $stateName = $stData['state'];

                            $q = "SELECT * FROM `banner` WHERE `state` = '$stateid' AND `bannerID` = '$GETbannerId'";
                            if ($DB->CountRows($q)) {
                                $enquiries = $DB->RetriveArray($q);

                                echo '<h4 class="mt-4">' . $stateName . ' Banner</h4>
                                <div class="row g-4">';
                                foreach ($enquiries as $enq) {

                                    $s = date_create($enq['start']);
                                    $start = date_format($s, 'Y-m-d H:i');

                                    $e = date_create($enq['end']);
                                    $end = date_format($e, 'Y-m-d H:i');


                                    $status = false;

                                    if ($currentDateTime  >= $enq['start']) {
                                        if ($currentDateTime <= $enq['end']) {
                                            $status = true;
                                        } else {
                                            $status = false;
                                        }
                                    } else {
                                        $status = false;
                                    }

                                    $showlink = strlen($enq['link']) > 28 ? substr($enq['link'], 0, 28) . "..." : $enq['link'];

                                    echo '
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="../slider/' . $enq['img'] . '" class="card-img-top" alt="banner">
                                            <div class="card-body">
                                                <p class="card-text m-0">link : <a href="' . $enq['link'] . '" target="_blank">' . $showlink . '</a> </p>
                                                <p class="m-0">Start : ' . $start . ' </p>
                                                <p class="m-0"> End : ' . $end . ' </p>
                                                <div class="d-flex justify-content-between">';
                                    if ($enq['status'] == 'active') {
                                        if ($status) {
                                            echo "<span class='text-success fw-bold'>Active</span>";
                                        } else {
                                            echo "<span class='text-danger fw-bold'>Inactive</span>";
                                        }
                                    } else {
                                        echo "<span class='text-danger fw-bold'>Inactive</span>";
                                    }
                                    echo '
                                                <div>
                                                <a href="#" class="editBanner text-primary me-5" data-banner="' . $GETbannerId . '" data-id="' . $enq['id'] . '">
                                        <i class="bi bi-pencil-square"></i> </a>

                                                <a href="#" class="dltBanner text-danger" data-banner="' . $GETbannerId . '" data-id="' . $enq['id'] . '">
                                                <i class="bi bi-trash-fill"></i> </a>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                                }
                                echo '</div>';
                            }
                        }
                    } ?>
                </div>


            </div>
        </div>


    </section>


    <!-- Modal -->
    <div class="modal fade" id="BannerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Banner Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">



                    <form action="addbanner?id=<?php echo $GETbannerId; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="bannerid" value="<?php echo $GETbannerId; ?>">
                        <div class="view d-none mb-3" style="width: 100%; height:100px">
                        </div>
                        <input type="hidden" name="itemid" id="itemid">
                        <input type="file" name="image" required id="bannerImg" class="form-control mb-3" accept="image/*">
                        <input type="text" name="link" placeholder="Link" class="form-control mb-3" id="bannerLink">
                        <Select required class="form-select mb-3" name="state" id="bannerState">
                            <option value="" selected disabled>Select State</option>
                            <option value="0">All</option>
                            <?php
                            $stSql = "SELECT * FROM `state`";
                            $states = $DB->RetriveArray($stSql);
                            foreach ($states as $key => $value) {
                                echo '<option value="' . $value['id'] . '">' . $value['state'] . '</option>';
                            }
                            ?>
                        </Select>
                        <div class="row mb-3">
                            <div class="col-md-6 col-6">
                                <label for="">Start</label>
                                <input type="datetime-local" name="start" required class="form-control" id="bannerStart">
                            </div>
                            <div class="col-md-6 col-6">
                                <label for="">End</label>
                                <input type="datetime-local" name="end" required class="form-control" id="bannerEnd">
                            </div>
                        </div>

                        <label for="">Status</label>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="radio" name="status" id="bannerActive" value="active" checked> Active
                            </div>
                            <div class="col-md-6">
                                <input type="radio" name="status" id="bannerInactive" value="inactive"> Inactive
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mb-3 modalBtnGroup">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnSubmit" class="ms-3 btn btn-primary">Submit</button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <?php
    include "partials/footer.php";
    ?>


    <!--===== MAIN JS =====-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();

            $('#bannerImg').on("change", function() {
                console.log("change");
                let files = $(this)[0].files;
                $('.view').empty();
                $('.view').removeClass('d-none');
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.view').html(`<img src="${e.target.result}" class="bannerImgUpload" alt="banner" />`)
                }
                reader.readAsDataURL(file)


            })


            $('.btnNewItem').click(function() {
                $('#exampleModalLabel').text('Add New Banner')
                $('#bannerLink').val('')
                $('#bannerState').val('')
                $('#bannerStart').val('')
                $('#bannerEnd').val('')
                $('#itemid').val(0)
                if (data.data.status == 'active') {
                    $('#bannerActive').attr('checked')
                }
            })


            $('.editBanner').click(function() {
                // alert("edit modal")
                const id = $(this).attr('data-id');

                $.ajax({
                    url: "./controller/editBanner.php",
                    type: "POST",
                    data: {
                        id
                    },
                    success: function(data) {
                        data = JSON.parse(data);
                        console.log(data);
                        if (data.response) {
                            $('#exampleModalLabel').text('Update Banner ')
                            $('#bannerImg').removeAttr('required')
                            $('#bannerLink').val(data.data.link)
                            $('#bannerState').val(data.data.state)
                            $('#bannerStart').val(data.data.start)
                            $('#bannerEnd').val(data.data.end)
                            $('#itemid').val(data.data.id)
                            if (data.data.status == 'active') {
                                $('#bannerActive').attr('checked')
                            } else {
                                $('#bannerInactive').attr('checked')
                            }
                            $('#BannerModal').modal('show')

                        }
                    }
                })


            })




            $('.dltBanner').click(function() {
                const id = $(this).attr('data-id')

                swal({
                        title: "Are you sure?",
                        text: "You want to delete this ",
                        icon: "warning",
                        buttons: {
                            cancel: {
                                text: "Cancel",
                                value: null,
                                visible: true,
                                className: "",
                                closeModal: true,
                            },
                            confirm: {
                                text: "Delete",
                                value: true,
                                visible: true,
                                className: "",
                                closeModal: true
                            }
                        },
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            console.log("sure");
                            $.ajax({
                                url: "./controller/deletebanner.php",
                                type: "POST",
                                data: {
                                    id
                                },
                                success: function(data) {
                                    data = JSON.parse(data);
                                    if (data.response) {
                                        swal("Success! User's Status is Changed", {
                                            icon: "success",
                                        });
                                    }
                                }
                            })
                        }
                    });


            })


        });
    </script>
    <script src="assets/js/main.js"></script>

</body>

</html>