<?php
namespace Bakeway\ExportCsv\Controller\Export;

class Data extends \Magento\Framework\App\Action\Action
{
    /**
    * @var \Bakeway\ExportCsv\Model\OrderList
    */
    protected $orderlist;
    
    /**
    * @var \Magento\Framework\View\Result\PageFactory
    */
    protected $resultPageFactory;

     /**
     * Construct
      *@param  \Magento\Framework\App\Action\Context $context,
      *@param  \Bakeway\ExportCsv\Model\OrderList $orderlist,
      *@param  \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
	      \Bakeway\ExportCsv\Model\OrderList $orderlist,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->orderlist = $orderlist;
        $this->resultPageFactory = $resultPageFactory; 
	 
        return parent::__construct($context);
    }
     
      /**
     * Execute and print
     */
    public function execute()
    {

        $from = $this->getRequest()->getParam('from'); 
        $to = $this->getRequest()->getParam('to');
    
        if($from!="" && $to!="")                                  
      	{
	        $this->orderlist->orderexport($from,$to);
          print_r("File saved successfully");
	      }
      
    } 
}

