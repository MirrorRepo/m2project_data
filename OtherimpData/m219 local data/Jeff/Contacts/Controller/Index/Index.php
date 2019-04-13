<?php
namespace Jeff\Contacts\Controller\Index;
class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;        
        parent::__construct($context);
    }
    
    public function execute()
    {
        //return $this->resultPageFactory->create();  
        /* create some contact record by using _objectManager property of controller
        $contact = $this->_objectManager->create('Jeff\Contacts\Model\Contact');
        $contact->setName('Paul Dupond');
        $contact->setEmail('dup@example.com');
        $contact->save();
        echo 'Done';
        */

        //$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');

        $contactModel = $this->_objectManager->create('Jeff\Contacts\Model\Contact');

        //get resource 
        $resource = $contactModel->getResource();
        $connection = $resource->getConnection();
        $sql = "INSERT INTO jeff_contacts_contact(name, email) values('wangwu', 'wang@example')";
        //$result = $connection->fetchAll($sql);
        $result = $connection->query($sql);


        var_dump($result);

        $collection = $contactModel->getCollection()->addFieldToFilter('name', array('like' => '%Pau%'));

        foreach($collection as $item)
        {
            echo $item->getName(). '<br>';
        }

        echo 'Done';
    }
}
