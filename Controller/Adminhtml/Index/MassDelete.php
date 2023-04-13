<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use DeveloperHub\ProductCustomTabs\Helper\ProcessData;

class MassDelete extends Action
{
    /** @var ProcessData */
    private $processData;

    /**
     * @param Context $context
     * @param ProcessData $processData
     */
    public function __construct(Context $context, ProcessData $processData)
    {
        parent::__construct($context);
        $this->processData = $processData;
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        return $this->processData->tabStatus("deleted");
    }
}
