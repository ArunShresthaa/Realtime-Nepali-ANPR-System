<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if(isset($_POST['save'])){
    
    $location=$_POST['location'];
    $latitude=$_POST['latitude'];
    $longitude=$_POST['longitude'];
    $device_id=$_POST['device_id'];
   
    $query=mysqli_query($conn,"SELECT * FROM camera WHERE device_id='$device_id'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 

        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Camera Already Exists !</div>";
    }
    else{

        $query=mysqli_query($conn,"INSERT INTO camera(location,device_id,latitude,longitude) VALUES('$location','$device_id','$latitude','$longitude')");
        if ($query) {
            
            echo "<script type = \"text/javascript\">
                    window.location = (\"manageCamera.php\")
                    </script>"; 
        }
        else
        {
            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
        }
  }
}

//---------------------------------------EDIT-------------------------------------------------------------






//--------------------EDIT------------------------------------------------------------

 if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
  {
        $Id= $_GET['Id'];

        $query=mysqli_query($conn,"SELECT * FROM camera WHERE id='$Id'"); 
        $row=mysqli_fetch_array($query);

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){
    
            $location=$_POST['location'];
            $latitude=$_POST['latitude'];
            $longitude=$_POST['longitude'];
            $device_id=$_POST['device_id'];
        
            $query=mysqli_query($conn,"UPDATE camera SET location='$location',device_id='$device_id',latitude='$latitude',longitude='$longitude' WHERE id='$Id'");

            if ($query) {
                
                echo "<script type = \"text/javascript\">
                window.location = (\"manageCamera.php\")
                </script>"; 
            }
            else
            {
                $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
            }
        }
    }


//--------------------------------DELETE------------------------------------------------------------------

  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
  {
        $Id= $_GET['Id'];

        $query = mysqli_query($conn,"DELETE FROM camera WHERE id='$Id'");

        if ($query) {

                echo "<script type = \"text/javascript\">
                window.location = (\"manageCamera.php\")
                </script>";  
        }
        else{

            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
         }
      
  }


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
                        <h1 class="h3 mb-0 text-gray-800">Add Camera</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Camera</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Form Basic -->
                            <div class="card mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Add Camera</h6>
                                    <?php echo $statusMsg; ?>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Location<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="location"
                                                    value="<?php echo $row['location'];?>" id="exampleInputFirstName"
                                                    placeholder="Enter Location">
                                            </div>

                                            <div class="col-xl-6">
                                                <label class="form-control-label">Device Id<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="device_id"
                                                    value="<?php echo $row['device_id'];?>" id="exampleInputFirstName"
                                                    placeholder="Enter Device Id">
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Latitude<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="latitude"
                                                    value="<?php echo $row['latitude'];?>" id="exampleInputFirstName"
                                                    placeholder="Enter Latitude">
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Longitude<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="longitude"
                                                    value="<?php echo $row['longitude'];?>" id="exampleInputFirstName"
                                                    placeholder="Enter Longitude">
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>

                                                <?php
                    if (isset($Id))
                    {
                    ?>
                                                <button type="submit" name="update"
                                                    class="btn btn-warning">Update</button>
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?php
                    } else {           
                    ?>
                                                <button type="submit" name="save" class="btn btn-primary">Save</button>
                                                <?php
                    }         
                    ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Input Group -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">All Records</h6>
                                        </div>
                                        <div class="table-responsive p-3">
                                            <table class="table align-items-center table-flush table-hover"
                                                id="dataTableHover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Camera Id</th>
                                                        <th>Location</th>
                                                        <th>Device Id</th>
                                                        <th>Latitude</th>
                                                        <th>Longitude</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php
                      $query = "SELECT * FROM camera";
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
                                    <td>".$rows['id']."</td>
                                    <td>".$rows['location']."</td>
                                    <td>".$rows['device_id']."</td>
                                    <td>".$rows['latitude']."</td>
                                    <td>".$rows['longitude']."</td>
                                <td><a href='?action=edit&Id=".$rows['id']."'><i class='fas fa-fw fa-edit'></i>Edit</a></td>
                                <td><a href='?action=delete&Id=".$rows['id']."'><i class='fas fa-fw fa-trash'></i>Delete</a></td>
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
        <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script>
            $(document).ready(function () {
                $('#dataTable').DataTable(); // ID From dataTable 
                $('#dataTableHover').DataTable(); // ID From dataTable with Hover
            });
        </script>
</body>

</html>