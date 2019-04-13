<?php

/**
 * @copyright  Copyright 2017 SplashLab
 */

namespace SplashLab\CorsRequests\Plugin;

use Magento\Framework\App\FrontControllerInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Class CorsHeadersPlugin
 *
 * @package SplashLab\CorsRequests
 */
class CorsHeadersPlugin
{

    /**
     * @var \Magento\Framework\Webapi\Rest\Response
     */
    private $response;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\Webapi\Rest\Response $response
     * @param \Magento\Framework\App\Config\ScopeConfigInterface scopeConfig
     */
    public function __construct(
        \Magento\Framework\Webapi\Rest\Response $response,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->response = $response;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return string
     */
    protected function getAllowAllAccess()
    {
        return $this->scopeConfig->getValue('web/corsRequests/allowStarAtStart',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return string
     */
    protected function getOriginUrl()
    {
        return $this->scopeConfig->getValue('web/corsRequests/origin_url',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return string
     */
    protected function getMobileOriginUrl()
    {
        return $this->scopeConfig->getValue('web/corsRequests/mobile_url',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return string
     */
    protected function getMobileOriginIp()
    {
        return $this->scopeConfig->getValue('web/corsRequests/mobile_ip',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get the origin domain the requests are going to come from
     * @return string
     */
    protected function getAllowCredentials()
    {
        return (bool) $this->scopeConfig->getValue('web/corsRequests/allow_credentials',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Triggers before original dispatch
     * This method triggers before original \Magento\Webapi\Controller\Rest::dispatch and set version
     * from request params to VersionManager instance
     * @param FrontControllerInterface $subject
     * @param RequestInterface $request
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeDispatch(
        FrontControllerInterface $subject,
        RequestInterface $request
    )
    {
        /*$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/server.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);*/
        $originUrl = $mobileOriginUrl = $mobileIpAddress = "";
        $originUrl = $this->getOriginUrl();
        $mobileOriginUrl = $this->getMobileOriginUrl();
        $mobileIpAddress = $this->getMobileOriginIp();

        /*
         * BKWYADMIN-1272
         * Allow All (*) at first, so that some specific Urls which has issues will be fixed
         */
        if($this->getAllowAllAccess())
        {
            $this->response->setHeader('Access-Control-Allow-Origin', rtrim("*","/"), true);
            if ($this->getAllowCredentials())
            {
                $this->response->setHeader('Access-Control-Allow-Credentials', 'true', true);
            }            
        }

        if(isset($_SERVER["HTTP_ORIGIN"]))
        {
            if($originUrl != "" && $_SERVER["HTTP_ORIGIN"] == $originUrl)
            {
                $this->response->setHeader('Access-Control-Allow-Origin', rtrim($originUrl,"/"), true);
                if ($this->getAllowCredentials())
                {
                    $this->response->setHeader('Access-Control-Allow-Credentials', 'true', true);
                }
            }
            if($mobileOriginUrl != "" && $_SERVER["HTTP_ORIGIN"] == $mobileOriginUrl)
            {
                $this->response->setHeader('Access-Control-Allow-Origin', rtrim($mobileOriginUrl,"/"), true);
                if ($this->getAllowCredentials())
                {
                    $this->response->setHeader('Access-Control-Allow-Credentials', 'true', true);
                }
            }
        }

        if(isset($_SERVER["HTTP_USER_AGENT"]))
        {
            if(strpos($_SERVER["HTTP_USER_AGENT"], 'node-fetch') !== false)
            {
                $this->response->setHeader('Access-Control-Allow-Origin', rtrim($mobileIpAddress,"/"), true);
                if ($this->getAllowCredentials())
                {
                    $this->response->setHeader('Access-Control-Allow-Credentials', 'true', true);
                }
            }
        }
    }
}