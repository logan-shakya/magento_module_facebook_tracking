<?php
namespace Hivecraft\FacebookTracking\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Pixel extends Template
{
    protected $scopeConfig;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'facebooktracking/general/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getPixelId()
    {
        return $this->scopeConfig->getValue(
            'facebooktracking/general/pixel_id',
            ScopeInterface::SCOPE_STORE
        );
    }
}
