<?php 
namespace BakewayMobile\PartnerMobileApi\Helper;

use Magento\Catalog\Helper\ImageFactory as ProductImageHelper;
use Bakeway\StoreCatalog\Helper\Data as StorecatalogHelper;
use Webkul\Marketplace\Model\Product as VendorProduct;
use Magento\Framework\ObjectManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	const ALL_CITY_NAME_FOR_FILTER = ["all-pune", "all-bangalore", "all-hyderabad"];
	const SORT_BY_PRICE_CAT = array('3');
	const XML_PATH_CATEGORY_ID = 'mobilebakeway/mobileapi/category';
	const XML_PATH_FETCH_LIMIT = 'mobilebakeway/mobileapi/limit';
	protected $scopeConfig;

	/**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

	/**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

	/**
     * @var StorecatalogHelper 
     */
    protected $storecatalogHelper;

	 /**
     * @var VendorProduct
     */
    protected $_vendorProduct;

	/**
     * @var \Magento\Catalog\Helper\ImageFactory
     */
    protected $productImageHelper;
	
	/**
     * @var \Bakeway\ProductApi\Helper\Data
     */
    protected $productapihelper;

	public function __construct(
		ProductImageHelper $productImageHelper,
		 \Bakeway\ProductApi\Helper\Data $productapiHelper,
		 StorecatalogHelper $storecatalogHelper,
		 VendorProduct $_vendorProduct,
		 ObjectManagerInterface $objectManager,
		 \Magento\Store\Model\StoreManagerInterface $storeManager,
		 \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
	{
		$this->productImageHelper = $productImageHelper;
		$this->productapihelper = $productapiHelper;
	    $this->storecatalogHelper = $storecatalogHelper;
	    $this->_vendorProduct = $_vendorProduct;
	    $this->objectManager = $objectManager;
	    $this->_storeManager = $storeManager;
	    $this->scopeConfig = $scopeConfig;
	}

    public function getProductCategory()
    {
    	 $category = $this->scopeConfig->getValue(
                       self::XML_PATH_CATEGORY_ID, \Magento\Store\Model\ScopeInterface::SCOPE_STORE
       );
    	 $category = explode(",", $category);
    	 return $category;
    }

     public function getFetchLimit()
    {
        return  $this->scopeConfig->getValue(
                       self::XML_PATH_FETCH_LIMIT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
   /**
     * Helper function that provides full cache image url
     * @param \Magento\Catalog\Model\Product
     * @return string
     */
    public function getImageUrl($product, string $imageType = '') {
        if ($imageType == 'product_page_image_large') {
            $imageUrl = $this->productImageHelper->create()->init($product, $imageType)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(225, 225)->getUrl();
        } else {
            $imageUrl = $imageUrl = $this->productImageHelper->create()->init($product, $imageType)->getUrl();
        }
        return $imageUrl;
    }

    /*
     * return attribute label name from attribute code
     */
    public function getAttributeLabel($product, $code) {
        $_AttData = $product->getResource()->getAttribute($code)->getStoreLabel();
        return $_AttData;
    }

    public function getProductSeoUrl($url, $productId) {
        if ($url !== null) {
            $sellerCity = $this->productapihelper->getSellerCity($productId);
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

    public function addBakewayUrlRewrite($collection) {
        $productIds = [];
        foreach ($collection as $item) {
            $productIds[] = $item->getEntityId();
        }
        if (!$productIds) {
            return $collection;
        }

        $urlCollectionData = $this->objectManager
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

    public function getEnableProductId($vendorId,$storeName)
    {
    	$disabledProductId = [];
         if (isset($storeName) && !empty($storeName)) {
            $sellerStoreId = $this->storecatalogHelper->getStoreIdFromStoreName($storeName, $vendorId);
            $disabledProdId = [];
            if (in_array($storeName, self::ALL_CITY_NAME_FOR_FILTER)) {

                $alldisableProIds = $this->storecatalogHelper->getSellerDisablesProducts($vendorId);

                foreach ($alldisableProIds as $productId) {
                    $disabledProductId[] = $productId['product_id'];
                }
            }
        }
        $storeCollection = $this->_vendorProduct->getCollection()
                                ->addFieldToSelect(['mageproduct_id']);
        $storeCollection->getSelect()->group('mageproduct_id');
        $storeCollection->getSelect()->where("main_table.seller_id=?", $vendorId);
        $storeCollection->getSelect()->where("main_table.status=?", 1);

        $storeProductIDs = $storeCollection->getAllIds();

        $storeDisableProIds = [];
        if (isset($storeName) && !empty($storeName)) {
            if (in_array($storeName, self::ALL_CITY_NAME_FOR_FILTER)) {
                $storeDisableProIds = $disabledProductId;
            } else {
                if($storeName = "flatproducts"){
                  $storeDisableProIds = "";  
                }
                $storeDisableProIds = $this->storecatalogHelper->getSellerStoreProduct($sellerStoreId, $vendorId);
            }
        }else{
            
                $storeDisableProIds = $this->storecatalogHelper->getStandAloneSellerProduct($vendorId);
        }
        
        $storeProductIDColl = [];

        foreach ($storeProductIDs as $storeProductID) {

            if (!in_array($storeProductID, $storeDisableProIds)) {
                $storeProductIDColl[] = $storeProductID;
            }
        }
        return $storeProductIDColl;
    }

}