<?php
echo include_once  './config.php';


function getSubmittedSurveyRecords(){
$survey_record_query = "select * from survey_records";
$result = $db->query($survey_record_query);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]."<br>";
    }
} else {
    echo "0 results";
}

}

?>