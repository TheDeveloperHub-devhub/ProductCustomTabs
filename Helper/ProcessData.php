<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Helper;

use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Ui\Component\MassAction\Filter;
use DeveloperHub\ProductCustomTabs\Model\CustomTabs as CustomTabsModel;
use DeveloperHub\ProductCustomTabs\Model\CustomTabsRepository as CustomTabsRepo;
use DeveloperHub\ProductCustomTabs\Model\ResourceModel\CustomTabs\CollectionFactory;

class ProcessData extends AbstractHelper
{
    /** @var ResultFactory */
    private $resultFactory;

    /** @var Filter */
    private $filter;

    /** @var CollectionFactory */
    private $collectionFactory;

    /** @var ResourceConnection */
    private $_resource;

    /** @var ManagerInterface */
    private $messageManager;

    /**  @var CustomTabsModel */
    private $customTab;

    /** @var CustomTabsRepo */
    private $customTabRepo;

    /** @var RedirectFactory */
    private $resultRedirectFactory;

    /** @var Configurable */
    private $configurable;

    /**
     * @param Context $context
     * @param ManagerInterface $messageManager
     * @param CustomTabsModel $customTab
     * @param CustomTabsRepo $customTabRepo
     * @param RedirectFactory $resultRedirectFactory
     * @param Configurable $configurable
     * @param ResourceConnection $_resource
     * @param ResultFactory $resultFactory
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        ManagerInterface $messageManager,
        CustomTabsModel $customTab,
        CustomTabsRepo $customTabRepo,
        RedirectFactory $resultRedirectFactory,
        Configurable $configurable,
        ResourceConnection $_resource,
        ResultFactory $resultFactory,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context);
        $this->messageManager = $messageManager;
        $this->customTab = $customTab;
        $this->customTabRepo = $customTabRepo;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->configurable = $configurable;
        $this->_resource = $_resource;
        $this->resultFactory = $resultFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param $content
     * @return mixed
     */
    public function manipulateContentData($content)
    {
        $om = ObjectManager::getInstance();
        return $om->get('Magento\Cms\Model\Template\FilterProvider')->getPageFilter()->filter($content);
    }

    /**
     * @param $request
     * @return Redirect|void
     */
    public function processRequestAndSave($request)
    {
        $showMessage = "Tab Created Successfully.";
        try {
            $title = $request['title'] ?? '';
            $sort_order = $request['sort_order'] ?? '';
            $content = $request['content'] ?? '';
            $selectType = $request['select_type'] ?? '';
            $productIds = $request['product_id']?? '';
            $enableTab = $request['enable_tab'];
            $categoriesSet = $request["categories"];
            $attributeSet = $request['attribute_set'];

            $attributeSet = $attributeSet ? implode(',', $request['attribute_set']) : "";
            $categoriesSet = $categoriesSet ? implode(',', $request['categories']) : "";
            $productId = $productIds ? $this->processIds($productIds) : "";
            $productId = str_replace(' ', '', $productId);
            $allProducts = ($selectType == 1) ? "1" : "";
            if (isset($request['id'])) {
                $this->customTab->setTabId($request['id']);
                $showMessage = "Tab Updated Successfully.";
            }
            $this->customTab->setTabTitle($title);
            $this->customTab->setTabSortOrder($sort_order);
            $this->customTab->setTabContent($content);
            $this->customTab->setProductId($productId);
            $this->customTab->setEnableTab($enableTab);
            $this->customTab->setAllProducts($allProducts);
            $this->customTab->setSelectType($selectType);
            $this->customTab->setAttributeSet($attributeSet);
            $this->customTab->setCategories($categoriesSet);
            $this->customTabRepo->save($this->customTab);
            $this->messageManager->addSuccessMessage(__($showMessage));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customtabs/index/index');
            return $resultRedirect;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("Please try again! Problem with Creating Tab."));
        }
    }

    /**
     * @param $productIds
     * @return string
     */
    public function processIds($productIds)
    {
        $productIds = explode(',', $productIds ?? '');
        $ids = [];
        foreach ($productIds as $id) {
            $parentProductId = $this->configurable->getParentIdsByChild($id);
            if ($parentProductId) {
                $id = $parentProductId[0];
            }
            array_push($ids, $id);
        }
        return $ids = implode(',', $ids);
    }

    /**
     * @param $actionName
     * @param string $setTabStatus
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function tabStatus($actionName, string $setTabStatus = "")
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        $selected = $collection->getAllIds();
        $connection = $this->_resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $tableName = $connection->getTableName("developerhub_product_custom_tabs");
        if ($actionName == "deleted") {
            foreach ($collection as $item) {
                $item->delete();
            }
        } else {
            foreach ($selected as $select) {
                $connection->update(
                    $tableName,
                    ['enable_tab' => $setTabStatus],
                    $connection->quoteInto('id = ?', $select)
                );
            }
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 tab(s) have been ' . $actionName . '', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
