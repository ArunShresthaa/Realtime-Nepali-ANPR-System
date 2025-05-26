<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if(isset($_POST['save'])){
    
    $plate_no=$_POST['plate_no'];
    $reason=$_POST['reason'];
    $vehicle_type=$_POST['vehicle_type'];
    $vehicle_ownership=$_POST['vehicle_ownership'];
    $province=$_POST['province'];
    $district=$_POST['district'];
    $location=$_POST['location'];
    $description=$_POST['description'];
    $remarks=$_POST['remarks'];
   
    $query=mysqli_query($conn,"select * from bolo inner join records on bolo.record_id = records.Id where plate_no ='$plate_no'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 

        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This plate Already Exists in BOLO List!</div>";
    }
    else{

        $query=mysqli_query($conn,"insert into records values(DEFAULT,'$plate_no','$reason','$vehicle_type','$vehicle_ownership','$province','$district','$location','$description','$remarks',DEFAULT,DEFAULT)");
        $query1=mysqli_query($conn,"SET @last_record_id = LAST_INSERT_ID()");
        $query2=mysqli_query($conn,"insert into bolo(record_id) values(@last_record_id)");
    if ($query && $query1 && $query2) {
        
        echo "<script type = \"text/javascript\">
                window.location = (\"createRecords.php\")
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

        $query=mysqli_query($conn,"select * from records where Id ='$Id'"); 
        $row=mysqli_fetch_array($query);

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){
    
            $plate_no=$_POST['plate_no'];
            $reason=$_POST['reason'];
            $vehicle_type=$_POST['vehicle_type'];
            $vehicle_ownership=$_POST['vehicle_ownership'];
            $province=$_POST['province'];
            $district=$_POST['district'];
            $location=$_POST['location'];
            $description=$_POST['description'];
            $remarks=$_POST['remarks'];
        
            $query=mysqli_query($conn,"UPDATE records SET plate_no='$plate_no',reason='$reason',vehicle_type='$vehicle_type',vehicle_ownership='$vehicle_ownership',province='$province',district='$district',location='$location',description='$description',remarks='$remarks' WHERE Id='$Id'");

            if ($query) {
                
                echo "<script type = \"text/javascript\">
                window.location = (\"createRecords.php\")
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

        $hitlogs_query = mysqli_query($conn,"DELETE hitlogs FROM hitlogs INNER JOIN bolo ON hitlogs.record_id = bolo.id INNER JOIN records ON bolo.record_id = records.Id WHERE records.Id='$Id'");
        $bolo_query = mysqli_query($conn,"DELETE bolo FROM bolo INNER JOIN records ON bolo.record_id = records.Id WHERE records.Id='$Id'");
        $query = mysqli_query($conn,"DELETE FROM records WHERE Id='$Id'");

        if ($query && $hitlogs_query && $bolo_query) {

                echo "<script type = \"text/javascript\">
                window.location = (\"createRecords.php\")
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
                        <h1 class="h3 mb-0 text-gray-800">Add Plate</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Plate</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Form Basic -->
                            <div class="card mb-4">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Add Plate</h6>
                                    <?php echo $statusMsg; ?>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Enter Plate<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="plate_no"
                                                    value="<?php echo $row['plate_no'];?>" id="exampleInputFirstName"
                                                    placeholder="Enter Plate">
                                            </div>
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

                                                <label class="form-control-label">Reason<span
                                                        class="text-danger ml-2">*</span></label>
                                                <select class="form-control" required name="reason" id="reason">
                                                    <option value="" <?php echo empty($row['reason']) ? 'selected' : ''
                                                        ; ?>>-- Select Reason --</option>
                                                    <?php
                                                        foreach ($reasons as $reason) {
                                                            echo "<option value='".$reason['name']."'";
                                                            if ($row['reason'] == $reason['name']) {
                                                                echo " selected";
                                                            }
                                                            echo ">".$reason['name']."</option>";
                                                        }
                                                    ?>
                                                </select>
                                                <span class="error">
                                                    <?php echo isset($errors['reason']) ? $errors['reason'] : ''; ?>
                                                </span>


                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Vehicle Type<span
                                                        class="text-danger ml-2">*</span></label>
                                                <select class="form-control" required name="vehicle_type"
                                                    id="vehicle_type">
                                                    <option value="">--Select Role--</option>
                                                    <option value="bike" <?php if($row['vehicle_type']=="bike" )
                                                        {echo " selected" ;}?>>Bike</option>
                                                    <option value="car" <?php if($row['vehicle_type']=="car" )
                                                        {echo " selected" ;}?>>Car</option>
                                                    <option value="bus" <?php if($row['vehicle_type']=="bus" )
                                                        {echo " selected" ;}?>>Bus</option>
                                                    <option value="truck" <?php if($row['vehicle_type']=="truck" )
                                                        {echo " selected" ;}?>>Truck</option>
                                                </select>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Vehicle Ownership<span
                                                        class="text-danger ml-2">*</span></label>
                                                <select class="form-control" required name="vehicle_ownership"
                                                    id="vehicle_ownership">
                                                    <option value="">--Select Role--</option>
                                                    <option value="private" <?php
                                                        if($row['vehicle_ownership']=="private" ) {echo " selected" ;}?>
                                                        >Private</option>
                                                    <option value="public" <?php if($row['vehicle_ownership']=="public"
                                                        ) {echo " selected" ;}?>>Public</option>
                                                    <option value="government" <?php
                                                        if($row['vehicle_ownership']=="government" ) {echo " selected"
                                                        ;}?>>Government</option>
                                                    <option value="diplomatic" <?php
                                                        if($row['vehicle_ownership']=="diplomatic" ) {echo " selected"
                                                        ;}?>>Diplomatic</option>
                                                    <option value="tourist" <?php
                                                        if($row['vehicle_ownership']=="tourist" ) {echo " selected" ;}?>
                                                        >Tourist</option>
                                                    <option value="corporation" <?php
                                                        if($row['vehicle_ownership']=="corporation" ) {echo " selected"
                                                        ;}?>>Corporation</option>
                                                </select>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Province<span
                                                        class="text-danger ml-2">*</span></label>
                                                <select class="form-control" required name="province" id="province">
                                                    <option value="">--Select Role--</option>
                                                    <option value="bagmati" <?php if($row['province']=="bagmati" )
                                                        {echo " selected" ;}?>>Bagmati</option>
                                                    <option value="madesh" <?php if($row['province']=="madesh" )
                                                        {echo " selected" ;}?>>Madesh</option>
                                                    <option value="koshi" <?php if($row['province']=="koshi" )
                                                        {echo " selected" ;}?>>Koshi</option>
                                                    <option value="gandaki" <?php if($row['province']=="gandaki" )
                                                        {echo " selected" ;}?>>Gandaki</option>
                                                    <option value="lumbini" <?php if($row['province']=="lumbini" )
                                                        {echo " selected" ;}?>>Lumbini</option>
                                                    <option value="karnali" <?php if($row['province']=="karnali" )
                                                        {echo " selected" ;}?>>Karnali</option>
                                                    <option value="sudurpashchim" <?php
                                                        if($row['province']=="sudurpashchim" ) {echo " selected" ;}?>
                                                        >Sudurpashchim</option>
                                                </select>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">District<span
                                                        class="text-danger ml-2">*</span></label>
                                                <select class="form-control" required name="district" id="district">
                                                    <option value="">--Select Role--</option>
                                                    <option value="achham" <?php if($row['district']=="achham" )
                                                        {echo " selected" ;} ?>>Achham</option>
                                                    <option value="arghakhanchi" <?php
                                                        if($row['district']=="arghakhanchi" ) {echo " selected" ;} ?>
                                                        >Arghakhanchi</option>
                                                    <option value="baglung" <?php if($row['district']=="baglung" )
                                                        {echo " selected" ;} ?>>Baglung</option>
                                                    <option value="baitadi" <?php if($row['district']=="baitadi" )
                                                        {echo " selected" ;} ?>>Baitadi</option>
                                                    <option value="bajhang" <?php if($row['district']=="bajhang" )
                                                        {echo " selected" ;} ?>>Bajhang</option>
                                                    <option value="bajura" <?php if($row['district']=="bajura" )
                                                        {echo " selected" ;} ?>>Bajura</option>
                                                    <option value="banke" <?php if($row['district']=="banke" )
                                                        {echo " selected" ;} ?>>Banke</option>
                                                    <option value="bara" <?php if($row['district']=="bara" )
                                                        {echo " selected" ;} ?>>Bara</option>
                                                    <option value="bardiya" <?php if($row['district']=="bardiya" )
                                                        {echo " selected" ;} ?>>Bardiya</option>
                                                    <option value="bhaktapur" <?php if($row['district']=="bhaktapur" )
                                                        {echo " selected" ;} ?>>Bhaktapur</option>
                                                    <option value="bhojpur" <?php if($row['district']=="bhojpur" )
                                                        {echo " selected" ;} ?>>Bhojpur</option>
                                                    <option value="chitwan" <?php if($row['district']=="chitwan" )
                                                        {echo " selected" ;} ?>>Chitwan</option>
                                                    <option value="dadeldhura" <?php if($row['district']=="dadeldhura" )
                                                        {echo " selected" ;} ?>>Dadeldhura</option>
                                                    <option value="dailekh" <?php if($row['district']=="dailekh" )
                                                        {echo " selected" ;} ?>>Dailekh</option>
                                                    <option value="dang" <?php if($row['district']=="dang" )
                                                        {echo " selected" ;} ?>>Dang</option>
                                                    <option value="darchula" <?php if($row['district']=="darchula" )
                                                        {echo " selected" ;} ?>>Darchula</option>
                                                    <option value="dhading" <?php if($row['district']=="dhading" )
                                                        {echo " selected" ;} ?>>Dhading</option>
                                                    <option value="dhankuta" <?php if($row['district']=="dhankuta" )
                                                        {echo " selected" ;} ?>>Dhankuta</option>
                                                    <option value="dhanusa" <?php if($row['district']=="dhanusa" )
                                                        {echo " selected" ;} ?>>Dhanusa</option>
                                                    <option value="dholkha" <?php if($row['district']=="dholkha" )
                                                        {echo " selected" ;} ?>>Dholkha</option>
                                                    <option value="dolpa" <?php if($row['district']=="dolpa" )
                                                        {echo " selected" ;} ?>>Dolpa</option>
                                                    <option value="doti" <?php if($row['district']=="doti" )
                                                        {echo " selected" ;} ?>>Doti</option>
                                                    <option value="eastern rukum" <?php
                                                        if($row['district']=="eastern rukum" ) {echo " selected" ;} ?>
                                                        >Eastern Rukum</option>
                                                    <option value="gorkha" <?php if($row['district']=="gorkha" )
                                                        {echo " selected" ;} ?>>Gorkha</option>
                                                    <option value="gulmi" <?php if($row['district']=="gulmi" )
                                                        {echo " selected" ;} ?>>Gulmi</option>
                                                    <option value="humla" <?php if($row['district']=="humla" )
                                                        {echo " selected" ;} ?>>Humla</option>
                                                    <option value="ilam" <?php if($row['district']=="ilam" )
                                                        {echo " selected" ;} ?>>Ilam</option>
                                                    <option value="jajarkot" <?php if($row['district']=="jajarkot" )
                                                        {echo " selected" ;} ?>>Jajarkot</option>
                                                    <option value="jhapa" <?php if($row['district']=="jhapa" )
                                                        {echo " selected" ;} ?>>Jhapa</option>
                                                    <option value="jumla" <?php if($row['district']=="jumla" )
                                                        {echo " selected" ;} ?>>Jumla</option>
                                                    <option value="kailali" <?php if($row['district']=="kailali" )
                                                        {echo " selected" ;} ?>>Kailali</option>
                                                    <option value="kalikot" <?php if($row['district']=="kalikot" )
                                                        {echo " selected" ;} ?>>Kalikot</option>
                                                    <option value="kanchanpur" <?php if($row['district']=="kanchanpur" )
                                                        {echo " selected" ;} ?>>Kanchanpur</option>
                                                    <option value="kapilvastu" <?php if($row['district']=="kapilvastu" )
                                                        {echo " selected" ;} ?>>Kapilvastu</option>
                                                    <option value="kaski" <?php if($row['district']=="kaski" )
                                                        {echo " selected" ;} ?>>Kaski</option>
                                                    <option value="kathmandu" <?php if($row['district']=="kathmandu" )
                                                        {echo " selected" ;} ?>>Kathmandu</option>
                                                    <option value="kavrepalanchok" <?php
                                                        if($row['district']=="kavrepalanchok" ) {echo " selected" ;} ?>
                                                        >Kavrepalanchok</option>
                                                    <option value="khotang" <?php if($row['district']=="khotang" )
                                                        {echo " selected" ;} ?>>Khotang</option>
                                                    <option value="lalitpur" <?php if($row['district']=="lalitpur" )
                                                        {echo " selected" ;} ?>>Lalitpur</option>
                                                    <option value="lamjung" <?php if($row['district']=="lamjung" )
                                                        {echo " selected" ;} ?>>Lamjung</option>
                                                    <option value="mahottari" <?php if($row['district']=="mahottari" )
                                                        {echo " selected" ;} ?>>Mahottari</option>
                                                    <option value="makwanpur" <?php if($row['district']=="makwanpur" )
                                                        {echo " selected" ;} ?>>Makwanpur</option>
                                                    <option value="manang" <?php if($row['district']=="manang" )
                                                        {echo " selected" ;} ?>>Manang</option>
                                                    <option value="morang" <?php if($row['district']=="morang" )
                                                        {echo " selected" ;} ?>>Morang</option>
                                                    <option value="mugu" <?php if($row['district']=="mugu" )
                                                        {echo " selected" ;} ?>>Mugu</option>
                                                    <option value="mustang" <?php if($row['district']=="mustang" )
                                                        {echo " selected" ;} ?>>Mustang</option>
                                                    <option value="myagdi" <?php if($row['district']=="myagdi" )
                                                        {echo " selected" ;} ?>>Myagdi</option>
                                                    <option value="nawalparasi" <?php if($row['district']=="nawalparasi"
                                                        ) {echo " selected" ;} ?>>Nawalparasi</option>
                                                    <option value="nuwakot" <?php if($row['district']=="nuwakot" )
                                                        {echo " selected" ;} ?>>Nuwakot</option>
                                                    <option value="okhaldhunga" <?php if($row['district']=="okhaldhunga"
                                                        ) {echo " selected" ;} ?>>Okhaldhunga</option>
                                                    <option value="palpa" <?php if($row['district']=="palpa" )
                                                        {echo " selected" ;} ?>>Palpa</option>
                                                    <option value="panchthar" <?php if($row['district']=="panchthar" )
                                                        {echo " selected" ;} ?>>Panchthar</option>
                                                    <option value="parbat" <?php if($row['district']=="parbat" )
                                                        {echo " selected" ;} ?>>Parbat</option>
                                                    <option value="parsa" <?php if($row['district']=="parsa" )
                                                        {echo " selected" ;} ?>>Parsa</option>
                                                    <option value="pyuthan" <?php if($row['district']=="pyuthan" )
                                                        {echo " selected" ;} ?>>Pyuthan</option>
                                                    <option value="ramechhap" <?php if($row['district']=="ramechhap" )
                                                        {echo " selected" ;} ?>>Ramechhap</option>
                                                    <option value="rasuwa" <?php if($row['district']=="rasuwa" )
                                                        {echo " selected" ;} ?>>Rasuwa</option>
                                                    <option value="rautahat" <?php if($row['district']=="rautahat" )
                                                        {echo " selected" ;} ?>>Rautahat</option>
                                                    <option value="rolpa" <?php if($row['district']=="rolpa" )
                                                        {echo " selected" ;} ?>>Rolpa</option>
                                                    <option value="rukum" <?php if($row['district']=="rukum" )
                                                        {echo " selected" ;} ?>>Rukum</option>
                                                    <option value="rupandehi" <?php if($row['district']=="rupandehi" )
                                                        {echo " selected" ;} ?>>Rupandehi</option>
                                                    <option value="salyan" <?php if($row['district']=="salyan" )
                                                        {echo " selected" ;} ?>>Salyan</option>
                                                    <option value="sankhuwasabha" <?php
                                                        if($row['district']=="sankhuwasabha" ) {echo " selected" ;} ?>
                                                        >Sankhuwasabha</option>
                                                    <option value="saptari" <?php if($row['district']=="saptari" )
                                                        {echo " selected" ;} ?>>Saptari</option>
                                                    <option value="sarlahi" <?php if($row['district']=="sarlahi" )
                                                        {echo " selected" ;} ?>>Sarlahi</option>
                                                    <option value="sindhuli" <?php if($row['district']=="sindhuli" )
                                                        {echo " selected" ;} ?>>Sindhuli</option>
                                                    <option value="sindhupalchok" <?php
                                                        if($row['district']=="sindhupalchok" ) {echo " selected" ;} ?>
                                                        >Sindhupalchok</option>
                                                    <option value="siraha" <?php if($row['district']=="siraha" )
                                                        {echo " selected" ;} ?>>Siraha</option>
                                                    <option value="solukhumbu" <?php if($row['district']=="solukhumbu" )
                                                        {echo " selected" ;} ?>>Solukhumbu</option>
                                                    <option value="sunsari" <?php if($row['district']=="sunsari" )
                                                        {echo " selected" ;} ?>>Sunsari</option>
                                                    <option value="surkhet" <?php if($row['district']=="surkhet" )
                                                        {echo " selected" ;} ?>>Surkhet</option>
                                                    <option value="syangja" <?php if($row['district']=="syangja" )
                                                        {echo " selected" ;} ?>>Syangja</option>
                                                    <option value="tanahu" <?php if($row['district']=="tanahu" )
                                                        {echo " selected" ;} ?>>Tanahu</option>
                                                    <option value="taplejung" <?php if($row['district']=="taplejung" )
                                                        {echo " selected" ;} ?>>Taplejung</option>
                                                    <option value="terhathum" <?php if($row['district']=="terhathum" )
                                                        {echo " selected" ;} ?>>Terhathum</option>
                                                    <option value="udayapur" <?php if($row['district']=="udayapur" )
                                                        {echo " selected" ;} ?>>Udayapur</option>
                                                    <option value="western rukum" <?php
                                                        if($row['district']=="western rukum" ) {echo " selected" ;} ?>
                                                        >Western Rukum</option>
                                                </select>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Location<span
                                                        class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" required name="location"
                                                    value="<?php echo $row['location'];?>" id="exampleInputFirstName"
                                                    placeholder="Enter Location">
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Description</label>
                                                <input type="text" class="form-control" name="description"
                                                    value="<?php echo $row['description'];?>" id="exampleInputFirstName"
                                                    placeholder="Enter Description">
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="mb-2"></div>
                                                <label class="form-control-label">Remarks</label>
                                                <input type="text" class="form-control" name="remarks"
                                                    value="<?php echo $row['remarks'];?>" id="exampleInputFirstName"
                                                    placeholder="Enter Remarks">
                                            </div>

                                            <div class="col-xl-6"></div>
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
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php
                      $query = "SELECT records.* FROM bolo INNER JOIN records ON bolo.record_id = records.Id";
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
                                <td><a href='?action=edit&Id=".$rows['Id']."'><i class='fas fa-fw fa-edit'></i>Edit</a></td>
                                <td><a href='?action=delete&Id=".$rows['Id']."'><i class='fas fa-fw fa-trash'></i>Delete</a></td>
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