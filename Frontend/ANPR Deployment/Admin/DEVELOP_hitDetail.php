<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch details from hitlogs table
    $query = "SELECT records.*,camera.*, records.location AS record_location, hitlogs.record_id AS boloId FROM hitlogs INNER JOIN bolo ON hitlogs.record_id = bolo.id INNER JOIN records ON bolo.record_id = records.Id INNER JOIN camera ON hitlogs.camera_id = camera.id WHERE hitlogs.id = $id";
    $result = $conn->query($query);
}

// ----------------------------------------------
if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete"){

    $Id= $_GET['Id'];
    
    $query = mysqli_query($conn,"DELETE FROM hitlogs WHERE id='$Id'");

    if ($query == TRUE) {

            echo "<script type = \"text/javascript\">
            window.location = (\"index.php\")
            </script>";  
    }
    else{

        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
    }
}
// ---------------------------------------------------

// ----------------------------------------------
if (isset($_GET['Id']) && isset($_GET['Plate']) && isset($_GET['action']) && $_GET['action'] == "close"){

    $Id= $_GET['Id'];
    $Plate= $_GET['Plate'];

    $query = "SELECT record_id FROM hitlogs WHERE id = $Id";
    $result = $conn->query($query);
    $bolo_id = $result->fetch_assoc();
    
    $hitlogs_query = mysqli_query($conn,"DELETE hitlogs FROM hitlogs INNER JOIN bolo ON hitlogs.record_id = bolo.id INNER JOIN records ON bolo.record_id = records.Id INNER JOIN camera ON hitlogs.camera_id = camera.id WHERE plate_no='$Plate'");
    $bolo_query = mysqli_query($conn,"DELETE FROM bolo WHERE id='".$bolo_id['record_id']."'");

    if ($hitlogs_query == TRUE && $bolo_query == TRUE) {

            echo "<script type = \"text/javascript\">
            window.location = (\"index.php\")
            </script>";  
    }
    else{

        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
    }
}
// ---------------------------------------------------
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
    <?php include 'includes/title.php';?>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link href="https://cdn.maptiler.com/maptiler-sdk-js/v1.2.0/maptiler-sdk.css" rel="stylesheet" />
    <script src="https://cdn.maptiler.com/maptiler-sdk-js/v1.2.0/maptiler-sdk.umd.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            width: 100%;
            height: 100%;
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
                        <h1 class="h3 mb-0 text-gray-800">Hit Details</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hit Details</li>
                        </ol>
                    </div>



                    <!-- Input Group -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h2 class="m-0 font-weight-bold text-primary">Hit Details</h2>
                                    <?php echo $statusMsg; ?>
                                </div>

                                <div class="card-body">
                                    <?php
                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();

                                            // Display snapshot_file
                                            echo "<a href='../Snapshots/" . $id . "_frame.jpg' target='_blank'>";
                                            echo "<img src='../Snapshots/" . $id . "_frame.jpg' alt='Snapshot' style='max-width: 100%; height: auto; border-radius: 6px;' />";
                                            echo "</a>";
                                            echo "<div class='mb-3'></div>";
                                            echo "<p style='display: inline'><strong>Plate:</strong> </p>";
                                            echo "<a href='../Snapshots/" . $id . "_plate.jpg' target='_blank'>";
                                            echo "<img src='../Snapshots/" . $id . "_plate.jpg' alt='Snapshot' style='max-width: 100%; height: auto; border-radius: 6px;' />";
                                            echo "</a>";
                                            echo "<div class='mb-4'></div>";
                                            echo "<hr class='my-4'>";




                                            echo "<div class='row'>";
                                                echo "<div class='col-md-3'>";
                                                    // Display details in a report format
                                                    echo "<p><strong>Record ID:</strong> " . $row['Id'] . "</p>";
                                                    echo "<p><strong>Plate Number:</strong> " . $row['plate_no'] . "</p>";
                                                    echo "<p><strong>Reason:</strong> " . $row['reason'] . "</p>";
                                                    echo "<p><strong>Vehicle Type:</strong> " . $row['vehicle_type'] . "</p>";
                                                    echo "<p><strong>Vehicle Ownership:</strong> " . $row['vehicle_ownership'] . "</p>";
                                                    echo "<p><strong>Province:</strong> " . $row['province'] . "</p>";
                                                    echo "<p><strong>District:</strong> " . $row['district'] . "</p>";
                                                    echo "<p><strong>Location:</strong> " . $row['record_location'] . "</p>";
                                                    echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
                                                    echo "<p><strong>Remarks:</strong> " . $row['remarks'] . "</p>";
                                                    echo "<p><strong>Created At:</strong> " . $row['created_at'] . "</p>";
                                                    echo "<p><strong>Hit Location:</strong> " . $row['location'] . "</p>";
                                                echo "</div>";

                                                echo "<div class='col-md-9'>";
                                                    // Display the map
                                                    echo "<div id='map' style='border-radius: 6px;'></div>";
                                                    echo "</div>";
                                            echo "</div>";
                                            echo "<div class='mb-4'></div>";
                                            echo "<div class='row'>";
                                                echo "<div class='col-md-6'>";
                                                    echo "<a href='?action=close&Id=".$id."&Plate=".$row['plate_no']."' class='btn btn-danger' >Close BOLO</a>";
                                                echo "</div>";
                                                echo "<div class='col-md-6'>";
                                                    echo "<a href='?action=delete&Id=".$id."' class='btn btn-warning' style='float: right;'>Ignore</a>";
                                                echo "</div>";
                                            echo "</div>";
                                        }
                                        else{
                                            echo "No records found for the given ID.";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

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

        <!-- script to display the map                       -->
        <script>
            maptilersdk.config.apiKey = "8XxKZQG42XZZZv1KQia3";
            var map = new maptilersdk.Map({
                container: "map",
                style: maptilersdk.MapStyle.STREETS,
                center: <?php echo "[".$row['longitude'].",".$row['latitude']."]"; ?>,
                zoom: 13,
            });

            map.on("load", function () {
                map.loadImage(
            'https://docs.maptiler.com/sdk-js/assets/osgeo-logo.png',
            function (error, image) {
                if (error) throw error;
                map.addImage('custom-marker', image);
                // Add a GeoJSON source with 15 points
                map.addSource('conferences', {
                    'type': 'geojson',
                    'data': {
                        'type': 'FeatureCollection',
                        'features': [
                            <?php
                                $plate_no = $row['plate_no'];
                                $map_query1 = "SELECT camera.* FROM hitlogs INNER JOIN bolo ON hitlogs.record_id = bolo.id INNER JOIN records ON bolo.record_id = records.Id INNER JOIN camera ON hitlogs.camera_id = camera.id WHERE records.plate_no = '$plate_no' ORDER BY hitlogs.created_at";
                                $map_result1 = $conn->query($map_query1);
                                while ($MAP_row1 = $map_result1->fetch_assoc())
                                {
                                    echo "{ 'type': 'Feature', 'geometry': { 'type': 'Point', 'coordinates': [".$MAP_row1['longitude'].",".$MAP_row1['latitude']."] },'properties': { 'location': '".$MAP_row1['location']."' } },";
                                }
                            ?>

                        ]
                    }
                });
                map.addSource("lines", {
                    type: "geojson",
                    data: {
                        type: "FeatureCollection",
                        features: [
                            {
                                type: "Feature",
                                properties: {
                                    color: "blue", // red
                                },
                                geometry: {
                                    type: "LineString",
                                    coordinates: [
                                        <?php
                                                $plate_no = $row['plate_no'];
                                                $map_query = "SELECT camera.* FROM hitlogs INNER JOIN bolo ON hitlogs.record_id = bolo.id INNER JOIN records ON bolo.record_id = records.Id INNER JOIN camera ON hitlogs.camera_id = camera.id WHERE records.plate_no = '$plate_no' ORDER BY hitlogs.created_at";
                                                $map_result = $conn->query($map_query);
                                                while ($MAP_row = $map_result->fetch_assoc())
                                                {
                                                    echo "[".$MAP_row['longitude'].",".$MAP_row['latitude']."],";
                                                }
                                        ?>

                                    ],
                                },
                            },
                        ],
                    },
                });
                // Add a symbol layer
                map.addLayer({
                    'id': 'conferences',
                    'type': 'symbol',
                    'source': 'conferences',
                    'layout': {
                        'icon-image': 'custom-marker',
                        // get the year from the source's "year" property
                        'text-field': ['get', 'location'],
                        'text-font': [
                            'Open Sans Semibold',
                            'Arial Unicode MS Bold'
                        ],
                        'text-offset': [0, 1.25],
                        'text-anchor': 'top'
                    }
                });
                map.addLayer({
                    id: "lines",
                    type: "line",
                    source: "lines",
                    paint: {
                        "line-width": 3,
                        // Use a get expression (https://docs.maptiler.com/gl-style-specification/expressions/#get)
                        // to set the line-color to a feature property value.
                        "line-color": ["get", "color"],
                    },
                });
            }
        );
            });

            <?php
                $plate_no = $row['plate_no'];
                // $map_query3 = "SELECT camera.*, hitlogs.id as hitlog_id, hitlogs.created_at AS hit_date FROM hitlogs INNER JOIN bolo ON hitlogs.record_id = bolo.id INNER JOIN records ON bolo.record_id = records.Id INNER JOIN camera ON hitlogs.camera_id = camera.id WHERE records.plate_no = '$plate_no' ORDER BY hitlogs.created_at";
                $map_query3 = "SELECT camera.*, hitlogs.id as hitlog_id, hitlogs.created_at AS hit_date FROM hitlogs INNER JOIN camera ON hitlogs.camera_id = camera.id WHERE hitlogs.record_id = ".$row['boloId']." ORDER BY hitlogs.created_at";
                $map_result3 = $conn->query($map_query3);
                $sn = 1;
                $self_no = 0;
                while ($MAP_row3 = $map_result3->fetch_assoc())
                {
                    if ($MAP_row3['hitlog_id'] != $id)
                    {
                        echo 'var popup = new maptilersdk.Popup({ closeOnClick: false })' . "\n";
                        echo '    .setLngLat([' . $MAP_row3['longitude'] . ', ' . $MAP_row3['latitude'] . '])' . "\n";
                        echo '    .setHTML(\'<a href="./hitDetail.php?id=' . $MAP_row3['hitlog_id'] . '">'.$sn.': '.$MAP_row3['hit_date'].'</a>\')' . "\n";
                        echo '    .addTo(map);' . "\n"; 
                    }
                    else
                    {
                        $self_no = $sn;
                    }
                    $sn++;
                }
            ?>

            // create the popup
            var popup = new maptilersdk.Popup({ offset: 25 }).setText(
                '<?php echo $self_no; ?>'
            );

            const marker = new maptilersdk.Marker()
                .setLngLat(<?php echo "[".$row['longitude'].",".$row['latitude']."]"; ?>)
                .setPopup(popup)
                .addTo(map);
        </script>
        <!-- script to display map ends here -->
</body>

</html>