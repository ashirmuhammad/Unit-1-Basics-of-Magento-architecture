<?php

declare(strict_types=1);

namespace RLTSquare\EmailTask\Controller\Index;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\View\Result\PageFactory;
use RLTSquare\EmailTask\Logger\Logger;
use RLTSquare\EmailTask\Helper\Email;

/**
 * class for showing a string
 */
class Index implements ActionInterface
{
    /**
     * @var PageFactory
     */
    protected PageFactory $pageFactory;
    /**
     * @var Logger
     */
    protected Logger $logger;
    /**
     * @var Email
     */
    protected Email $helperEmail;
    /**
     * @param PageFactory $pageFactory
     * @param Logger $logger
     * @param Email $helperEmail
     */
    public function __construct(
        PageFactory $pageFactory,
        Logger $logger,
        Email $helperEmail,
    ) {
        $this->pageFactory = $pageFactory;
        $this->logger = $logger;
        $this->helperEmail = $helperEmail;
    }

    /**
     * @inheriDoc
     */
    public function execute()
    {
        $this->helperEmail->sendEmail();
        $this->logger->info('Page Visited');
        $pageFactory =  $this->pageFactory->create();
        $pageFactory->getConfig()->getTitle()->set('Welcome to RLTSquare  ...!!!');
        return $pageFactory;
    }
}
