<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class NewTab extends Action
{
    /**
     * @return ResponseInterface|ResultInterface|null
     */
    public function execute()
    {
        return $this->_forward("edit");
    }
}
