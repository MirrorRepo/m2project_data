<?php session_start(); ?>
<?php 
if(!isset($_SESSION['username'])){

 header('location: login.php');
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

  <title>SB Admin - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.html">Start Bootstrap</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
       
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
          <span class="badge badge-danger">9+</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-envelope fa-fw"></i>
          <span class="badge badge-danger">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="#">Activity Log</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="../index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>

     
 <li class="nav-item dropdown active">
           <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Survey Data Management</span></a>
             <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <a class="dropdown-item" href="import.php">Import</a>
          <a class="dropdown-item" href="triggersmsandemail.php">Trigger Sms and Email</a>
       
         
        </div>
      </li>
     
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
         
        </ol>

       <!-- Breadcrumbs-->
        <ol class="breadcrumb">
        <?php if(isset($_SESSION['record_sucess_import'])):?>
     <li class="breadcrumb-item">
          <span style="color: green"><?php echo  $_SESSION['record_sucess_import'];?></span>
      </li>
<?php endif;?> 


        <?php if(isset($_SESSION['sms_email_triggered'])):?>
     <li class="breadcrumb-item">
          <span style="color: green"><?php echo  $_SESSION['sms_email_triggered'];?></span>
      </li>
<?php endif;?> 


        </ol>


        </ol>


        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">26 New Messages!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
       
          
        </div>

       

        <!-- DataTables Example -->
        <?php 

        include_once '../config.php'; 

        $survey_record_query = "select * from survey_records";
        $result = mysqli_query($db,$survey_record_query);

        ?>
        <style type="text/css">
       .table-bordered thead tr th ,.table-bordered tfoot tr th   {    font-size: 18px;
    text-transform: lowercase;
    font-weight: normal;}

        </style>
       


         <!--imported survey data-->

          <?php 

        $survey_record_query = "select * from survey_input_import";
        $result = mysqli_query($db,$survey_record_query);

        ?>
        <style type="text/css">
       .table-bordered thead tr th ,.table-bordered tfoot tr th   {    font-size: 18px;
    text-transform: lowercase;
    font-weight: normal;}

        </style>
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Imported Survey Records</div>
          <div class="card-body">
            <div class="table-responsive">
         
              <table class="table table-bordered" id="dataTableisr" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>USERNAME
</th>
                    <th>PHONE
</th>
                    <th>EMAIL
</th>
                    <th>IMPORTED DATE</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>USERNAME
</th>
                    <th>PHONE
</th>
                    <th>EMAIL
</th>
                    <th>IMPORTED DATE</th>
                  </tr>
                </tfoot>
                <tbody>
                 <?php

       if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) { ?>

             <tr>
                    <td><?php echo $row["name"]?></td>
                    <td><?php echo $row["phone"]?>
                     
                    <td><?php echo $row["email"]?>

                    </td>
                    <td><?php echo date("d-m-Y", strtotime($row["created_at"]));
                    ?></td>
                  </tr>
     <?php    }
       } 
                 ?>
                 
                 
                 
                </tbody>
              </table>
            </div>
          </div>



          <div class="card-footer small text-muted"></div>
        </div>

           <!--imported survey data-->



      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>
<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="../js/demo/datatables-demo.js"></script>
  <script src="../js/demo/chart-area-demo.js"></script>
<script type="text/javascript">
  // Basic example
$(document).ready(function () {
  $('#dataTableisr').DataTable({
    "pagingType": "full_numbers" // "simple" option for 'Previous' and 'Next' buttons only
  });
  $('.dataTables_length').addClass('bs-select');
});
  
</script>
</body>

</html>
