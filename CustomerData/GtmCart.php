<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Acs\GoogleTagManager\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Acs\GoogleTagManager\Model\Session as GtmSession;
use Acs\GoogleTagManager\Helper\Data as GtmHelper;

/**
 * Cart source
 */
class GtmCart extends \Magento\Framework\DataObject implements SectionSourceInterface
{
    private $gtmSession;
    /**
     * @var GtmHelper
     */
    private $gtmHelper;

    /**
     * GtmCart constructor.
     * @param GtmSession $gtmSession
     * @param GtmHelper $gtmHelper
     * @param array $data
     */
    public function __construct(
        GtmSession $gtmSession,
        GtmHelper $gtmHelper,
        array $data = []
    ) {
        parent::__construct($data);
        $this->gtmSession = $gtmSession;
        $this->gtmHelper = $gtmHelper;
    }

    /**
     * @return array
     */
    public function getSectionData()
    {
        $product = $this->gtmSession->getAddedToCartProduct();
        $data = [];
        if ($product) {
            $data =['products' => $this->gtmHelper->setProduct($product)->getDataProduct()];
        }

        return $data;
    }
}
