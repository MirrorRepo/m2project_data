<?php session_start(); ?>
<?php 
if(!isset($_SESSION['username'])){

 header('location: login.php');
}
?>


<?php include_once '../config.php'; ?>

<?php
$customerFullName = $customerPhone = $customerEmail = "";
$file_handle = fopen("survey_inputs_data.csv", "r");
    $headerLine = true;
    $i = 1;
    while (($row = fgetcsv($file_handle, "5400", ",")) != FALSE) {
        if ($headerLine) {
            $headerLine = false;
        } else {
          if(!empty($row['1'])){
              $customerFullName = $row['1']; //customer name
          }

          if(!empty($row['2'])){
              $customerPhone = $row['2']; //customer phone
             // sendSms($customerFullName, $customerPhone);

          }

          if(!empty($row['3'])){
           $customerEmail = $row['3']; //customer email
           //sendEmail($customerFullName, $customerEmail);
          }

          if (empty($row['1'])) {
          array_push($errors, "Username is required");
          }

          if (empty($row['2'])) {
          array_push($errors, "Phone is required");
          }

          if (empty($row['3'])) {
          array_push($errors, "Email is required");
          }


          $query = "INSERT INTO survey_input_import(name, phone, email)
VALUES('$row[1]', '$row[2]', '$row[3]')";
          try{
               mysqli_query($db, $query);
             }
            catch(Example $e){
              echo $e->getMessage;
            }

        }
        $i++;
     }
     $_SESSION['record_sucess_import'] = "Records has imported successfully @ ".date('d-m-Y');
     header('location: ../index.php');
     fclose($file_handle);
?>

