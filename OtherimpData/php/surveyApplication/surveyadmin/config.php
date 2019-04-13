<?php
// initializing variables
$username = "";
$email = "";
$errors = array();
// connect to the database


try {
    $db = mysqli_connect('localhost', 'root', 'root', 'survey_cp');
} catch (Exception $e) {
    echo "There is some problem in connection: " . $e->getMessage();
}
?>