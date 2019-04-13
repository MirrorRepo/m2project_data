<?php
/**
 *
 * Copyright © 2015 Bakewaycommerce. All rights reserved.
 */
namespace Bakeway\Import\Controller\Adminhtml\Export;

use Braintree\Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;
use Webkul\Marketplace\Model\Product as VendorProduct;
use Magento\Catalog\Helper\ImageFactory as ProductImageHelper;
use Magento\Catalog\Model\Product\Visibility as CatalogVisibility;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Bakeway\StoreCatalog\Helper\Data as StorecatalogHelper;
use Bakeway\HomeDeliveryshipping\Helper\Data as Homedeliveryhelper;
use Bakeway\Partnerlocations\Model\PartnerlocationsFactory as PartnerlocationsFactory;
use Bakeway\Cities\Helper\Data as CitisHelper;
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;


class Save extends \Magento\Backend\App\Action
{
    const FRONTEND_BASE_URL = "https://bakeway.com/";
    const XML_PATH_PRODUCT_SKU = "productfeed/setfeed/sku";
    const XML_PATH_MIN_WEIGHT = "productfeed/setfeed/weight";
    const XML_PATH_MIN_PRICE = "productfeed/setfeed/minprice";
    const XML_PATH_MAX_PRICE = "productfeed/setfeed/maxprice";
   // const XML_PATH_AOIT = "productfeed/setfeed/aoit";

    const CITY_ID = 1;

    protected $scopeConfig;

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
     * @var \Bakeway\Import\Helper\Data
     */
    protected $importHelper;

    /**
     * @var VendorProduct
     */
    protected $vendorProduct;

    /**
     * @var ProductCollection
     */
    protected $productCollection;

    /**
     * @var \Magento\Catalog\Api\ProductAttributeRepositoryInterface
     */
    protected $metadataService;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var \Magento\Catalog\Helper\ImageFactory
     */
    protected $productImageHelper;

    /**
     * @var CatalogVisibility
     */
    protected $catalogVisibility;

    /**
     * @var \PHPExcel
     */
    protected $excelParser;

    /**
     * @var \Bakeway\ProductApi\Helper\Data
     */
    protected $productApiHelper;

    /**
     * @var FileFactory
     */
    protected $downloader;

    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $fileSystem;

    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    protected $directoryList;

    /**
     * @var \Magento\Store\Model\App\Emulation
     */
    protected $appEmulation;

    /**
     * @var StorecatalogHelper
     */
    protected $storecatalogHelper;

    /**
     * @var Homedeliveryhelper
     */
    protected $_homedeliveryhelper;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * @var PartnerlocationsFactory
     */
    protected $partnerlocationsFactory;

    /**
     * @var CitisHelper 
     */
    protected $citisHelper;
    
    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;


    /**
     * Save constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Bakeway\Import\Helper\Data $importHelper
     * @param ProductCollection $productCollection
     * @param VendorProduct $vendorProduct
     * @param \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataServiceInterface
     * @param \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ProductImageHelper $productImageHelper
     * @param CatalogVisibility $catalogVisibility
     * @param \PHPExcel $excel
     * @param \Bakeway\ProductApi\Helper\Data $productApiHelper
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\Filesystem $fileSystem
     * @param \Magento\Framework\Filesystem\DirectoryList $directoryList
     * @param \Magento\Store\Model\App\Emulation $appEmulation
     * @param MarketplaceHelper
     */

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Bakeway\Import\Helper\Data $importHelper,
        ProductCollection $productCollection,
        VendorProduct $vendorProduct,
        \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataServiceInterface,
        \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor,
        ProductImageHelper $productImageHelper,
        CatalogVisibility $catalogVisibility,
        \PHPExcel $excel,
        \Bakeway\ProductApi\Helper\Data $productApiHelper,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Magento\Store\Model\App\Emulation $appEmulation,
        StorecatalogHelper $storecatalogHelper, 
        Homedeliveryhelper $homedeliveryhelper, 
        \Magento\Catalog\Model\ProductFactory $productFactory, 
        PartnerlocationsFactory $partnerlocationsFactory, 
        CitisHelper $citisHelper,
        MarketplaceHelper $marketplaceHelper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_storeManager = $storeManager;
        $this->_date = $date;
        $this->importHelper = $importHelper;
        $this->productCollection = $productCollection;
        $this->vendorProduct = $vendorProduct;
        $this->metadataService = $metadataServiceInterface;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->productImageHelper = $productImageHelper;
        $this->catalogVisibility = $catalogVisibility;
        $this->excelParser = $excel;
        $this->productApiHelper = $productApiHelper;
        $this->downloader = $fileFactory;
        $this->fileSystem = $fileSystem;
        $this->directoryList = $directoryList;
        $this->appEmulation = $appEmulation;
        $this->storecatalogHelper = $storecatalogHelper;
        $this->_homedeliveryhelper = $homedeliveryhelper;
        $this->productFactory = $productFactory;
        $this->partnerlocationsFactory = $partnerlocationsFactory;
        $this->citisHelper = $citisHelper;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return get base url
     */
    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/feed_catalouge.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info("---------------------start--------------------------");
        $logger->info(date('Y-m-d h:i:s'));
        
        $cityId = self::CITY_ID;
        $date = $this->_date->gmtDate('d-m-Y');
        $storeProdCollection = $this->vendorProduct->getCollection()
            ->addFieldToFilter('status', 1)
            ->addFieldToSelect(['mageproduct_id','seller_id']);
        $storeProdCollection->getSelect()->joinLeft(
            ['mp_udata' => $storeProdCollection->getTable('marketplace_userdata')],
            'main_table.seller_id=mp_udata.seller_id',
            ['business_name','is_conglomerate', 'store_city', 'seller_id','userdata_shop_temporarily_u_from','userdata_shop_temporarily_u_to']
        );
        
        $storeProdCollection->getSelect()->where('mp_udata.is_seller=?', 1);
        
        $storeProdCollection->getSelect()->where('mp_udata.is_live_ready=?', 1);
        $storeProdCollection->getSelect()->where('mp_udata.business_name!=?', null);
        $storeProdCollection->getSelect()->where('mp_udata.seller_id NOT IN (4430, 1374)');
        $storeProdCollection->getSelect()->group('mageproduct_id');
        //$storeProdCollection->getSelect()->where('mp_udata.seller_id IN (913,641,660)');
        $storeProductIDs = $storeProdCollection->getAllIds();
        $storeProductArr = [];
        
        $storeProdCollection->getSelect()->columns([
            "total_seller_store" => new \Zend_Db_Expr("(SELECT count(id) FROM bakeway_partner_locations WHERE seller_id = mp_udata.seller_id)")
        ]);
        
        $storeProdCollection->getSelect()->columns([
            "total_seller_products" => new \Zend_Db_Expr("(SELECT count(id) FROM bakeway_catalog_sync WHERE seller_id = mp_udata.seller_id)")
        ]);
       
             
        foreach ($storeProdCollection as $storeProd) {
            $mageProdId = $storeProd->getData('mageproduct_id');
            
            $storeProductArr[$mageProdId]['seller_id'] = $storeProd->getData('seller_id');
            $storeProductArr[$mageProdId]['business_name'] = $storeProd->getData('business_name');
            $storeProductArr[$mageProdId]['unavail_from'] = $storeProd->getData('userdata_shop_temporarily_u_from');
            $storeProductArr[$mageProdId]['unavail_to'] = $storeProd->getData('userdata_shop_temporarily_u_to');
            $storeProductArr[$mageProdId]['is_conglomerate'] = $storeProd->getData('is_conglomerate');
            $storeProductArr[$mageProdId]['store_city'] = $storeProd->getData('store_city');
            $storeProductArr[$mageProdId]['total_seller_store'] = $storeProd->getData('total_seller_store');
            $storeProductArr[$mageProdId]['total_seller_products'] = $storeProd->getData('total_seller_products');

         }

        $collection = $this->productCollection
            ->addFieldToFilter(
                'entity_id', ['in' => $storeProductIDs]
            )->addAttributeToSelect('*');
        $collection->setVisibility($this->catalogVisibility->getVisibleInSiteIds());
        $this->extensionAttributesJoinProcessor->process($collection);
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        $collection->addCategoriesFilter(['in'=>(13)]);
        $collection->load();
        $collection = $this->addBakewayUrlRewrite($collection);

           
        $storeId = $this->_storeManager->getStore()->getId();
        $this->appEmulation->startEnvironmentEmulation($storeId, \Magento\Framework\App\Area::AREA_FRONTEND, true);
        $i = 1;
        /**
         * Setting the header for the sheet
         */
        $this->excelParser->setActiveSheetIndex(0)
            ->setCellValueExplicit('A' . $i, 'id', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('B' . $i, 'title', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('C' . $i, 'description', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('D' . $i, 'custom_label_0', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('E' . $i, 'custom_label_1', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('F' . $i, 'link', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('G' . $i, 'image link', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('H' . $i, 'price', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('I' . $i, 'brand', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('J' . $i, 'condition', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('K' . $i, 'availability', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('L' . $i, 'google_product_category', \PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('M' . $i, 'custom_label_2', \PHPExcel_Cell_DataType::TYPE_STRING);
          

        $i++;
        $getEnabledProductCount = "";
        
        $testProductSku = $this->scopeConfig->getValue(
                                 self::XML_PATH_PRODUCT_SKU, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $testProductSku = explode(",", $testProductSku);
        
        $weightLimit = $this->scopeConfig->getValue(
                                 self::XML_PATH_MIN_WEIGHT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $minPrice = (float)$this->scopeConfig->getValue(
                                 self::XML_PATH_MIN_PRICE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $maxPrice = (float)$this->scopeConfig->getValue(
                                 self::XML_PATH_MAX_PRICE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        
        $currentDateTime = new \DateTime('now', new \DateTimezone("Asia/Kolkata"));
        $cDate = $currentDateTime->format('Y-m-d');
       
        foreach ($collection as $product) {
            $temporarilyFrom = date('Y-m-d', strtotime($storeProductArr[$product->getEntityId()]['unavail_from']));
            $temporarilyTo   = date('Y-m-d', strtotime($storeProductArr[$product->getEntityId()]['unavail_to']));
            if (($temporarilyFrom <= $cDate) && ($cDate <= $temporarilyTo)) 
            {
                continue;
            }
            $productName = $product->getName();
            $productName = strtolower($productName);
            if(strpos($productName, 'cake') == false)
            {
                $productName .= ' cake';
            }
            $productName = ucfirst($productName);
            $productId = $product->getEntityId();
            $imageUrl = $this->getImageUrl($product, 'product_page_image_large');
            $sellerId = $storeProductArr[$productId]['seller_id'];
            
            /**
              * get total seller product from catalog sync table
              */
            $totalsellerProd = $storeProductArr[$productId]['total_seller_products'];

            
            /**
             * get total store count for seller
             */
            $totalsellerStore = $storeProductArr[$productId]['total_seller_store'];
       
            /**
             * get store count for each enabled products
             */
            if(!empty($totalsellerProd)){
             
                $disableProductCount = $this->storecatalogHelper->getStoreCountForProduct($sellerId, $productId);
                $getEnabledProductCount = $totalsellerStore-$disableProductCount;
            }
            
            /**
             * check products status for stand alone bakery
             */
            $checkStandAloneBakeryProduct = false;
             $checkSellerType =  $this->marketplaceHelper->isConglomerate($sellerId);
             if(empty($checkSellerType)){
                     $checkStandAloneBakeryProduct = $this->storecatalogHelper->checkProductStatus($sellerId, $productId);
            }
            
            if($checkStandAloneBakeryProduct != true){
                   
            $isCongloSellerProduct = $storeProductArr[$productId]['is_conglomerate'];
            $businessName = $storeProductArr[$productId]['business_name'];
            $storeCity = $storeProductArr[$productId]['store_city'];
            $prodUrl = $this->getProductSeoUrl($product->getData('request_path'), $product->getId());
            $seoProdUrl = self::FRONTEND_BASE_URL.$prodUrl;
            $desc = strip_tags($product->getDescription());
            $description = ucfirst(strtolower($desc));
            
            if ($isCongloSellerProduct == 1) {

                $cityName = $this->citisHelper->getCityNameById($storeCity);
                $cityName = strtolower($cityName);
                $seoProdUrl = $seoProdUrl . "?store=all-" . $cityName;
            }
           
            $sellercityName = strtolower($this->citisHelper->getCityNameById($storeCity));
            if($sellercityName == 'pune' )
            {
                $sellercity = 1;
            }
            elseif($sellercityName == 'hyderabad')
            {
                $sellercity = 2;
            }
            elseif($sellercityName == 'bangalore') {
                $sellercity = 3;
            }

            $sku = $product->getData('sku');
            if(in_array($sku ,$testProductSku))
            {
                continue;
            }
            $typeId = $product->getTypeId();
            $weight = null;
            $advanceIntimation = null;
            $ruleTaxPrice = 0;
            if ($typeId == 'simple') {
                $weight = $product->getAttributeText("cake_weight");
                $flavour = $product->getAttributeText("cake_flavour");
                $ingredient = $product->getAttributeText("cake_ingredients");
                $advanceIntimation = $product->getData('advance_order_intimation');
                $productPrice = number_format($this->productApiHelper->getProductTaxPrice($product, null, null, false, null, $cityId), 2); 
                $rulePrice = $this->productApiHelper->getCatalogRulePrice($product->getId());
                $ruleTaxPrice = $this->productApiHelper->getCatalogRuleTaxPrice($product, $rulePrice);
                
            } elseif ($typeId == 'configurable') {
                $minimumPrice = $this->productApiHelper->getMinproductPrice($product, null, null, $cityId);
                $productPrice = $minimumPrice['tax_incl_price'];
                if (empty($productPrice)) {
                    $productPrice = '0.00';
                }
                if (isset($minimumPrice['simple_prod_obj']) && $minimumPrice['simple_prod_obj'] !== null) {
                    $weight = $minimumPrice['simple_prod_obj']->getAttributeText("cake_weight");
                    $flavour = $minimumPrice['simple_prod_obj']->getAttributeText("cake_flavour");
                    $ingredient = $minimumPrice['simple_prod_obj']->getAttributeText("cake_ingredients");
                    $advanceIntimation = $minimumPrice['simple_prod_obj']->getData('advance_order_intimation');
                }
                $rulePrice = $this->productApiHelper->getCatalogRulePrice($minimumPrice['product_id']);

                if ($minimumPrice['simple_prod_obj'] !== null) {
                    $ruleTaxPrice = $this->productApiHelper->getCatalogRuleTaxPrice($minimumPrice['simple_prod_obj'], $rulePrice);
                } else {
                    $ruleTaxPrice = 0;
                }
            }
            if ($ruleTaxPrice > 0 ) {
                $productPrice = $ruleTaxPrice;
            }        
            if ($advanceIntimation < 60)
            {
               $advanceIntimation .= ' min';
            }
            elseif($advanceIntimation == 60)
            {
                $advanceIntimation = '1 hr';
            }
            else
            {
               $advanceIntimation1 =intdiv($advanceIntimation, 60);
               $advanceIntimation  = $advanceIntimation1. ' hrs ';
            }
            
            if($weight < $weightLimit)
            {
                continue;
            }
           if(empty($weight)  || empty($productPrice)  || empty($flavour) || empty($ingredient))
            {
                continue;
            }

            $pP = str_replace(",", "", $productPrice);
            if(is_numeric($pP))
                $productPrice = $pP;

            $productPrice = (float)$productPrice;
        
            if(($productPrice > $maxPrice) || ($productPrice < $minPrice))
            {
                continue;
            }

            $this->excelParser->getSheet()
                ->setCellValueExplicit('A' . $i, $sku, \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B' . $i, $productName, \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('C' . $i, $description, \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('D' . $i, $weight, \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E' . $i, $advanceIntimation, \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('F' . $i, $seoProdUrl, \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('G' . $i, $imageUrl, \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('H' . $i, $productPrice, \PHPExcel_Cell_DataType::TYPE_NUMERIC)
                ->setCellValueExplicit('I' . $i, $businessName, \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('J' . $i, 'new', \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('K' . $i, 'in stock', \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('L' . $i, 'Food, Beverages & Tobacco > Food Items > Bakery > Cakes & Dessert Bars', \PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('M' . $i, $sellercity, \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                
           
              $i++; }
        }
        
        $fileName = "product_feeds_".$date.'_'.time().'.xls';
        $fileObj = $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA)->create('/productfeeds/'.$date.'/');
        $path = $this->fileSystem->getDirectoryWrite(DirectoryList::MEDIA)
            ->getAbsolutePath('/productfeeds/'.$date.'/'.$fileName) ;
        $excelWriter = new \PHPExcel_Writer_Excel2007($this->excelParser);
        $excelWriter->save($path);

        $file = $this->directoryList->getPath("media")."/productfeeds/".$fileName;
        $logger->info(date('Y-m-d h:i:s'));
        $logger->info("---------------------end--------------------------");
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($path) . "\"");
        ob_clean();flush();
        readfile($path);
        exit;
    }

    /**
     * Helper function that provides full cache image url
     * @param \Magento\Catalog\Model\Product
     * @return string
     */
    protected function getImageUrl($product, string $imageType = '') {
        $imageUrl = $this->productImageHelper->create()->init($product, $imageType)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(290, 290)->getUrl();
        return $imageUrl;
    }

    protected function addBakewayUrlRewrite($collection)
    {
        $productIds = [];
        foreach ($collection as $item) {
            $productIds[] = $item->getEntityId();
        }
        if (!$productIds) {
            return $collection;
        }

        $urlCollectionData = $this->_objectManager
            ->create('Magento\UrlRewrite\Model\UrlRewrite')
            ->getCollection()
            ->addFieldToFilter('entity_type', 'bakeway-product')
            ->addFieldToFilter('entity_id', ['in' => $productIds]);

        // more priority is data with category id
        $urlRewrites = [];

        foreach ($urlCollectionData as $row) {
            if (!isset($urlRewrites[$row['entity_id']])) {
                $urlRewrites[$row['entity_id']] = $row['request_path'];
            }
        }

        foreach ($collection as $item) {
            if (isset($urlRewrites[$item->getEntityId()])) {
                $item->setData('request_path', $urlRewrites[$item->getEntityId()]);
            } else {
                $item->setData('request_path', false);
            }
        }
        return $collection;
    }

    public function getProductSeoUrl($url, $productId) {
        if ($url !== null) {
            $sellerCity = $this->productApiHelper->getSellerCity($productId);
            if ($sellerCity !== null) {
                $cityString = preg_replace('#[^0-9a-z]+#i', '-', strtolower($sellerCity));

                $pos = strpos($url, $cityString . "-");
                if ($pos !== false) {
                    $url = substr_replace($url, $cityString . "/", $pos, strlen($cityString . "-"));
                } else {
                    $url = str_replace($cityString . "-", $cityString . "/", $url);
                }
            }
        }
        return $url;
    }
    
    
}
