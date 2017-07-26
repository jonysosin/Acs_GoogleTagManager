<?php
namespace Acs\GoogleTagManager\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ACTIVE = 'google/googletagmanager/active';
    const XML_PATH_ACCOUNT = 'google/googletagmanager/account';

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Whether Tag Manager is ready to use
     *
     * @return bool
     */
    public function isEnabled() {
        $accountId = $this->scopeConfig->getValue(
            self::XML_PATH_ACCOUNT, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        
        return $accountId && $this->scopeConfig->isSetFlag(self::XML_PATH_ACTIVE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get Tag Manager Account ID
     *
     * @return bool | null | string
     */
    public function getAccountId() {
        return $this->scopeConfig->getValue(self::XML_PATH_ACCOUNT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

}
