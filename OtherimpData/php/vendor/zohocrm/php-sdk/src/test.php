<?php
ZCRMRestClient::initialize();
die;
require '/var/www/html/php/vendor/autoload.php';

$zcrmModuleIns = ZCRMModule::getInstance("Contacts");
$bulkAPIResponse=$zcrmModuleIns->getRecords();
$recordsArray = $bulkAPIResponse->getData(); // $recordsArray - array of ZCRMRecord instances







