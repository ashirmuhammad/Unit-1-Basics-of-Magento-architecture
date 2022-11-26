<?php

declare(strict_types=1);

namespace RLTSquare\EmailTask\Helper;

use Exception;
use Magento\Email\Model\BackendTemplate;
use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\Store;
use Psr\Log\LoggerInterface;

/**
 * class for setting email template
 */
class Email extends AbstractHelper
{
    /**
     * @var ScopeConfigInterface
     */
    public $scopeConfig;
    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var TransportBuilder
     */
    protected TransportBuilder $transportBuilder;
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;
    /**
     * @var BackendTemplate
     */
    protected BackendTemplate $emailTemplate;

    /**
     * @param Context $context
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param BackendTemplate $emailTemplate
     */
    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        BackendTemplate $emailTemplate

    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->emailTemplate = $emailTemplate;
        $this->logger = $context->getLogger();
    }

    /**
     * @return void
     */
    public function sendEmail()
    {
        try {
            $email_template = $this->emailTemplate->load('testing_email_template', 'orig_template_code');
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => 'Muhammad',
                'email' => 'muhammad.ashir@rltsquare.com',
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($email_template->getId())
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'templateVar' => 'My Email'
                ])
                ->setFrom($sender)
                ->addTo('ashir.muhammad110@gmail.com')
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
