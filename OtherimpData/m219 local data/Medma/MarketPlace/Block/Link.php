<?php
/**
 *
 * Copyright © 2016 Medma. All rights reserved.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 */

namespace Medma\MarketPlace\Block;


use Medma\MarketPlace\Helper\Data as Medmahelper;
 
class Link extends \Magento\Framework\View\Element\Html\Link
{
   
    protected $medmahelper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Url $customerUrl
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Medma\MarketPlace\Helper\Data $medmahelper,
        array $data = []
    ) {

        $this->medmahelper = $medmahelper;
        parent::__construct($context, $data);
      
    }


protected function _toHtml()
    {
   
     return '<li><a target="_blank" href="'.$this->medmahelper->getSellerUrl().'">' . $this->escapeHtml($this->getLabel()) . '</a></li>';
    }
}
