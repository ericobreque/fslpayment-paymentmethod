<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace EricObreque\FslPayment\Model\Method;

use Magento\Framework\Pricing\PriceCurrencyInterface;

/**
 * Free payment method
 * @method \Magento\Quote\Api\Data\PaymentMethodExtensionInterface getExtensionAttributes()
 *
 * This is an implementation of payment method that allows order for free.
 * Magento contains special flow for handling this payment method.
 * Inheritance is allowed to modify it behavior.
 *
 * @api
 * @since 100.0.2
 */
class FslPayment extends \Magento\Payment\Model\Method\AbstractMethod
{
    const PAYMENT_METHOD_FSLPAYMENT_CODE = 'fslpayment';

    /**
     * XML Paths for configuration constants
     */
    const XML_PATH_PAYMENT_FSLPAYMENT_ACTIVE = 'payment/fslpayment/active';

    const XML_PATH_PAYMENT_FSLPAYMENT_ORDER_STATUS = 'payment/fslpayment/order_status';

    const XML_PATH_PAYMENT_FSLPAYMENT_PAYMENT_ACTION = 'payment/fslpayment/payment_action';

    /**
     * Payment Method features
     *
     * @var bool
     */
    protected $_canAuthorize = true;

    /**
     * Payment code name
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_FSLPAYMENT_CODE;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param \Magento\Payment\Helper\Data $paymentData
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param Logger $logger
     * @param PriceCurrencyInterface $priceCurrency
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $resource,
            $resourceCollection,
            $data
        );
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * Check whether method is available
     *
     * @param \Magento\Quote\Api\Data\CartInterface|\Magento\Quote\Model\Quote|null $quote
     * @return bool
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        return parent::isAvailable($quote);
    }

    /**
     * Check whether method is enabled in config
     *
     * @param \Magento\Quote\Model\Quote|null $quote
     * @return bool
     */
    public function isAvailableInConfig($quote = null)
    {
        return parent::isAvailable($quote);
    }

    /**
     * Get config payment action, do nothing if status is pending
     *
     * @return string|null
     */
    public function getConfigPaymentAction()
    {
        return $this->getConfigData('order_status') == 'pending' ? null : parent::getConfigPaymentAction();
    }
}
