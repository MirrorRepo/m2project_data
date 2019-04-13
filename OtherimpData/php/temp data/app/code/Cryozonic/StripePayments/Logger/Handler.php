<?php
/**
 * Copyright © Cryozonic Ltd. All rights reserved.
 *
 * @package    Cryozonic_StripePayments
 * @copyright  Copyright © Cryozonic Ltd (http://cryozonic.com)
 * @license    Commercial (See http://cryozonic.com/licenses/stripe.html for details)
 */

namespace Cryozonic\StripePayments\Logger;

use Monolog\Logger;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;
    public $filePath;

    public function __construct(
        \Magento\Framework\Filesystem\DriverInterface $filesystem,
        \Magento\Framework\App\Filesystem\DirectoryList $dir
    ) {
        $ds = DIRECTORY_SEPARATOR;
        $this->filePath = $dir->getPath('log') . $ds . 'cryozonic_stripe_webhooks.log';

        parent::__construct($filesystem, $this->filePath);
    }

    public function exists()
    {
        return file_exists($this->filePath);
    }
}