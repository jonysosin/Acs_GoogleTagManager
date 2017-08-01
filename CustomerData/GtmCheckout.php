<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Acs\GoogleTagManager\CustomerData;

use Acs\GoogleTagManager\Model\Session as GtmSession;
use Acs\GoogleTagManager\Helper\Data as GtmHelper;
use Magento\Checkout\CustomerData\ItemPoolInterface;

class GtmCheckout extends \Magento\Checkout\CustomerData\Cart
{
    /**
     * @var \Acs\GoogleTagManager\Helper\Data GtmHelper
     */
    private $gtmHelper;

    /**
     * GtmCheckout constructor.
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Catalog\Model\ResourceModel\Url $catalogUrl
     * @param \Magento\Checkout\Model\Cart $checkoutCart
     * @param \Magento\Checkout\Helper\Data $checkoutHelper
     * @param ItemPoolInterface $itemPoolInterface
     * @param \Magento\Framework\View\LayoutInterface $layout
     * @param array $data
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Model\ResourceModel\Url $catalogUrl,
        \Magento\Checkout\Model\Cart $checkoutCart,
        \Magento\Checkout\Helper\Data $checkoutHelper,
        ItemPoolInterface $itemPoolInterface,
        \Magento\Framework\View\LayoutInterface $layout,
        array $data = []
    ) {
        parent::__construct($checkoutSession,$catalogUrl,
            $checkoutCart,
            $checkoutHelper,
            $itemPoolInterface,
            $layout,
            $data
        );
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->gtmHelper = $objectManager->create('Acs\GoogleTagManager\Helper\Data');
    }

    /**
     * Get array of last added items
     *
     * @return \Magento\Quote\Model\Quote\Item[]
     */
    protected function getRecentItems()
    {
        $items = [];
        if (!$this->getSummaryCount()) {
            return $items;
        }

        foreach (array_reverse($this->getAllQuoteItems()) as $item) {
            $itemData = null;

            /* @var $item \Magento\Quote\Model\Quote\Item */
            if (!$item->getProduct()->isVisibleInSiteVisibility()) {
                $product =  $item->getOptionByCode('product_type') !== null
                    ? $item->getOptionByCode('product_type')->getProduct()
                    : $item->getProduct();

                $products = $this->catalogUrl->getRewriteByProductStore([$product->getId() => $item->getStoreId()]);
                if (!isset($products[$product->getId()])) {
                    continue;
                }
                $urlDataObject = new \Magento\Framework\DataObject($products[$product->getId()]);
                $item->getProduct()->setUrlDataObject($urlDataObject);
            }
            $itemData = $this->itemPoolInterface->getItemData($item);
            $gtmData = $this->gtmHelper->setProduct($item->getProduct())->getDataProduct();
            $gtmData['quantity'] = $itemData['qty'];
            $itemData['gtm'] = $gtmData;
            $items[] = $itemData;
        }
        return $items;
    }
}