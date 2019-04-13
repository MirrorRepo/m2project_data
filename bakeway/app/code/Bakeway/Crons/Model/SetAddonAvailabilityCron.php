<?php
/**
 * Bakeway
 *
 * @category  Bakeway
 * @package   Bakeway_Crons
 * @author    Bakeway
 */

namespace Bakeway\Crons\Model;

use Magento\Catalog\Api\ProductRepositoryInterface as ProductRepository;
use Webkul\Marketplace\Model\ResourceModel\Product\CollectionFactory as SellerProductCollection;
use Webkul\Marketplace\Helper\Data as MarketplaceHelper;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;
use Bakeway\ProductApi\Helper\Data as ProductApiHelper;
use Webkul\Marketplace\Model\Seller as MarketplaceSeller;

class SetAddonAvailabilityCron 
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var SellerProductCollection
     */
    protected $sellerProductCollection;

    /**
     * @var MarketplaceHelper
     */
    protected $marketplaceHelper;

    /**
     * @var ProductCollection
     */
    protected $productCollection;

    /**
     * @var ProductApiHelper
     */
    protected $productApiHelper;

    /**
     * @var MarketplaceSeller
     */
    protected $marketplaceSeller;

    /**
     * @var  \Webkul\Marketplace\Model\SellerFactory
     */
    protected $vendorFactory;

    /**
     * SetAddonAvailabilityCron constructor.
     * @param ProductRepository $productRepository
     * @param SellerProductCollection $sellerProductCollection
     * @param MarketplaceHelper $marketplaceHelper
     * @param ProductCollection $productCollection
     * @param ProductApiHelper $productApiHelper
     * @param MarketplaceSeller $marketplaceSeller
     */
    public function __construct(
        ProductRepository $productRepository,
        SellerProductCollection $sellerProductCollection,
        MarketplaceHelper $marketplaceHelper,
        ProductCollection $productCollection,
        ProductApiHelper $productApiHelper,
        MarketplaceSeller $marketplaceSeller,
       \Webkul\Marketplace\Model\SellerFactory $vendorFactory
    )
    {
        $this->productRepository = $productRepository;
        $this->sellerProductCollection = $sellerProductCollection;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->productCollection = $productCollection;
        $this->productApiHelper = $productApiHelper;
        $this->marketplaceSeller = $marketplaceSeller;
        $this->vendorFactory = $vendorFactory;
    }

    public function setAddonAvailability()
    {
      $time_start = microtime(true);
      $sellers = $this->vendorFactory->create()->getCollection()
                    ->addFieldToSelect(['seller_id', 'is_seller', 'is_live_ready', 'categories_available'])
                    ->addFieldToFilter('is_seller', 1);

      if(count($sellers) > 0)
      {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/sellerAddonAvailibility.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $categoryArray = $this->productApiHelper->getBkwyFirstLevelCategories();
        foreach ($sellers as $seller) 
        {
          $categoriesAvailable = '';
          $sellerId = $seller->getSellerId();
          $sellerEntityId = $seller->getEntityId();
          $sellerProdColl = $this->sellerProductCollection->create()
                                 ->addFieldToSelect(['seller_id', 'mageproduct_id'])
                                 ->addFieldToFilter('main_table.seller_id', $sellerId)
                                 ->addFieldToFilter('main_table.status', 1);
          $sellerProdArray = [];
          $sellerProdIds = [];
          $result = $final = $final_result = $pdCatIds = [];
          foreach ($sellerProdColl as $sellerProd)
          {
            $sellerProdIds[] = $sellerProd->getData('mageproduct_id');
            $sellerProdArray[$sellerProd->getData('mageproduct_id')] = $sellerEntityId;
          }
          $prodColl = $this->productCollection->create()->addFieldToFilter('entity_id', ['in'=>$sellerProdIds]);
          $prodColl->addStoreFilter(1); //Check only for default store
          $prodColl->addAttributeToFilter('status', ['in' => array(1)]); // Only Enable Products
          $prodColl->setVisibility(4); // Only Catalog, Search Products

          if (count($prodColl) && count($prodColl) > 0)
          {
            foreach ($prodColl as $product)
            {
              $categoryIds = $product->getCategoryIds();
              $pdCatIds[] = $categoryIds;
            }
            $result = call_user_func_array('array_merge', $pdCatIds);
            $final = array_unique($result, SORT_REGULAR);
            sort($final);
            $final_result = array_intersect($final,$categoryArray);
            if(!empty($final_result))
            {
              sort($final_result);
              $categoriesAvailable = implode(",",$final_result);                
            }
            $sellerObj = $this->marketplaceSeller->load($sellerEntityId);
            
            if($categoriesAvailable != '')
            {
              $sellerObj->setData('categories_available', $categoriesAvailable);
              $logger->info('Seller with Id : '.$sellerId. ' has products in categories: '.$categoriesAvailable);
            }
            else
            {
              $sellerObj->setData('categories_available', 0);
              $logger->info('Seller with Id : '.$sellerId. ' has no addons available');
            }

            try
            {
              $sellerObj->save();
            }
            catch( \Exception $e)
            {
              $logger->info('Exception: '.$e->getMessage());
            }
          }
        }
      }
      $time_end = microtime(true);
      $execution_time = ($time_end - $time_start);
      $logger->info('Total Execution Time: '.$execution_time.' Secs');      
    }
}