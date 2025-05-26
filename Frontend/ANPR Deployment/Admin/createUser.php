<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if(isset($_POST['save'])){
    
    $firstName=$_POST['firstName'];
    $lastName=$_POST['lastName'];
    $emailAddress=$_POST['emailAddress'];

    $phoneNo=$_POST['phoneNo'];
    $Role=$_POST['role'];
    $Address=$_POST['address'];
    $Pass=$_POST['password'];
    $Password=md5($Pass);
    $CPass=$_POST['confirmpassword'];
    $CPassword=md5($CPass);


   
    $query=mysqli_query($conn,"select * from users where email ='$emailAddress'");
    $ret=mysqli_fetch_array($query);


    if($ret > 0){ 

        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Email Address Already Exists!</div>";
    }
    else{
      $query=mysqli_query($conn,"select * from users where contact ='$phoneNo'");
      $ret=mysqli_fetch_array($query);  

      if($ret > 0){ 

          $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Phone Number Already Exists!</div>";
      }
      else
      {
        $query=mysqli_query($conn,"INSERT into users(role,firstName,lastName,email,contact,address) 
        value('$Role','$firstName','$lastName','$emailAddress','$phoneNo','$Address')");
        $getID_query=mysqli_query($conn,"select Id from users where email ='$emailAddress'");
        $userid = mysqli_fetch_array($getID_query)['Id'];
        $Cred_query=mysqli_query($conn,"INSERT into credentials(password,userID) 
        value('$Password','$userid')");

        

        if ($query && $getID_query && $Cred_query) {
            // -------------------------------------
                // File Upload Handling
            $profilePicture = $_FILES['profilePicture'];
            $uploadPath = '../img/'; // Specify your upload folder path

            if (!empty($profilePicture['name'])) {
                $uploadFileName = basename("user-".$userid.".png");
                $targetFilePath = $uploadPath . $uploadFileName;
                move_uploaded_file($profilePicture['tmp_name'], $targetFilePath);

            } 
        // -------------------------------------
            
            $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
        }
        else
        {
            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
        }

      }
  }
}

//---------------------------------------EDIT-------------------------------------------------------------






//--------------------EDIT------------------------------------------------------------

 if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
	{
        $Id= $_GET['Id'];

        $query=mysqli_query($conn,"select * from users where Id ='$Id'");
        $row=mysqli_fetch_array($query);

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){
    
            $firstName=$_POST['firstName'];
            $lastName=$_POST['lastName'];
            $emailAddress=$_POST['emailAddress'];

            $phoneNo=$_POST['phoneNo'];
            $Role=$_POST['role'];
            $Address=$_POST['address'];
            $Pass=$_POST['password'];
            $Password=md5($Pass);

    $query=mysqli_query($conn,"update users set role ='$Role' , firstName='$firstName', lastName='$lastName',
    email='$emailAddress', contact='$phoneNo', address = '$Address' where Id='$Id'");

     $Cred_query=mysqli_query($conn,"update credentials set password ='$Password' where Id='$Id'");


            if ($query && $Cred_query) {
                // ----------------------------------------------------------------------------
     // File Upload Handling for Update
    $profilePicture = $_FILES['profilePicture'];
    $uploadPath = '../img/'; // Specify your upload folder path

    if (!empty($profilePicture['name'])) {
        $uploadFileName = basename("user-".$Id.".png");
        $targetFilePath = $uploadPath . $uploadFileName;
        move_uploaded_file($profilePicture['tmp_name'], $targetFilePath);

    } 
// ----------------------------------------------------------------------------
                echo "<script type = \"text/javascript\">
                window.location = (\"createUser.php\")
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

        $Cred_query = mysqli_query($conn,"DELETE FROM credentials WHERE Id='$Id'");
        $query = mysqli_query($conn,"DELETE FROM users WHERE Id='$Id'");

        if ($query && $Cred_query) 
        {
            // Delete profile picture file if it exists
            $FileName = basename("user-".$Id.".png");
            $FilePath = $uploadPath . $uploadFileName;
            if (file_exists($FilePath)) {
                unlink($FilePath);
            }
             echo "<script type = \"text/javascript\">
            window.location = (\"createUser.php\")
            </script>"; 
        }
        else
        {
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



    <script>
        function classArmDropdown(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "ajaxClassArms.php?cid=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
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
                        <h1 class="h3 mb-0 text-gray-800">Create User</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create User</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Form Basic -->
                            <div class="card mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Create User</h6>
                                    <?php echo $statusMsg; ?>
                                    <div id="error-message"></div>
                                </div>
                                <div class="card-body">
                                    <form method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                                        <div class="form-group row mb-3">

                                            <div class="col-xl-6">
                                                <label class="form-control-label">Select Role<span
                                                        class="text-danger ml-2">*</span></label>
                                                <select required name="role" onchange="classArmDropdown(this.value)"
                                                    class="form-control mb-3">
                                                    <option value="">--Select Role--</option>
                                                    <option value="admin" <?php if($row['role']=="admin" )
                                                        {echo " selected" ;}?>>Admin</option>
                                                    <option value="user" <?php if($row['role']=="user" )
                                                        {echo " selected" ;}?>>User</option>
                                                </select>

                                            </div>
                                            <!-- ---------------------------- -->
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Firstname<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="firstName"
                                                    value="<?php echo $row['firstName'];?>" id="exampleInputFirstName">
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Lastname<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="lastName"
                                                    value="<?php echo $row['lastName'];?>" id="exampleInputFirstName">
                                            </div>


                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Email Address<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="email" class="form-control" required name="emailAddress"
                                                    value="<?php echo $row['email'];?>" id="exampleInputFirstName">
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Password<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="password" class="form-control" required name="password"
                                                    id="password">
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Confirm Password<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="password" class="form-control" required
                                                    name="confirmPassword" id="confirmpassword">
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Phone No<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" name="phoneNo"
                                                    value="<?php echo $row['contact'];?>" id="exampleInputFirstName">
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Address<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="address"
                                                    value="<?php echo $row['address'];?>" id="exampleInputFirstName">
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Profile Picture</label>
                                                <input type="file" class="form-control" name="profilePicture"
                                                    accept="image/*">
                                                <small class="text-muted">Only PNG files are allowed.</small>
                                            </div>
                                        </div>

                                        <?php
                    if (isset($Id))
                    {
                    ?>
                                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php
                    } else {           
                    ?>
                                        <button type="submit" name="save" class="btn btn-primary">Save</button>
                                        <?php
                    }         
                    ?>
                                    </form>
                                </div>
                            </div>

                            <!-- Input Group -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">All Class Teachers</h6>
                                        </div>
                                        <div class="table-responsive p-3">
                                            <table class="table align-items-center table-flush table-hover"
                                                id="dataTableHover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>User ID</th>
                                                        <th>Role</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Email Address</th>
                                                        <th>Phone No</th>
                                                        <th>Address</th>
                                                        <th>Date Created</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php
                      $query = "SELECT * FROM users";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      $status="";
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             $sn = $sn + 1;
                            echo"
                              <tr>
                                <td>".$sn."</td>
                                <td>".$rows['Id']."</td>
                                <td>".$rows['role']."</td>
                                <td>".$rows['firstName']."</td>
                                <td>".$rows['lastName']."</td>
                                <td>".$rows['email']."</td>
                                <td>".$rows['contact']."</td>
                                <td>".$rows['address']."</td>
                                 <td>".$rows['created_at']."</td>
                                 <td><a href='?action=edit&Id=".$rows['Id']."'><i class='fas fa-fw fa-edit'></i></a></td>";

                                 if($rows['Id'] != $_SESSION['userId'])
                                 {
                                    echo "<td><a href='?action=delete&Id=".$rows['Id']."'><i class='fas fa-fw fa-trash'></i></a></td>";
                              
                                 }
                                 echo "</tr>";  
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

        <script>
            function validateForm() {
                var password = document.getElementById("password").value;
                var confirmPassword = document.getElementById("confirmpassword").value;

                if (password !== confirmPassword) {
                    // Display error message on the page
                    var errorDiv = document.getElementById("error-message");
                    errorDiv.innerHTML = "<div class='alert alert-danger'>Passwords do not match.</div>";

                    // Highlight the input fields or take other visual actions if needed

                    return false;
                }

                // Clear any previous error messages
                var errorDiv = document.getElementById("error-message");
                errorDiv.innerHTML = "";

                return true;
            }

        </script>
</body>

</html>