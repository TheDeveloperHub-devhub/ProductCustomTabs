<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use DeveloperHub\ProductCustomTabs\Helper\ProcessData;

class Save extends Action
{
    /** @var ProcessData */
    protected $processData;

    /**
     * @param Context $context
     * @param ProcessData $processData
     */
    public function __construct(
        Context $context,
        ProcessData $processData
    ) {
        parent::__construct($context);
        $this->processData = $processData;
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface|void|null
     */
    public function execute()
    {
        $request =  $this->getRequest()->getParams();
        if (!empty($request)) {
            return $this->processData->processRequestAndSave($request);
        } else {
            return $this->_redirect("*/*/");
        }
    }
}
