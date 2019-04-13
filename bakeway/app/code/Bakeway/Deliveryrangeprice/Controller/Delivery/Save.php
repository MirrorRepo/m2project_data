<?php
namespace Bakeway\Deliveryrangeprice\Controller\Delivery;

class Save extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var \Bakeway\Partnerlocations\Model\PartnerlocationsFactory
     */
    protected $partnerLocationsFactory;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Bakeway\Partnerlocations\Model\PartnerlocationsFactory $partnerLocationsFactory
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Bakeway\Partnerlocations\Model\PartnerlocationsFactory $partnerLocationsFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->partnerLocationsFactory = $partnerLocationsFactory;
        $this->jsonHelper = $jsonHelper;
        $this->coreRegistry = $coreRegistry;

    }
	
    /**
     * Flush cache storage
     */
    public function execute()
    {
        $response = array('message'=>"");
        $data = $this->getRequest()->getParams();
        
        if($data['free_delivery_threshold'] == "" or !is_numeric($data['free_delivery_threshold']))
            $data['free_delivery_threshold'] = null;

        if($data['size_threshold'] == "" or !is_numeric($data['size_threshold']))
            $data['size_threshold'] = null;

		$_updateddate = $this->getRequest()->getParam('updated_time');

        if(!empty($data))
        {
            $partnerModel =  $this->partnerLocationsFactory->create()->load($data['storeid']);
            $partnerModel->setIsDeliveryActive((int)$data['is_delivery_active']);
            $partnerModel->setIsMidnightActive((int)$data['is_midnight_active']);
            $partnerModel->setIsMorningActive((int)$data['is_morning_active']);
            $partnerModel->setIsFreeDeliveryActive((int)$data['is_free_delivery_active']);
            $partnerModel->setFreeDeliveryThreshold($data['free_delivery_threshold']);
            $partnerModel->setSizeThreshold($data['size_threshold']);
            $partnerModel->setUpdatedAt($_updateddate);
            try
            {
                $partnerModel->save();
                $response['message'] = 'Delivery details has been saved successfully';
            }
            catch( \Exception $e)
            {
                 $response['message']  = $e->getMessage();
            }            
        }
        echo $response = $this->jsonHelper->jsonEncode($response);
        exit();
    }
}