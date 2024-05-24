<?php
/**
 * Copyright &copy; Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace EricObreque\FslPayment\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class FslPayment implements ObserverInterface
{

    /**
     * @var $messageManager
     */
    protected $messageManager;

    public function __construct(
        ManagerInterface $messageManager
    )
    {
        $this->messageManager = $messageManager;
    }

    public function execute(Observer $observer)
    {
        $quote = $observer->getEvent()->getQuote();
        $subTotal = $quote->getSubtotal();

        $this->messageManager->addError(__("Error. You must add an even number."));

        if($subTotal % 2 != 0){
            $redirect = $observer->getEvent()->getRedirect();
            $redirect->setRedirect(true)->setPath('checkout')->setArguments([]);
        }
    }
}
