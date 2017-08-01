<?php

namespace Acs\GoogleTagManager\Block;

use Magento\Framework\View\Element\Template\Context;
use Acs\GoogleTagManager\Helper\Data as GtmHelper;

/**
 * Google Tag Manager Page Block
 */
class GtmSuccess extends GtmCode {

    private $checkoutSession;

    /**
     * @param Context $context
     * @param GtmHelper $gtmHelper
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param array $data
     */
    public function __construct( Context $context,
                                 GtmHelper $gtmHelper,
                                 \Magento\Checkout\Model\Session $checkoutSession,
                                 array $data = [])
    {
        parent::__construct($context, $gtmHelper, $data);
        $this->checkoutSession = $checkoutSession;
    }

    public function getSuccessConfig() {
        $data = [];

        if ($order = $this->checkoutSession->getLastRealOrder()) {
            $data['actionField'] = [
                'id'  => $order->getIncrementId(),
                'shipping' => $order->getShippingAmount(),
                'revenue' => $order->getGrandTotal(),
                'tax' => $order->getTaxAmount()
            ];

            $products = [];
            foreach ($order->getItems() as $item) {
                $product = $this->_gtmHelper->setProduct($item->getProduct())->getDataProduct();
                $product['quantity'] = $item->getQtyOrdered();
                $products[] = $product;
            }
            $data['products'] = $products;

            if ($couponCode = $order->getCouponCode()) {
                $data['actionField']['coupon'] = $couponCode;
            }
        }

        return $data;
    }
}
