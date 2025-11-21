<?php
namespace Hivecraft\FacebookTracking\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Client;

class ApiClient
{
    const XML_PATH_ENABLED = 'facebooktracking/general/enabled';
    const XML_PATH_PIXEL_ID = 'facebooktracking/general/pixel_id';
    const XML_PATH_ACCESS_TOKEN = 'facebooktracking/general/access_token';

    protected $scopeConfig;
    protected $logger;
    protected $httpClient;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger,
        Client $httpClient
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->httpClient = $httpClient;
    }

    public function sendPurchaseEvent(Order $order)
    {
        if (!$this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE)) {
            return;
        }

        $pixelId = $this->scopeConfig->getValue(self::XML_PATH_PIXEL_ID, ScopeInterface::SCOPE_STORE);
        $accessToken = $this->scopeConfig->getValue(self::XML_PATH_ACCESS_TOKEN, ScopeInterface::SCOPE_STORE);

        if (!$pixelId || !$accessToken) {
            return;
        }

        $email = $order->getCustomerEmail();
        $amount = $order->getGrandTotal();
        $currency = $order->getOrderCurrencyCode();
        $orderId = $order->getIncrementId();

        $payload = [
            'data' => [
                [
                    'event_name' => 'Purchase',
                    'event_time' => time(),
                    'action_source' => 'website',
                    'event_source_url' => $order->getStore()->getBaseUrl() . 'checkout/onepage/success/',
                    'user_data' => [
                        'em' => hash('sha256', strtolower($email)),
                        'client_ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                        'client_user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                    ],
                    'custom_data' => [
                        'currency' => $currency,
                        'value' => $amount,
                        'order_id' => $orderId,
                    ]
                ]
            ]
        ];

        try {
            $res = $this->httpClient->request('POST', "https://graph.facebook.com/v18.0/{$pixelId}/events", [
                'query' => ['access_token' => $accessToken],
                'json' => $payload
            ]);

            $this->logger->info('Facebook CAPI purchase sent. Response: ' . $res->getBody());
        } catch (\Exception $e) {
            $this->logger->error('Facebook CAPI Error: ' . $e->getMessage());
        }
    }
}
