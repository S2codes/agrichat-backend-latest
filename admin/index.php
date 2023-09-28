<?php
include "includes/config.php";

$total_farmer = $DB->CountRows("SELECT * FROM `users` WHERE `type` = 'farmer'");
$total_business = $DB->CountRows("SELECT * FROM `users` WHERE `type` = 'farmer'");
$total_expert = $DB->CountRows("SELECT * FROM `users` WHERE `type` = 'farmer'");
$total_student = $DB->CountRows("SELECT * FROM `users` WHERE `type` = 'farmer'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ===== BOX ICONS ===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <!-- ===== CSS ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">

    <title>Manegment system</title>
</head>

<body id="body-pd">
    <?php
    include "partials/sidebar.php";
    ?>

    <section class="componentContainer">
        <!-- <h1>Component</h1> -->
        <div class="navigation mb-3">
            <span class="rootMenu"><a href="#">Home</a> / </span><Span class="mainMenu"><a href="#">DashBoad</a></Span>
        </div>

        <!-- statictics card  -->
        <div class="row">

            <div class="col m-2 numBox">
                <a href="users?type=farmer">
                <div class="numIcon" style="background-color: rgba(3, 3, 177, 0.678);">
                    <i class='bx bxs-widget'></i>
                </div>
                <div class="numDetails">
                    <span class="numHead">Farmers </span>
                    <span id="totalnum"><?php echo $total_farmer; ?></span>
                </div>
                </a>
            </div>

            <div class="col m-2 numBox">
                <a href="business">
                <div class="numIcon" style=" background-color: rgba(134, 12, 175, 0.705);">
                    <i class='bx bxs-truck'></i>
                </div>
                <div class="numDetails">
                    <span class="numHead">Bussiness </span>
                    <span id="totalnum"><?php echo $total_business; ?></span>
                </div>
                </a>
            </div>

            <div class="col m-2 numBox">
                <a href="experts">
                <div class="numIcon" style=" background-color: rgba(3, 3, 177, 0.678);">
                    <i class='bx bxs-package'></i>
                </div>
                <div class="numDetails">
                    <span class="numHead">Experts </span>
                    <span id="totalnum"><?php echo $total_expert; ?></span>
                </div>
                </a>
            </div>

            <div class="col m-2 numBox">
                <a href="students">
                <div class="numIcon" style=" background-color: rgba(134, 12, 175, 0.705);;">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="numDetails">
                    <span class="numHead">Students</span>
                    <span id="totalnum"><?php echo $total_student; ?></span>
                </div>
                </a>
            </div>
        </div>

        <div class="dataContainer mt-3">
            <div class="row ">
                <div class="col-md-6 ">
                    <h3 style="font-weight: 600;">Chat Groups</h3>
                    <table class="table" id="recentData">

                        <tbody>

                            <tr>
                                <td class="recentProduct"><a href="#">Agriculture</a></td>
                                <td class="recentDate">Paddy</td>
                            </tr>
                            <tr>
                                <td class="recentProduct"><a href="#">Agriculture</a></td>
                                <td class="recentDate">Green Gram</td>
                            </tr>
                            <tr>
                                <td class="recentProduct"><a href="#">Agriculture</a></td>
                                <td class="recentDate">Black Gram</td>
                            </tr>
                            <tr>
                                <td class="recentProduct"><a href="#">Horticulture</a></td>
                                <td class="recentDate">Vegetable</td>
                            </tr>
                            <tr>
                                <td class="recentProduct"><a href="#">Horticulture</a></td>
                                <td class="recentDate">Fruit</td>
                            </tr>
                            <tr>
                                <td class="recentProduct"><a href="#">Horticulture</a></td>
                                <td class="recentDate">Flower</td>
                            </tr>
                            <tr>
                                <td class="recentProduct"><a href="#">Fisheries</a></td>
                                <td class="recentDate">Fish</td>
                            </tr>
                            <tr>
                                <td class="recentProduct"><a href="#">Fisheries</a></td>
                                <td class="recentDate">Prawn</td>
                            </tr>
                            <tr>
                                <td class="recentProduct"><a href="#">Veterinary</a></td>
                                <td class="recentDate">Cow</td>
                            </tr>
                            <tr>
                                <td class="recentProduct"><a href="#">Veterinary</a></td>
                                <td class="recentDate">Goat</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6 ">
                    <h3 style="font-weight: 600;">Users Analytics</h3>
                    <div class="rightdata">
                        <div class="chart">
                            <canvas id="mychart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php
    include "partials/footer.php";
    echo ' <script>
    let chartData = ["'.$total_farmer.'", "'.$total_business.'", "'.$total_expert.'", "'.$total_student.'"];
    </script>';
    ?>

   
    <!--===== MAIN JS =====-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        // ====== chart ====== //

        const data = {
            labels: [
                'Farmers',
                'Business',
                'Expert',
                'Student'
            ],
            datasets: [{
                label: 'My First Dataset',
                // data: [250, 100, 50, 25],
                data: chartData,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(192,75,75)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'pie',
            data: data,
        }
        const myChart = new Chart(
            document.getElementById('mychart').getContext("2d"),
            config
        );
    </script>
</body>

</html>