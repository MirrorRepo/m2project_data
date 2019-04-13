<?php

namespace Bakeway\HomeDeliveryshipping\Model\Config\Source;

class Sortproducts implements \Magento\Framework\Option\ArrayInterface
{

    public $sorting = array (
        1 => "Price",
        2 => "AOIT"
    );

    public function toOptionArray()
    {
        $ret = [];
        foreach ($this->sorting as $key => $value)
        {
            $ret[] = [
                'value' => $key,
                'label' => $value
            ];
        }

        return $ret;
    }

}