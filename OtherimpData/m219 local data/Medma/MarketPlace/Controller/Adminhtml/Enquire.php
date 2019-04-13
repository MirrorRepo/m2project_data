<?php

/**
 * @category Dischem
 * @package  Dischem_Storeinfo
 * @module   Mainslider
 * @author   kushagra.daharwal@zensar.in
 */
 

namespace Medma\MarketPlace\Controller\Adminhtml;


abstract class Enquire extends \Medma\MarketPlace\Controller\Adminhtml\AbstractAction
{
    /**
     * Check if admin has permissions to visit related pages.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Medma_MarketPlace::manage_enquire_messages');
    }
}
