<?php session_start(); ?>

<?php
//include database configuration file
include 'config.php';

//get records from database

if(!empty($_POST['type']){


$survey_record_query = "SELECT * FROM survey_input_import where date ='".$_POST['date']."' ORDER BY id DESC";

$query = mysqli_query($db,$survey_record_query);

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "csv_exported_survey_of_" . date('d-m-Y') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('ID', 'Name','Phone', 'Email','Created Date');
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer


    while($row = $query->fetch_assoc()){
        $lineData = array($row['id'],$row['q1'], $row['q2'], $row['q3'], $row['q4'], $row['q3other'],$row['date']);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;

}else{
$survey_record_query = "SELECT * FROM survey_records where date ='".$_POST['date']."' ORDER BY id DESC";

$query = mysqli_query($db,$survey_record_query);

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "exported_survey_of_" . date('d-m-Y') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array('ID', 'Q1','Q2', 'Q3','Q4','Q3Other', 'Date');
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer


    while($row = $query->fetch_assoc()){
        $lineData = array($row['id'],$row['q1'], $row['q2'], $row['q3'], $row['q4'], $row['q3other'],$row['date']);
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;
}
?>