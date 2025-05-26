<?php 
include '../Includes/dbcon.php';
include '../Includes/session.php';


    // $query = "SELECT tblclass.className,tblclassarms.classArmName 
    // FROM tblclassteacher
    // INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    // INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    // Where tblclassteacher.Id = '$_SESSION[userId]'";

    // $rs = $conn->query($query);
    // $num = $rs->num_rows;
    // $rrw = $rs->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="../img/logo/attnlg.png" rel="icon">
    <title>Dashboard</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <style>
        .video-container {
            position: relative;
            /* border: 1px solid #ccc; */
            margin-bottom: 10px;
            cursor: pointer;
        }

        .video-item {
            width: 100%;
        }

        .highlight {
            border: 2px solid red;
            /* Just for testing purposes, replace with your desired styling */
        }

        .camera-name {
            position: absolute;
            top: 10px;
            left: 10px;
            color: red;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include "Includes/sidebar.php";?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include "Includes/topbar.php";?>
                <!-- Topbar -->
                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>

                    <!-- ------------------------------------------------------------------------------------------------------- -->
                    <div class="row mb-3">



                        <!-- -------------------------------------------ADDING LIVE FEED---------------------------------------------- -->
                        <div class="row">
                            <div class="col-lg-9">
                                <div style="position: relative;">
                                    <video class="video-item enlarged" id="main-video" autoplay playsinline></video>
                                    <div class="camera-name">Live 🔴</div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <!-- ----------------------------------------------- -->
                                <?php
                                    $query = "SELECT * FROM camera";
                                    $rs = $conn->query($query);
                                    $num = $rs->num_rows;
                                    if ($num > 0) {
                                        $rows = $rs->fetch_assoc();
                                        echo '
                                            <div class="video-container">
                                                <video class="video-item highlight" id="camera-' . $rows['id'] . '" autoplay playsinline></video>
                                                <div class="camera-name">' . $rows['location'] . '</div>
                                            </div>';

                                        while ($rows = $rs->fetch_assoc()) {
                                            echo '
                                            <div class="video-container">
                                                <video class="video-item" id="camera-' . $rows['id'] . '" autoplay playsinline></video>
                                                <div class="camera-name">' . $rows['location'] . '</div>
                                            </div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">
                                                No Cameras Found!
                                            </div>';
                                    }
                                ?>

                                <!-- ----------------------------------------------------------- -->
                            </div>
                        </div>


                        <!-- <ul id="device-list"></ul> -->
                        <!-- ----------------------JS PART------------ -->
                        <script>
                            // Get access to the webcam
                            navigator.mediaDevices.getUserMedia({ video: true })
                            .then(function(stream) {
                                var video = document.getElementById('main-video');
                                video.srcObject = stream;
                                video.play();
                            })
                            .catch(function(err) {
                                console.log('Error: ' + err);
                            });
                        </script>


                        <?php
                            $query = "SELECT * FROM camera";
                            $rs = $conn->query($query);
                            $num = $rs->num_rows;
                            if ($num > 0) {
                                $rows = $rs->fetch_assoc();
                                echo '
                                    <script>
                                        const device_' . $rows['id'] . ' = "' . $rows['device_id'] . '";
                                        navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: device_' . $rows['id'] . ' } } })
                                            .then(stream => {
                                                const videoElement = document.getElementById("camera-' . $rows['id'] . '");
                                                const videoElement_main = document.getElementById("main-video");
                                                videoElement.srcObject = stream;
                                                videoElement_main.srcObject = stream;
                                            })
                                            .catch(error => {
                                                console.error("Error accessing webcam:", error);
                                            });
                                    </script>';

                                while ($rows = $rs->fetch_assoc()) {
                                    echo '
                                    <script>
                                        const device_' . $rows['id'] . ' = "' . $rows['device_id'] . '";
                                        navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: device_' . $rows['id'] . ' } } })
                                            .then(stream => {
                                                const videoElement = document.getElementById("camera-' . $rows['id'] . '");
                                                videoElement.srcObject = stream;
                                            })
                                            .catch(error => {
                                                console.error("Error accessing webcam:", error);
                                            });
                                    </script>';
                                }
                            } else {
                                echo '<div class="alert alert-danger" role="alert">
                                        No Cameras Found!
                                    </div>';
                            }
                        ?>

                        <!-- script used to enlarge the video when clicked -->
                        <script>
                            $(document).ready(function () {
                                // Function to highlight current video
                                function highlight(videoElement) {
                                    $('.video-item').removeClass('highlight'); // Remove highlight class from all videos
                                    videoElement.addClass('highlight'); // Add highlight class to the clicked video
                                }

                                // Click event handler for mini camera feeds
                                $('.video-container').on('click', function () {
                                    highlight($(this).find('.video-item'));

                                    var clickedVideo = $(this).find('.video-item')[0];

                                    // Get the srcObject of the clicked video
                                    var clickedSrcObject = clickedVideo.srcObject;

                                    // Set the srcObject of the main video
                                    $('#main-video')[0].srcObject = clickedSrcObject;
                                });
                            });
                        </script>


                        <!-- --jsscript to list the device ids--- -->
                        <!-- <script>
        navigator.mediaDevices.enumerateDevices()
            .then(devices => {
                const videoDevices = devices.filter(device => device.kind === 'videoinput');
                const deviceList = document.getElementById('device-list');
                videoDevices.forEach(device => {
                    const listItem = document.createElement('li');
                    listItem.textContent = `Device ID: ${device.deviceId}, Label: ${device.label}`;
                    deviceList.appendChild(listItem);
                });
            })
            .catch(error => {
                console.error('Error enumerating devices:', error);
            });
    </script> -->
                        <!-- -------------------------------------------LIVE FEED END---------------------------------------------- -->

                        <!-- Add the JavaScript code to draw the pie chart -->




                        <!-- ------------------------------------------------------------------------------------------------------- -->


                        <!--Row-->

                        <!-- <div class="row">
            <div class="col-lg-12 text-center">
              <p>Do you like this template ? you can download from <a href="https://github.com/indrijunanda/RuangAdmin"
                  class="btn btn-primary btn-sm" target="_blank"><i class="fab fa-fw fa-github"></i>&nbsp;GitHub</a></p>
            </div>
          </div> -->

                    </div>
                    <!---Container Fluid-->
                </div>
                <!-- Footer -->
                <!-- Footer -->
            </div>
        </div>

        <!-- Scroll to top -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="js/ruang-admin.min.js"></script>
        <!-- <script src="../vendor/chart.js/Chart.min.js"></script> -->
        <!-- <script src="js/demo/chart-area-demo.js"></script> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->


        <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/coco-ssd"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

</body>

</html>