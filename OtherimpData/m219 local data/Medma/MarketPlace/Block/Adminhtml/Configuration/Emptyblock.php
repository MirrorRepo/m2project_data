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
 
namespace Medma\MarketPlace\Block\Adminhtml\Configuration;
 
class Emptyblock extends \Magento\Backend\Block\Template
{
 
    /**
     * @var \Magento\Backend\Helper\Data
     */
    protected $backendHelper;

    protected $_template = 'marketplace/configuration/empty.phtml';
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
}
