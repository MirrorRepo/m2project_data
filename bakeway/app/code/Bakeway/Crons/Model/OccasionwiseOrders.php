<?php

namespace Bakeway\Crons\Model;

class OccasionwiseOrders {

    const BIRTHDAYARRAY = array("Birthday", "Bday", "B'day", "B,day", "Janamdin", "Janmdin", "Biday", "Birday", "Birtday", "birthday", "bdy", "bdayy", "Vadh divas", "Vadhdivas", "Wadhdivas", "Wadh divas", "HBD", "BIRTHDAY");
    const ANNIVARRAY = array("Anniverary", "Annive", "Anniversary", "Anniversery", "Shaadi", "Saalgirah", "Vardhapan");

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;
    /*
     * @var \Magenest\ZohocrmIntegration\Model\ResourceModel\OrderSync\Collection
     */
    protected $_orderCollectionFactory;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, \Magenest\ZohocrmIntegration\Model\ResourceModel\OrderSync\CollectionFactory $orderCollectionFactory
    ) {
        $this->objectManager = $objectManager;
        $this->_orderCollectionFactory = $orderCollectionFactory;
    }

    public function getOrderCollectionByOccasion() {

        date_default_timezone_set("Asia/Calcutta");
        echo date("h:i:s") . "\n";

        $objDate = $this->objectManager->create('Magento\Framework\Stdlib\DateTime\Timezone');
        $currentTimestamp = $objDate->formatDatetime(date("Y-m-d 23:59:00"));
        $start = strtotime('0min', strtotime($currentTimestamp));
        $startTime = date('Y-m-d 23:59:00', $start);
        $to = strtotime('-7 days', strtotime($currentTimestamp));
        $endTime = date('Y-m-d 00:00:01', $to);


        $syncOrderCollection = $this->_orderCollectionFactory->create();
        $syncOrderCollection->addFieldToSelect('*');
        $syncOrderCollection->addFieldToFilter('custom_message', ['neq' => 'NULL']);
        $syncOrderCollection->addFieldToFilter('created_at', ['datetime' => true, 'from' => $endTime, 'to' => $startTime]);


//       

        $_definedBirthdayArray = self::BIRTHDAYARRAY;
        $_definedAnnivArray = self::ANNIVARRAY;


        foreach ($syncOrderCollection as $order) {
            $matchWord = "";

            $_requestingString = $order['custom_message'];


            foreach ($_definedBirthdayArray as $b) {
                if (stristr($_requestingString, $b) || (string) $_requestingString == (string) $b) {
                    $matchWord = $b;
                    break;
                }
            }
            foreach ($_definedAnnivArray as $a) {
                if (stristr($_requestingString, $a) || (string) $_requestingString == (string) $a) {
                    $matchWord = $a;
                    break;
                }
            }

            $orderId = $order['order_id'];
            $sender_fname = $order['sender_firstname'];
            $sender_lname = $order['sender_lastname'];
            $reciever_fname = $order['reciever_firstname'];
            $reciever_lname = $order['reciever_lastname'];
            $email = $order['customer_email'];
            $telephone = $order['telephone'];
            $dateOfBirth = $order['dob'];



            $senderName = $order['sender_firstname'] . ' ' . $order['sender_lastname'];
            $recieverName = $order['reciever_firstname'] . ' ' . $order['reciever_lastname'];

            switch (true) {

                case (strcmp($matchWord, "Birthday") == 0 || strcmp($matchWord, "Bday") == 0 || strcmp($matchWord, "Bday") == 0 || strcmp($matchWord, "B'day") == 0 || strcmp($matchWord, "B,day") == 0 || strcmp($matchWord, "Janamdin") == 0 || strcmp($matchWord, "Janmdin") == 0 || strcmp($matchWord, "Biday") == 0 || strcmp($matchWord, "Birday") == 0 || strcmp($matchWord, "Birtday") == 0 || strcmp($matchWord, "birthday") == 0 || strcmp($matchWord, "bdy") == 0 || strcmp($matchWord, "bdayy") == 0 || strcmp($matchWord, "Vadh divas") == 0 || strcmp($matchWord, "Vadhdivas") == 0 || strcmp($matchWord, "Wadhdivas") == 0 || strcmp($matchWord, "Wadh divas") == 0 || strcmp($matchWord, "HBD") == 0 || strcmp($matchWord, "BIRTHDAY") == 0 ):

                    $custom_msg = $order['custom_message'] = "Birthday";
                    if ((string) $senderName == (string) $recieverName) {

                        $type = "CustomModule4";
                        $name = "Same name having Birthday Name";
                        $this->insertIntoZoho($orderId, $sender_fname, $sender_lname, $reciever_fname, $reciever_lname, $custom_msg, $email, $telephone, $dateOfBirth, $type, $name);
                    } else {

                        $type = "CustomModule7";
                        $name = "Diff names having Bday Name";
                        $this->insertIntoZoho($orderId, $sender_fname, $sender_lname, $reciever_fname, $reciever_lname, $custom_msg, $email, $telephone, $dateOfBirth, $type, $name);
                    }

                    break;


                case (strcmp($matchWord, "Anniverary") == 0 || strcmp($matchWord, "Annive") == 0 || strcmp($matchWord, "Anniversary") == 0 || strcmp($matchWord, "Anniversery") == 0 || strcmp($matchWord, "Shaadi") == 0 || strcmp($matchWord, "Saalgirah") == 0 || strcmp($matchWord, "Vardhapan") == 0) :

                    $custom_msg = $order['custom_message'] = "Anniversary";
                    if ((string) $senderName == (string) $recieverName) {

                        $type = "CustomModule6";
                        $name = "Same name having Annivers Name";
                        $this->insertIntoZoho($orderId, $sender_fname, $sender_lname, $reciever_fname, $reciever_lname, $custom_msg, $email, $telephone, $dateOfBirth, $type, $name);
                    } else {
                        $type = "CustomModule5";
                        $name = "Diff names having Anniver Name";
                        $this->insertIntoZoho($orderId, $sender_fname, $sender_lname, $reciever_fname, $reciever_lname, $custom_msg, $email, $telephone, $dateOfBirth, $type, $name);
                    }



                    break;




                default :
                    $custom_msg = $order['custom_message'];

                    if ((string) $senderName == (string) $recieverName) {

                        $type = "CustomModule8";
                        $name = "Same name and other occas Name";
                        $this->insertIntoZoho($orderId, $sender_fname, $sender_lname, $reciever_fname, $reciever_lname, $custom_msg, $email, $telephone, $dateOfBirth, $type, $name);
                    } else {
                        $type = "CustomModule9";
                        $name = "Diff name having oth occa Name";
                        $this->insertIntoZoho($orderId, $sender_fname, $sender_lname, $reciever_fname, $reciever_lname, $custom_msg, $email, $telephone, $dateOfBirth, $type, $name);
                    }
            }
        }

        echo date("h:i:s") . "\n";
    }

    public function insertIntoZoho($order_Id = null, $sender_fname = null, $sender_lname = null, $reciever_fname = null, $reciever_lname = null, $custom_msg = null, $email = null, $telephone = null, $dateOfBirth = null, $type = null, $name = null) {



        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<' . $type . '>
<row no="1">
<FL val="Order Id">' . $order_Id . '</FL>
    
<FL val="' . $name . '">Bakeway</FL>

<FL val="Sender First Name">' . $sender_fname . '</FL>

<FL val="Sender Last Name">' . $sender_lname . '</FL>

<FL val="Receiver First Name">' . $reciever_fname . '</FL>

<FL val="Receiver Last Name">' . $reciever_lname . '</FL>

<FL val="Occasion Name">' . $custom_msg . '</FL>

<FL val="Email">' . $email . '</FL>

<FL val="Phone">' . $telephone . '</FL>

<FL val="Dob">' . $dateOfBirth . '</FL>
</row>
</' . $type . '>';

        $auth = "1fa4433713fa2836bd98199d34fe76ab";
        $url = "https://crm.zoho.com/crm/private/xml/$type/insertRecords";
        $query = "authtoken=" . $auth . "&scope=crmapi&newFormat=1&xmlData=" . $xml;
        $ch = curl_init();
        /* set url to send post request */
        curl_setopt($ch, CURLOPT_URL, $url);
        /* allow redirects */
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        /* return a response into a variable */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        /* times out after 30s */
        curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
        /* set POST method */
        curl_setopt($ch, CURLOPT_POST, 1);
        /* add POST fields parameters */
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query); // Set the request as a POST FIELD for curl.
//Execute cUrl session
        $response = curl_exec($ch);
        curl_close($ch);
    }

}

?>