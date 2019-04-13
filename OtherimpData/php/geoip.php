
<?php

$request = ""; //initialise the request variable
$param['send_to'] = "919503678497";
//$param['msg'] = "Thanks for shopping with us! Your order is confirmed, and will be shipped shortly. Check your status here: Tap www.suryaflame.com/order-status";
$param['msg'] = "Delivery Successful!
Thanks for shopping with Suryaflame. We hope you have a lovely day.";
$param['userid'] = "2000183187";
$param['password'] = "kuQTZdFOE";
$param['v'] = "1.1";
$param["method"]= "sendMessage";

$param['msg_type'] = "TEXT";
$param['auth_scheme'] = "PLAIN";


foreach($param as $key=>$val) {
$request.= $key . "=" . urlencode($val);
$request.= "&";
}

$request = substr($request, 0, strlen($request) - 1); //remove final (&) sign from the request
 echo $url    = "http://enterprise.smsgupshup.com/GatewayAPI/rest?" . $request;die;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$curl_scraped_page = curl_exec($ch);
curl_close($ch);
//echo $curl_scraped_page;
?>

<?php

$ip = '14.140.120.246';//$_SERVER['REMOTE_ADDR']; // This will contain the ip of the request

// You can use a more sophisticated method to retrieve the content of a webpage with php using a library or something
// We will retrieve quickly with the file_get_contents
$dataArray = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);

$countryName = json_decode($dataArray);

echo $countryName->geoplugin_countryCode;


?>
