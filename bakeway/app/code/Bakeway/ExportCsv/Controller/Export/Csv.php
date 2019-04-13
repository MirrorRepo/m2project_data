<?php
namespace Bakeway\ExportCsv\Controller\Export;

class Csv extends \Magento\Framework\App\Action\Action
{
   /**
    * @var \Bakeway\ExportCsv\Model\DailyOrder
    */
   protected $order;
    /**
    * @var \Magento\Framework\Stdlib\DateTime\DateTime
    */
   protected $date;
     /**
    * @var \Magento\Framework\View\Result\PageFactory
    */
    protected $resultPageFactory;

     /** 
      * @var \Magento\Framework\App\Filesystem\DirectoryList
      */
    protected $directoryList;

     /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csv;
     /**
     * Construct
      *@param  \Magento\Framework\App\Action\Context $context
      *@param  \Magento\Framework\Stdlib\DateTime\DateTime $date
      *@param  \Bakeway\ExportCsv\Model\DailyOrder $order
      *@param  \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Bakeway\ExportCsv\Model\DailyOrder $order,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\File\Csv $csv)
    {
        $this->date = $date;
        $this->order = $order;
        $this->resultPageFactory = $resultPageFactory;
        $this->csv = $csv; 
        $this->directoryList = $directoryList;
   
        return parent::__construct($context);
    }
     
    public function execute()
    {    

        $pre_day = date('Y-m-d', strtotime(date('Y-m-d') . "-1 day") );
        $fileDirectory = \Magento\Framework\App\Filesystem\DirectoryList::MEDIA;
          if($pre_day == (date('Y-m-d', strtotime(date('Y-m-01') . ' -1 day'))))
             {
               $start_day = date('Y-m-01', strtotime($pre_day));
               $file = 'reports/orderexport' .$start_day.'to'.$pre_day. '.csv';
             }
          else
             {
               $fileName = 'reports/orderexport' .date('Y-m-01').'to'.date('Y-m-t'). '.csv';
             }
            $filePath = $this->directoryList->getPath($fileDirectory) . "/" . $fileName;
          if(!file_exists($filePath))
             {
               $this->order->orderexport($pre_day);
             }
          else
             {
             $csvData = $this->csv->getData($filePath);
             $count = count($csvData); 
           
             if($count)
              {
                foreach ($csvData as $row => $data)
                {
                   if($row == $count-1 && $count>0)
                   {
                     $orderId =  $data[0];
                     $this->order->orderexport($pre_day,$orderId);
                   }               
                }
              } 
            else
              {
                $this->order->orderexport($pre_day);
              }
            }
    } 
}
