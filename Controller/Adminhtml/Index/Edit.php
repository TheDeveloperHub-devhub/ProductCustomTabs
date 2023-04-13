<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Edit extends Action
{
    /** @return ResponseInterface|ResultInterface */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $id = $this->getRequest()->getParam('id');
        $resultPage->getConfig()->getTitle()
            ->prepend($id ? __('Edit Tab') : __('New Tab'));
        return $resultPage;
    }
}
