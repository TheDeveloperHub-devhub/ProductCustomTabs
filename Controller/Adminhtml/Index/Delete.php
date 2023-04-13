<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Controller\Adminhtml\Index;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use DeveloperHub\ProductCustomTabs\Model\CustomTabsRepository as CustomTabRepo;

class Delete extends Action
{
    /** @var CustomTabRepo */
    private $customTabRepo;

    /**
     * @param Context $context
     * @param CustomTabRepo $customTabRepo
     */
    public function __construct(
        Context $context,
        CustomTabRepo $customTabRepo
    ) {
        parent::__construct($context);
        $this->customTabRepo = $customTabRepo;
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface|void
     * @throws Exception
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $this->customTabRepo->deleteById($id);
            $this->messageManager->addSuccessMessage("Yous tab have been deleted");
        }

        return $this->_redirect('*/*/');
    }
}
