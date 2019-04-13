<?php

/**
 *
 * Copyright © 2015 Bakewaycommerce. All rights reserved.
 */

namespace Bakeway\Import\Controller\Import;

use \Magento\Framework\App\Action\Context;
use \Magento\Framework\View\Result\PageFactory;
use \Magento\Framework\App\RequestInterface;
use \Magento\Catalog\Model\ProductFactory as ProductFactory;
use Symfony\Component\Config\Definition\Exception\Exception;
use Bakeway\CatalogSync\Model\ResourceModel\CatalogSync\Collection;

class Attribute extends \Magento\Framework\App\Action\Action {

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var  \Magento\Framework\ObjectManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollection;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * Save constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     */
    public function __construct(
    Context $context, PageFactory $resultPageFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollection, ProductFactory $productFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_storeManager = $storeManager;
        $this->_date = $date;
        $this->productCollection = $productCollection;
        $this->productFactory = $productFactory;
    }

    /**
     * @return get base url
     */
    public function getBaseUrl() {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {

        date_default_timezone_set("Asia/Calcutta");
        echo date("h:i:s") . "\n"; 
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productCollection = $objectManager->create('Bakeway\CatalogSync\Model\ResourceModel\CatalogSync\Collection');
        
        
        $collection = $productCollection->addFieldToSelect(["product_id", "categories_json", "cake_flavour"]);
        $collection->join(array('c' => 'catalog_product_entity_varchar'), 'c.entity_id=main_table.product_id', array('value'));
        $collection->getSelect()->where("c.attribute_id = '73'");
        $collection->getSelect()->group('entity_id');
        //$collection->getSelect()->limit(100);
        //echo $collection->getSelect();die;
        
        $value = $flavour = $label = "";
        $valueString = $flavourString = $labelString = "";
        
        
        foreach ($collection as $product) 
            {
            $label = [];
           
            $catInfo = unserialize($product['categories_json']);
            if (is_array($catInfo) || is_object($catInfo))
            {
            foreach ($catInfo as  $catInfovalue) {
                if ($catInfovalue['label'] != 'General') {
                    $label[] = $catInfovalue['label'];
                }
            }
            }
            
            $productId = $product['product_id'];
            $value = $product['value'];
            $flavour = $product['cake_flavour'];
            $label = implode(",", $label);



            if (isset($value)) {
                $valueString = $value . " ,";
            }



            if (isset($flavour)) {
                $flavourString = $flavour . " ,";
            }

            if (isset($label)) {
                $labelString = $label;
            }


            $finalString = $valueString . $flavourString . $labelString;

            $searchFactory = $objectManager->create('BakewayMobile\GlobalSearch\Model\Globalsearch');
            $searchFactory->setData('product_id', $productId);
            $searchFactory->setData('tags', $finalString);
            $searchFactory->setData('created_by', "Bakeway");
            try {
                $searchFactory->save();
            } catch (\Exception $e) {
            }

        }

        
                echo date("h:i:s") . "\n"; 


        die;/**
         * script to add old seller data to store category table
         */
        $resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');

        $connection = $resource->getConnection();

        $tableBpl = $resource->getTableName('bakeway_partner_locations');

        $sql = "Select id,seller_id FROM " . $tableBpl;

        $sqlOfAllcatsId = "select group_concat(entity_id) from catalog_category_entity where entity_id not in (13,3)";

        $resultAllCat = $connection->fetchOne($sqlOfAllcatsId); //give all cat id


        $resultAllSellers = $connection->fetchAll($sql);

        $addingCats[] = [
            "id" => "13",
            "level" => "2",
            "name" => "Cakes"];
        $addingCats[] = [
            "id" => "3",
            "level" => "2",
            "name" => "Add ons"];

        $cats = json_encode($addingCats);

        $i = 0;
        foreach ($resultAllSellers as $resultAllSellers1) {

            $sqlInsert = "Insert Into bakeway_store_catalog_category (seller_id,categories_id,enable_categories_id,store_id,
                           status,created_at,updated_at,created_by) values (
                            '" . $resultAllSellers1['seller_id'] . "',
                            '" . $resultAllCat . "',
                             '" . $cats . "',
                            '" . $resultAllSellers1['id'] . "',
                             '0',
                             '" . date('Y/m/d') . "',
                             '" . date('Y/m/d') . "',
                            'Admin')";
            try {
                $connection->query($sqlInsert);
                echo $resultAllSellers1['seller_id'] . " id=>" . $resultAllSellers1['seller_id'];
                echo "<br>";
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }


        /**
         * end
         */
        exit();
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/updateattributes.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $getProducts = $this->productCollection->create()->getAllIds();

        if (count($getProducts) > 0) {
            $logger->info("process start " . date("d m Y H:i:s"));

            $array_product = $getProducts; //product Ids
            $value = 1; //amount
            $productActionObject = $objectManager->create('Magento\Catalog\Model\Product\Action');
            $productActionObject->updateAttributes($array_product, array('advance_order_intimation_unit' => $value), 0);

            $logger->info("process end " . date("d m Y H:i:s"));
        }
    }

}
