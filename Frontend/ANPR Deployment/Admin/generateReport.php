<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
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
                        <h1 class="h3 mb-0 text-gray-800">Generate Report</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Generate Report</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Input Group -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Records</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row mb-3">
                                                <div class="col-xl-6">
                                                    <?php
                                                        $query = "SELECT id, name FROM reason";
                                                        $result = $conn->query($query);

                                                        $num = $result->num_rows;
                                                        if($num > 0)
                                                        { 
                                                            $reasons = $result->fetch_all(MYSQLI_ASSOC);
                                                            
                                                        }
                                                        else
                                                        {
                                                            echo   
                                                            "<div class='alert alert-danger' role='alert'>
                                                                No Reasons Found!
                                                                </div>";
                                                        }
                                                        ?>

                                                    <label class="form-control-label">Reason</label>
                                                    <select class="form-control" required name="reason" id="reason">
                                                        <option value="">-- Select Reason --</option>
                                                        <?php
                                                            foreach ($reasons as $reason) {
                                                                echo "<option value='".$reason['name']."'>".$reason['name']."</option>";
                                                            }
                                                            ?>
                                                    </select>
                                                    <span class="error">
                                                        <?php echo isset($errors['reason']) ? $errors['reason'] : ''; ?>
                                                    </span>


                                                </div>

                                                <div class="col-xl-6">
                                                    <label class="form-control-label">Vehicle Type</label>
                                                    <select class="form-control" required name="vehicle_type"
                                                        id="vehicle_type">
                                                        <option value="">--Select Role--</option>
                                                        <option value="bike">Bike</option>
                                                        <option value="car">Car</option>
                                                        <option value="bus">Bus</option>
                                                        <option value="truck">Truck</option>
                                                    </select>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="mb-2"></div>
                                                    <label class="form-control-label">Vehicle Ownership</label>
                                                    <select class="form-control" required name="vehicle_ownership"
                                                        id="vehicle_ownership">
                                                        <option value="">--Select Role--</option>
                                                        <option value="private">Private</option>
                                                        <option value="public">Public</option>
                                                        <option value="government">Government</option>
                                                        <option value="diplomatic">Diplomatic</option>
                                                        <option value="tourist">Tourist</option>
                                                        <option value="corporation">Corporation</option>
                                                    </select>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="mb-2"></div>
                                                    <label class="form-control-label">Province</label>
                                                    <select class="form-control" required name="province" id="province">
                                                        <option value="">--Select Role--</option>
                                                        <option value="bagmati">Bagmati</option>
                                                        <option value="madesh">Madesh</option>
                                                        <option value="koshi">Koshi</option>
                                                        <option value="gandaki">Gandaki</option>
                                                        <option value="lumbini">Lumbini</option>
                                                        <option value="karnali">Karnali</option>
                                                        <option value="sudurpashchim">Sudurpashchim</option>
                                                    </select>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="mb-2"></div>
                                                    <label class="form-control-label">District</label>
                                                    <select class="form-control" required name="district" id="district">
                                                        <option value="">--Select Role--</option>
                                                        <option value="achham">Achham</option>
                                                        <option value="arghakhanchi">Arghakhanchi</option>
                                                        <option value="baglung">Baglung</option>
                                                        <option value="baitadi">Baitadi</option>
                                                        <option value="bajhang">Bajhang</option>
                                                        <option value="bajura">Bajura</option>
                                                        <option value="banke">Banke</option>
                                                        <option value="bara">Bara</option>
                                                        <option value="bardiya">Bardiya</option>
                                                        <option value="bhaktapur">Bhaktapur</option>
                                                        <option value="bhojpur">Bhojpur</option>
                                                        <option value="chitwan">Chitwan</option>
                                                        <option value="dadeldhura">Dadeldhura</option>
                                                        <option value="dailekh">Dailekh</option>
                                                        <option value="dang">Dang</option>
                                                        <option value="darchula">Darchula</option>
                                                        <option value="dhading">Dhading</option>
                                                        <option value="dhankuta">Dhankuta</option>
                                                        <option value="dhanusa">Dhanusa</option>
                                                        <option value="dholkha">Dholkha</option>
                                                        <option value="dolpa">Dolpa</option>
                                                        <option value="doti">Doti</option>
                                                        <option value="eastern rukum">Eastern Rukum</option>
                                                        <option value="gorkha">Gorkha</option>
                                                        <option value="gulmi">Gulmi</option>
                                                        <option value="humla">Humla</option>
                                                        <option value="ilam">Ilam</option>
                                                        <option value="jajarkot">Jajarkot</option>
                                                        <option value="jhapa">Jhapa</option>
                                                        <option value="jumla">Jumla</option>
                                                        <option value="kailali">Kailali</option>
                                                        <option value="kalikot">Kalikot</option>
                                                        <option value="kanchanpur">Kanchanpur</option>
                                                        <option value="kapilvastu">Kapilvastu</option>
                                                        <option value="kaski">Kaski</option>
                                                        <option value="kathmandu">Kathmandu</option>
                                                        <option value="kavrepalanchok">Kavrepalanchok</option>
                                                        <option value="khotang">Khotang</option>
                                                        <option value="lalitpur">Lalitpur</option>
                                                        <option value="lamjung">Lamjung</option>
                                                        <option value="mahottari">Mahottari</option>
                                                        <option value="makwanpur">Makwanpur</option>
                                                        <option value="manang">Manang</option>
                                                        <option value="morang">Morang</option>
                                                        <option value="mugu">Mugu</option>
                                                        <option value="mustang">Mustang</option>
                                                        <option value="myagdi">Myagdi</option>
                                                        <option value="nawalparasi">Nawalparasi</option>
                                                        <option value="nuwakot">Nuwakot</option>
                                                        <option value="okhaldhunga">Okhaldhunga</option>
                                                        <option value="palpa">Palpa</option>
                                                        <option value="panchthar">Panchthar</option>
                                                        <option value="parbat">Parbat</option>
                                                        <option value="parsa">Parsa</option>
                                                        <option value="pyuthan">Pyuthan</option>
                                                        <option value="ramechhap">Ramechhap</option>
                                                        <option value="rasuwa">Rasuwa</option>
                                                        <option value="rautahat">Rautahat</option>
                                                        <option value="rolpa">Rolpa</option>
                                                        <option value="rukum">Rukum</option>
                                                        <option value="rupandehi">Rupandehi</option>
                                                        <option value="salyan">Salyan</option>
                                                        <option value="sankhuwasabha">Sankhuwasabha</option>
                                                        <option value="saptari">Saptari</option>
                                                        <option value="sarlahi">Sarlahi</option>
                                                        <option value="sindhuli">Sindhuli</option>
                                                        <option value="sindhupalchok">Sindhupalchok</option>
                                                        <option value="siraha">Siraha</option>
                                                        <option value="solukhumbu">Solukhumbu</option>
                                                        <option value="sunsari">Sunsari</option>
                                                        <option value="surkhet">Surkhet</option>
                                                        <option value="syangja">Syangja</option>
                                                        <option value="tanahu">Tanahu</option>
                                                        <option value="taplejung">Taplejung</option>
                                                        <option value="terhathum">Terhathum</option>
                                                        <option value="udayapur">Udayapur</option>
                                                        <option value="western rukum">Western Rukum</option>

                                                    </select>
                                                </div>
                                                <div class="col-xl-6"></div>
                                                <div class="col-xl-6">
                                                    <div class="mb-2"></div>
                                                    <button type="button" class="btn btn-primary"
                                                        id="filterButton">Filter</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive p-3">
                                            <table class="table align-items-center table-flush table-hover dataTable"
                                                id="dataTableHover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Plate</th>
                                                        <th>Reason</th>
                                                        <th>Vehicle Type</th>
                                                        <th>Vehicle Ownership</th>
                                                        <th>Province</th>
                                                        <th>District</th>
                                                        <th>Location</th>
                                                        <th>Description</th>
                                                        <th>Remarks</th>
                                                        <th>Created At</th>
                                                        <th>Updated At</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php
                                                        $query = "SELECT * FROM records";
                                                        $rs = $conn->query($query);
                                                        $num = $rs->num_rows;
                                                        $sn=0;
                                                        if($num > 0)
                                                        { 
                                                            while ($rows = $rs->fetch_assoc())
                                                            {
                                                                $sn = $sn + 1;
                                                                echo "
                                                                    <tr>
                                                                        <td>".$sn."</td>
                                                                        <td>".$rows['plate_no']."</td>
                                                                        <td>".$rows['reason']."</td>
                                                                        <td>".$rows['vehicle_type']."</td>
                                                                        <td>".$rows['vehicle_ownership']."</td>
                                                                        <td>".$rows['province']."</td>
                                                                        <td>".$rows['district']."</td>
                                                                        <td>".$rows['location']."</td>
                                                                        <td>".$rows['description']."</td>
                                                                        <td>".$rows['remarks']."</td>
                                                                        <td>".$rows['created_at']."</td>
                                                                        <td>".$rows['updated_at']."</td>
                                                                    </tr>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo   
                                                            "<div class='alert alert-danger' role='alert'>
                                                                No Record Found!
                                                                </div>";
                                                        }
                                                        
                                                        ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Row-->

                        <!-- Documentation Link -->
                        <!-- <div class="row">
            <div class="col-lg-12 text-center">
              <p>For more documentations you can visit<a href="https://getbootstrap.com/docs/4.3/components/forms/"
                  target="_blank">
                  bootstrap forms documentations.</a> and <a
                  href="https://getbootstrap.com/docs/4.3/components/input-group/" target="_blank">bootstrap input
                  groups documentations</a></p>
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
        <!-- Page level plugins -->
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">

        <!-- Page level custom scripts -->
        <script>
            $(document).ready(function () {
                $('#dataTableHover').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            text: '<i class="fas fa-copy fa-sm"></i>',
                            titleAttr: 'Copy',
                        },
                        {
                            extend: 'csv',
                            text: '<i class="fas fa-file-csv"></i>',
                            titleAttr: 'CSV',
                        },
                        {
                            extend: 'excel',
                            text: '<i class="fas fa-file-excel"></i>',
                            titleAttr: 'Excel',
                        },
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LEGAL',
                            text: '<i class="fas fa-file-pdf"></i>',
                            titleAttr: 'PDF',
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print"></i>',
                            titleAttr: 'Print',
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fas fa-eye-slash"></i>',
                            titleAttr: 'Column Visibility',
                        },
                    ],
                });

                $('#filterButton').click(function () {
                    // Get selected values from dropdowns
                    var reason = $('#reason').val();
                    var vehicleType = $('#vehicle_type').val();
                    var vehicleOwnership = $('#vehicle_ownership').val();
                    var province = $('#province').val();
                    var district = $('#district').val();

                    // Make AJAX request to fetch filtered records
                    $.ajax({
                        url: './Includes/filter_records.php', // Replace with the actual PHP file to handle the filtering
                        type: 'POST',
                        data: {
                            reason: reason,
                            vehicle_type: vehicleType,
                            vehicle_ownership: vehicleOwnership,
                            province: province,
                            district: district
                        },
                        success: function (data) {
                            // Update the table with filtered records
                            $('#dataTableHover tbody').html(data);
                        }
                    });
                });
            });
        </script>

</body>

</html>