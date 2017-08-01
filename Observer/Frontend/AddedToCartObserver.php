<?php
namespace Acs\GoogleTagManager\Observer\Frontend;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Acs\GoogleTagManager\Model\Session as GtmSession;

class AddedToCartObserver implements ObserverInterface
{
    private $gtmSession;
    /**
     * @var Magento\Framework\App\Action\Context
     */
    private $context;

    /**
     * AddedToCartObserver constructor.
     * @param GtmSession $gtmSession
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        GtmSession $gtmSession,
        \Magento\Framework\App\Action\Context $context
    ) {
        $this->gtmSession = $gtmSession;
        $this->context = $context;
        $this->_objectManager = $this->context->getObjectManager();
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
            $params = $request = $observer->getEvent()->getRequest()->getParams();
            if (isset($params['qty'])) {
                $filter = new \Zend_Filter_LocalizedToNormalized(
                    ['locale' => $this->_objectManager->get('Magento\Framework\Locale\ResolverInterface')->getLocale()]
                );
                $params['qty'] = $filter->filter($params['qty']);
                $product->setGtmQuantity($params['qty']);
            }
            $this->gtmSession->setAddedToCartProduct($product);
        }
    }
}