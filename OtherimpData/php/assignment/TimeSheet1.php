

<!DOCTYPE html>
<html>
<head>
    <title>root Labs</title>
    <link rel="stylesheet" href="bootstrap.min.css" />
    <link rel="stylesheet" href="bootstrap-theme.min.css" />
    <script src="jquery-3.3.1.min.js"></script>
    <script src="bootstrap.min.js"></script>


<script type="text/javascript">
    
    $(document).ready(function()
    {
      $("#addBtn").click(function(e)
      {
        e.preventDefault();
        $.ajax({
          type:"POST",
          url:"insert.php",
          data: $("#form").serialize(),
                 
          success:function(data){
           
             var data = jQuery.parseJSON(data); 
           
          $("#myTable").append( "<tr>"+"<td><input type=text name=id1 value="+data.Id+" </td>"+
          "<td><input type=text name=date1 value="+data.date1+" </td>"+
          "<td><input type=text name=task1 value="+data.Task+" </td>"+"<td>"+ '<input type="button" id="Btn" name="Btn" onClick="updaterow()" class="btn-primary btn-block" value="Update"/>'+"</td>"+"<td>"+ '<input type="button" id="btn" name="btn" onClick="deleterow()"  class="btn-primary btn-block" value="delete"/>'+"</td>"+"</tr>");
          
          },
          error:function()
          {
            alert("Oooops! there is an error");
          }

        })
      });
    });
  </script>

<script type="text/javascript">

  function deleterow(Id){

  $.ajax({
          type:"POST",
          url:"delete.php",
          data: $("#form").serialize(),      
          success:function(data){
            
            var data = jQuery.parseJSON(data);

            var row = document.getElementById(data.Id);
            row.parentNode.removeChild(row); 
             
         alert("record deleted successfully having Id:"+ data.Id);
          
          },
          error:function()
          {
            alert("Oooops! there is an error");
          }

        });
    };     

  </script>

<script type="text/javascript">

  function updaterow(){

  $.ajax({
          type:"POST",
          url:"update.php",
          data: $("#form").serialize(),      
          success:function(data){
            
            var data = jQuery.parseJSON(data);  

         alert("record updated successfully having Id:"+ data.Id);
          
          },
          error:function()
          {
            alert("Oooops! there is an error");
          }

        });
    };     

  </script>
</head>
<?php
  if(isset($_COOKIE["Name"]))
  {?>


<body style="background-image:url('../assignment/uploads/Blue-Wallpaper.jpg'); ">
    <form id="form" name="form" action="" method="POST">
   
    <!-- center div heading------------------- -->
     <br>
     <br>
     <br>
         <!-- Navigation bar with bootstrap------------------ -->
    <nav id="navbar" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menuToBeCollapsedOnMobile">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">root</a>
        </div>
        <!-- defining the nav likns, forms and other for toggling -->
        <div class="collapse navbar-collapse" id="menuToBeCollapsedOnMobile">
            <ul class="nav navbar-nav">
                <li class="active"><a href='/assignment/login.php'>LogOut</a></li>
               
            </ul>
        </div>
    </nav>

    <!-- forming the left division  responsive -->
    <div class="row">
        <!-- Personal Details Table -->
            <div class="col-sm-12">
                    <div class="table-responsive">
                            <table align="center" class="table table-bordered">
                                <tr><th align="center" colspan="2">Working Details</th></tr>
                                <tr><td>Date :</td><td><input type="date" id="date"  name="date" value=""/></td></tr>
                               <tr><td>Today's Work</td><td>
                                        <select id="task" name="task">
                                            <option value="Staging">Staging</option>
                                            <option value="Quality Assurance">Quality Assurance</option>
                                            <option value="Production">Production</option>
                                            
                                        </select>
                                    </td></tr>
                            </table>
                    </div>
            </div>
    
           
            <!-- Creating the add button----------- -->
            <div class="col-sm-12">
                <input type="button" id="addBtn" name="addBtn" class="btn-primary btn-block" value="ADD"/>
            </div>
            </form>

            <!--Displaying the added data------------------ -->
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="myTable">
                        <tr><th>date</th><th>Today's Work</th><th></th><th></th></tr>



<?php
$host="127.0.0.1";
$username = "root";
$password = "root";
$dbname = "Employee_Details";

$conn = new mysqli($host, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$perpage = 3;
if(isset($_GET['page']) & !empty($_GET['page'])){
  $curpage = $_GET['page'];
}else{
  $curpage = 1;
}
$start = ($curpage * $perpage) - $perpage;

$pageres = $conn->query("SELECT * FROM TimeSheet");
$totalres = $pageres->num_rows;

$endpage = ceil($totalres/$perpage);
$startpage = 1;
$nextpage = $curpage + 1;
$previouspage = $curpage - 1;

 $result = $conn->query("SELECT * FROM TimeSheet LIMIT $start, $perpage");

while($row = $result->fetch_assoc())
{
   echo "<tr id=".$row['Id'].">";
   echo "<td><input type=text id=date1 name=date1 value='".$row['date1']."' </td>";
   echo "<td><input type=text id=task1 name=task1 value='".$row['Task']."' </td>";
   echo "<td><input type='button' id='Btn' name='Btn'onClick='updaterow()'  class='btn-primary btn-block' value='Update'/></td>";
   echo "<td><input type='button' name='btn' onClick='deleterow()' id='btn'  class='btn-primary btn-block' value='delete'/></td>";
 
   echo "</tr>";
}

     $conn->close();
?>
                   
                    </table>
                </div>
<nav aria-label="Page navigation">
  <ul class="pagination">
  <?php if($curpage != $startpage){ ?>
    <li class="page-item">
      <a class="page-link" href="?page=<?php echo $startpage ?>" tabindex="-1" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">First</span>
      </a>
    </li>
    <?php } ?>
    <?php if($curpage >= 2){ ?>
    <li class="page-item"><a class="page-link" href="?page=<?php echo $previouspage ?>"><?php echo $previouspage ?></a></li>
    <?php } ?>
    <li class="page-item active"><a class="page-link" href="?page=<?php echo $curpage ?>"><?php echo $curpage ?></a></li>
    <?php if($curpage != $endpage){ ?>
    <li class="page-item"><a class="page-link" href="?page=<?php echo $nextpage ?>"><?php echo $nextpage ?></a></li>
    <li class="page-item">
      <a class="page-link" href="?page=<?php echo $endpage ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Last</span>
      </a>
    </li>
    <?php } ?>
  </ul>
</nav>


   </div>
</body>
<?php
}
  else
  {
     header('Location:/assignment/login.php');
  }?>
</html>
