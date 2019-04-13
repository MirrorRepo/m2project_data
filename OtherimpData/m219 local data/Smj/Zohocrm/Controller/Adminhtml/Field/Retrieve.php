<?php
/**
 * Copyright © 2015 Smj. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Smj_Zohocrm extension
 * NOTICE OF LICENSE
 *
 * @category Smj
 * @package  Smj_Zohocrm
 * @author   Mukund
 */
namespace Smj\Zohocrm\Controller\Adminhtml\Field;

use Smj\Zohocrm\Controller\Adminhtml\Field as FieldController;

/**
 * Class Retrieve Controller
 *
 * @package Smj\Zohocrm\Controller\Adminhtml\Field
 */
class Retrieve extends FieldController
{
    /**
     * execute get Access token
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $type       = $data['type'];
            $out        = array();
            $fieldModel = $this->_fieldFactory->create();
            $table      = $fieldModel->getAllTable();
            $m_table    = $table[$type];
            $zohoFields = $fieldModel->getZohoFields($type);
            $zohoOption = '';
            foreach ($zohoFields as $value => $label) {
                $zohoOption .= "<option value='$value' >".$label."</option>";
            }

            $out['zoho_options'] = $zohoOption;
            $magentoFields       = $fieldModel->getMagentoFields($m_table);
            $magentoOption       = '';
            if ($magentoFields) {
                foreach ($magentoFields as $value => $label) {
                    $magentoOption .= "<option value ='$value' >".$label."</option>";
                }
            }
            $out['magento_options'] = $magentoOption;
            
            $resultJson->setData(json_encode($out));
            return $resultJson;
        }
    }
}
