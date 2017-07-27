<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Acs\GoogleTagManager\CustomerData;

use Magento\Checkout\CustomerData\ItemPoolInterface;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Acs\GoogleTagManager\Model\Session as GtmSession;

/**
 * Cart source
 */
class GtmCart extends \Magento\Framework\DataObject implements SectionSourceInterface
{
    private $gtmSession;

    /**
     * GtmCart constructor.
     * @param GtmSession $gtmSession
     * @param array $data
     */
    public function __construct(
        GtmSession $gtmSession,
        array $data = []
    ) {
        parent::__construct($data);
        $this->gtmSession = $gtmSession;
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        $product = $this->gtmSession->getAddedToCartProduct();
        if ($product) {
            return [
                'product' => array('Data del producto')
            ];
        }
    }
}
