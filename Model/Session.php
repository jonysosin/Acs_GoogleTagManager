<?php
namespace Acs\GoogleTagManager\Model;

use Magento\Framework\App\Helper\Context;

class Session extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Catalog\Model\Session
     */
    private $catalogSession;

    /**
     * Session constructor.
     * @param \Magento\Catalog\Model\Session $catalogSession
     * @param Context $context
     */
    public function __construct(\Magento\Catalog\Model\Session $catalogSession, Context $context) {
        parent::__construct($context);
        $this->catalogSession = $catalogSession;
    }

    public function setAddedToCartProduct($product)
    {
        $this->catalogSession->setAddedToCartProduct($product);
    }

    public function getAddedToCartProduct()
    {
        $product = $this->catalogSession->getAddedToCartProduct();
        $this->catalogSession->unsAddedToCartProduct();
        return $product;
    }
}
