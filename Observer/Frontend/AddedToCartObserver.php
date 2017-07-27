<?php
namespace Acs\GoogleTagManager\Observer\Frontend;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Acs\GoogleTagManager\Model\Session as GtmSession;

class AddedToCartObserver implements ObserverInterface
{
    private $gtmSession;

    public function __construct(
        GtmSession $gtmSession
    ) {
        $this->gtmSession = $gtmSession;
    }

    /**
     * @param Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Observer $observer)
    {
        if ($product = $observer->getEvent()->getProduct())
        {
            $this->gtmSession->setAddedToCartProduct($product);
        }
    }
}