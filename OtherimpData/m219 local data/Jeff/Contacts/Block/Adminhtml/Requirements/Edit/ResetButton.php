<?php
namespace Jeff\Contacts\Block\Adminhtml\Requirements\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ResetButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'on_click' => 'location.reload();',
            'class' => 'reset',
            'sort_order' => 30
        ];
    }

    public function getBackUrl()
    {
        //return $this->getUrl('*/*/delete', ['jeff_contacts_contact_id' => $this->getId()]);
    }
}
