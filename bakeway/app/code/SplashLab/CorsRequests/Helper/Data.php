<?php

namespace SplashLab\CorsRequests\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper 
{
    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context)
    {
        parent::__construct($context);
    }

    public function getCorsAccessControlUrl()
    {
        $corsOriginUrl = $allowAllAccess = $originUrl = $mobileOriginUrl = $mobileIpAddress = "";
        $allowAllAccess = $this->scopeConfig->getValue('web/corsRequests/allowStarAtStart',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $originUrl =  $this->scopeConfig->getValue('web/corsRequests/origin_url',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);        
        $mobileOriginUrl = $this->scopeConfig->getValue('web/corsRequests/mobile_url',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $mobileIpAddress = $this->scopeConfig->getValue('web/corsRequests/mobile_ip',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        if(isset($_SERVER["HTTP_ORIGIN"]))
        {
            if($originUrl != "" && $_SERVER["HTTP_ORIGIN"] == $originUrl)
            {
                $corsOriginUrl = $originUrl;
            }
            
            if($mobileOriginUrl != "" && $_SERVER["HTTP_ORIGIN"] == $mobileOriginUrl)
            {
                $corsOriginUrl = $mobileOriginUrl;
            }
        }

        if(isset($_SERVER["HTTP_USER_AGENT"]))
        {
            if(strpos($_SERVER["HTTP_USER_AGENT"], 'node-fetch') !== false)
            {
                $corsOriginUrl = $mobileIpAddress;
            }
        }

        if($corsOriginUrl && $corsOriginUrl != "")
        {
            return $corsOriginUrl;
        }
        else
        {
            if($allowAllAccess && $allowAllAccess != "")
                $corsOriginUrl = "*";
            else
                $corsOriginUrl = false;

            return $corsOriginUrl;
        }        
    }
}
