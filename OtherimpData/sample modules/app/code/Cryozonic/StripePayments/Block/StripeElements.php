<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Block;

use Cryozonic\StripePayments\Helper\Logger;

class StripeElements extends \Magento\Framework\View\Element\Template
{
    protected $_template = 'form/stripe-elements.phtml';

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Cryozonic\StripePayments\Helper\Generic $helper,
        array $data = []
    )
    {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    public function isAdmin()
    {
        return $this->helper->isAdmin();
    }
}