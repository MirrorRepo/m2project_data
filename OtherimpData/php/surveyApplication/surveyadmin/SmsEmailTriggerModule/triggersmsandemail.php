<?php session_start(); ?>
<?php 
if(!isset($_SESSION['username'])){

 header('location: login.php');
}
?>
<?php include_once '../config.php'; ?>
<?php
/*
* inject the sendgrid class
* start
*/

define("TWILLO_ID", 'AC95e41b3a495d81ddabe6efc80e330d77'); //twillo  id
define("TWILLO_TOKEN", 'f018050730490c700fefb804c205cd80'); //twillo token

require 'sendgrid-php/vendor/autoload.php'; 
$email = new \SendGrid\Mail\Mail(); 

require __DIR__ . '/twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;

$sendgridApiKey = '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';
define("SENDGIRDAPIKEY", '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'); //twillo token

?>



<?php

$survey_input_records_check_query = "SELECT * FROM survey_input_import";

$result = mysqli_query($db, $survey_input_records_check_query);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $customerFullName = $row['name'];
       $customerPhone = $row['phone'];
       $customerEmail = $row['email']; 
       sendSms($customerFullName, $customerPhone);
       sendEmail($customerFullName, $customerEmail);
        
    }

   $_SESSION['sms_email_triggered']  = "Sms and Email has triggerd Successfully !!!";
   $db->close();
  header('location: ../index.php');
} else {
    echo "0 results";
}




?>



<?php
die;
/*
**
* @param  string $name
* @param  int $mobile
*/
function  sendSms($name, $mobile){
echo $mobile;
$client = new Client(TWILLO_ID, TWILLO_TOKEN);
    try{
      $client->messages->create(
          // the number you'd like to send the message to
          '+91'.$mobile,
          array(
              // A Twilio phone number you purchased at twilio.com/console
              'from' => '+12023357637',
              'body' => "Hey ".$name."! Good luck for your survey project demo from kush!."
          )
      );
    }catch(Exception $e){
      echo $e->getMessage();
    }

}

/*
* @param  string $name
* @param  string $emailReceiver
*/

function  sendEmail($name, $emailReceiver){

      $email = new \SendGrid\Mail\Mail();
      $email->setFrom("kush14011989@gmail.com", "From Demo team");
      $email->setSubject("Email of Demo Purpose");
      $email->addTo($emailReceiver, $name);
      $email->addContent("text/plain", "All the best for demo and this sample email");
      $email->addContent(
      "text/html", "<strong>All the best for demo and this is sample email content</strong>");
      $sendgrid = new \SendGrid(SENDGIRDAPIKEY);

      try {
          $response = $sendgrid->send($email);

         /* echo "<pre>";
          print $response->statusCode() . "\n";
          print_r($response->headers());
          print $response->body() . "\n";*/

        } catch (Exception $e) {
          echo 'Caught exception: '. $e->getMessage() ."\n";
      }

  }
?>