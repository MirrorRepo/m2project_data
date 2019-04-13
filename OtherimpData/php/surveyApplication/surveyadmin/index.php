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
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

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
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
     
     <li class="nav-item">
        <a class="nav-link" href="SmsEmailTriggerModule/index.php">
          <i class="fas fa-fw fa-chart-area"></i>
            <span>Survey Data Management</span></a>
      </li>
     
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">

          <div class="col-xl-6 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5"></div>
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

        <!-- Area Chart Example-->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Area Chart Example</div>
          <div class="card-body">
          <div style="height: 300px">
            <canvas id="myAreaChart" width="100%" height="35"></canvas>
          </div>
          </div>


          <div class="card-body">
          <div style="height: 300px">
            <canvas id="myAreaChartpromotortsnetudetr" width="100%" height="35"></canvas>
              </div>
          </div>


          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

        <!-- DataTables Example -->
        <?php 

        include_once 'config.php'; 

        $survey_record_query = "select * from survey_records";
        $result = mysqli_query($db,$survey_record_query);

        ?>
        <style type="text/css">
       .table-bordered thead tr th ,.table-bordered tfoot tr th   {    font-size: 18px;
    text-transform: lowercase;
    font-weight: normal;}
   </style>


 <div class="card mb-3 ">
          <div class="card-header">
           <i class="fas fa-table"></i>
            Export Survey Records</div>
            <div class="card-body">
          <div class="row">
           
           <form method="post" action="export.php" style="width: 100%">
       <div class="col-sm-12 col-md-6"> 


       <label for="start">Select Date:</label><i class="fa fa-calendar fa-2x" aria-hidden="true"></i>

<!-- <input type="date" id="start" name="trip-start" onchange="getObject(this);" > -->

  <input type="date" id="start" name="date" >

  <input type="submit" class="btn btn-info" value="Submit Button">
</div>

</form>
<br>
</div>
</div>
</div>



 <div class="card mb-3 ">
          <div class="card-header">
           <i class="fas fa-table"></i>
            Export Imported Survey Records From csv</div>
            <div class="card-body">
          <div class="row">
           
           <form method="post" action="export.php" style="width: 100%">
       <div class="col-sm-12 col-md-6"> 


       <label for="start">Select Date:</label><i class="fa fa-calendar fa-2x" aria-hidden="true"></i>

<!-- <input type="date" id="start" name="trip-start" onchange="getObject(this);" > -->
  <input type="hidden" id="typeeisr" name="type" value="eisr">
  <input type="date" id="start" name="date" >

  <input type="submit" class="btn btn-info" value="Submit Button">
</div>

</form>
<br>
</div>
</div>
</div>


 <!-- <form method="post" action="export.php" style="width: 100%">
      <div class="col-sm-12 col-md-6"> <label for="start">Select Month:</label><i class="fa fa-calendar fa-2x" aria-hidden="true"></i> <input type="month" id="start" name="start"
       min="2018-03" value="2018-05"></div></div>
</form> -->

        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Submitted Survey Records</div>
          <div class="card-body">
            <div class="table-responsive">
         
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>HOW SATISFIED ARE YOU WITH THE INTERACTION WITH CLUB FACTORY SUPPORT
</th>
                    <th>WHICH OF OUR SERVICES WOULD YOU LIKE TO IMPROVE
</th>
                    <th>WHAT COULD THE SUPPORT EXECUTIVE HAVE DONE BETTER IN YOUR INTERACTION WITH CLUB FACTORY SUPPORT 
</th>
                    <th>PLEASE LET US KNOW HOW WE CAN BECOME BETTER AT OUR OFFERINGS
</th>
                    <th>Survey Date</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>HOW SATISFIED ARE YOU WITH THE INTERACTION WITH CLUB FACTORY SUPPORT
</th>
                    <th>WHICH OF OUR SERVICES WOULD YOU LIKE TO IMPROVE
</th>
                    <th>WHAT COULD THE SUPPORT EXECUTIVE HAVE DONE BETTER IN YOUR INTERACTION WITH CLUB FACTORY SUPPORT
</th>
                    <th>PLEASE LET US KNOW HOW WE CAN BECOME BETTER AT OUR OFFERINGS
</th>
                    <th>Survey Date</th>
                  </tr>
                </tfoot>
                <tbody>
                 <?php

       if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) { ?>

             <tr>
                    <td>
                      <?php 
switch ($row["q1"]) {
         case 1:
echo "<i class='fa fa-frown-o' style='font-size:48px;color:darkred'></i>";
          break;

         case 2:
echo "<i class='fa fa-frown-o' style='font-size:48px;color:red'></i>";
          break;

         case 3:
echo "<i class='fa fa-smile-o' style='font-size:48px;color:yellow'></i>";
          break;

         case 4:
echo "<i class='fa fa-smile-o' style='font-size:48px;color:green'></i>";
          break;

         case 5:
echo "<i class='fa fa-smile-o' style='font-size:48px;color:limegreen'></i>";
          break;

}
                      ?>

                    </td>


                    <td><?php echo $row["q2"]?></td>
                    <td><?php echo $row["q3"]?>
                      <?php if($row["q3other"]){ ?>
                    <br>
                      <?php echo "<strong>Other:</strong> ".$row["q3other"]?> 
<?php } ?>
                    </td>
                    <td><?php echo $row["q4"]?>

                    </td>
                    <td><?php echo date("d-m-Y", strtotime($row["date"]));
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


<?php 
/*
* calculting % of vote
*/


$survey_record_query1 = "SELECT * FROM survey_records WHERE MONTH(date) = MONTH(CURRENT_DATE());";
$result = mysqli_query($db,$survey_record_query1);
$monthTotRecord = $result->num_rows;


/*
* rating 1
*/

$rating_record_query2 = "SELECT * FROM survey_records WHERE MONTH(date) = MONTH(CURRENT_DATE()) and q1 = 1;";
$ratingResult1 = mysqli_query($db,$rating_record_query2);

$ratingRecord1 = $ratingResult1->num_rows;
$ratingRecord1 = round($monthTotRecord/$ratingRecord1);


/*
* rating 2
*/

$rating_record_query3 = "SELECT * FROM survey_records WHERE MONTH(date) = MONTH(CURRENT_DATE()) and q1 = 1;";
$ratingResult2 = mysqli_query($db,$rating_record_query3);

$ratingRecord2 = $ratingResult2->num_rows;
$ratingRecord2 = round($monthTotRecord/$ratingRecord2);

/*
* rating 3
*/

$rating_record_query4 = "SELECT * FROM survey_records WHERE MONTH(date) = MONTH(CURRENT_DATE()) and q1 = 3;";
$ratingResult3 = mysqli_query($db,$rating_record_query4);

$ratingRecord3 = $ratingResult3->num_rows;
$ratingRecord3 = round($monthTotRecord/$ratingRecord3);

/*
* rating 4
*/

$rating_record_query4 = "SELECT * FROM survey_records WHERE MONTH(date) = MONTH(CURRENT_DATE()) and q1 = 4;";
$ratingResult4 = mysqli_query($db,$rating_record_query4);

$ratingRecord4 = $ratingResult4->num_rows;
$ratingRecord4 = round($monthTotRecord/$ratingRecord4);

/*
* rating 5
*/

$rating_record_query5 = "SELECT * FROM survey_records WHERE MONTH(date) = MONTH(CURRENT_DATE()) and q1 = 5;";
$ratingResult5 = mysqli_query($db,$rating_record_query5);

$ratingRecord5 = $ratingResult5->num_rows;
$ratingRecord5 = round($monthTotRecord/$ratingRecord5);

$ratingArrayVal = [$ratingRecord1, $ratingRecord2, $ratingRecord3, $ratingRecord4, $ratingRecord5];

$rating_keys = '["' . implode('", "', array_values($ratingArrayVal) ) . '"]';




/********************************/
/**promotor, Neutral, Detractor calclation **********/

$rating_record_query45 = "SELECT * FROM survey_records WHERE MONTH(date) = MONTH(CURRENT_DATE()) and q1 = 5 || q1 = 4;";
$ratingResult45 = mysqli_query($db,$rating_record_query45);

$ratingRecord45 = $ratingResult45->num_rows;
$ratingRecord45 = round($monthTotRecord/$ratingRecord45);




$rating_record_querypn3 = "SELECT * FROM survey_records WHERE MONTH(date) = MONTH(CURRENT_DATE()) and q1 = 3";
$ratingResultpn3 = mysqli_query($db,$rating_record_querypn3);

$ratingRecordpn3 = $ratingResultpn3->num_rows;
$ratingRecordpn3 = round($monthTotRecord/$ratingRecordpn3);



$rating_record_query12 = "SELECT * FROM survey_records WHERE MONTH(date) = MONTH(CURRENT_DATE()) and q1 = 1 || q1 = 2;";
$ratingResult12 = mysqli_query($db,$rating_record_query12);

$ratingRecord12 = $ratingResult12->num_rows;
$ratingRecord12 = round($monthTotRecord/$ratingRecord12);


$ratingdpnArrayVal = [$ratingRecord45, $ratingRecordpn3, $ratingRecord12];

$rating_keys_dpn = '["' . implode('", "', array_values($ratingdpnArrayVal) ) . '"]';


?>




<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>
<script type="text/javascript">

var getDaysInMonth = function(month,year) {

 return new Date(year, month, 0).getDate();

};


var now = new Date()
months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
var firstformattedDate = now.getDate() + "-" + months[now.getMonth()] + "-" + now.getFullYear();

$totDays = getDaysInMonth(now.getMonth(), now.getFullYear());

var lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);

var lastformattedDate = lastDay.getDate() + "-" + months[lastDay.getMonth()] + "-" + lastDay.getFullYear();

var i;
var daysnum = [];
for (i = 1; i < $totDays; i++) {
  daysnum.push( months[now.getMonth()] + ","+i);
}
var labels = daysnum;

//bar
  var ctxB = document.getElementById("myAreaChart").getContext('2d');
  var allRatingData = <?php echo $rating_keys ;?>;

  var allRatingDataDpn = <?php echo $rating_keys_dpn ;?>;

  var myBarChart = new Chart(ctxB, {
    type: 'bar',
    data: {
      labels: ["1", "2", "3", "4", "5"],
      datasets: [{
        label: months[now.getMonth()] + "-" + now.getFullYear() + ' Average Votes Percentage Graph',
        data: allRatingData,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
          responsive: true,
            maintainAspectRatio: false,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });


  var ctxB = document.getElementById("myAreaChartpromotortsnetudetr").getContext('2d');
  var myBarChart = new Chart(ctxB, {
    type: 'bar',
    data: {
      labels: ["Promoter", "Neutral", "Detractor"],
      datasets: [{
        label: '# Promoter,Neutral and Detractor Votes Graph',
        data: allRatingDataDpn,
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
        responsive: true,
            maintainAspectRatio: false,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });

  // Basic example
$(document).ready(function () {
  $('#dataTableisr').DataTable({
    "pagingType": "full_numbers" // "simple" option for 'Previous' and 'Next' buttons only
  });
  $('.dataTables_length').addClass('bs-select');
});
  

function getObject(object)
{

    $(".wait").css("display", "block");
 

  console.log(object.value);
  var dateval = object.value;
   $.ajax({
            url: "export.php",
            data:{'date': dateval },
            type: "POST",
            success:function(data){
                $(".wait").css("display", "none");
                $("#mail-status").html(data);
            },
            error:function (){}
        });

}
</script>
</body>

</html>
