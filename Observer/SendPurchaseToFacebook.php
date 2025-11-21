<?php
namespace Hivecraft\FacebookTracking\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Hivecraft\FacebookTracking\Model\ApiClient;

class SendPurchaseToFacebook implements ObserverInterface
{
    protected $checkoutSession;
    protected $apiClient;

    public function __construct(
        CheckoutSession $checkoutSession,
        ApiClient $apiClient
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->apiClient = $apiClient;
    }

    public function execute(Observer $observer)
    {
        $order = $this->checkoutSession->getLastRealOrder();
        if (!$order || !$order->getId()) return;

        $this->apiClient->sendPurchaseEvent($order);
    }
}
