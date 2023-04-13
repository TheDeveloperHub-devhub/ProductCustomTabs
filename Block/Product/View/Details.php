<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Block\Product\View;

use Magento\Catalog\Block\Product\View;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use DeveloperHub\ProductCustomTabs\Helper\Config;
use Magento\Catalog\Model\ProductRepository;
use Magento\Catalog\Api\AttributeSetRepositoryInterface;
use DeveloperHub\ProductCustomTabs\Model\ResourceModel\CustomTabs\Collection;
use DeveloperHub\ProductCustomTabs\Model\ResourceModel\CustomTabs\CollectionFactory;
use function PHPUnit\Framework\callback;

class Details extends Template
{
    /** @var array */
    protected $tabs = [];

    /** @var Config */
    protected $configData;

    /** @var ProductRepository */
    protected $productRepository;

    /** @var AttributeSetRepositoryInterface */
    protected $attributeSetRepository;

    /** @var CollectionFactory */
    protected $customTabsCollection;

    /**
     * @param CollectionFactory $customTabsCollection
     * @param Config $configData
     * @param ProductRepository $productRepository
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        CollectionFactory $customTabsCollection,
        Config $configData,
        ProductRepository $productRepository,
        AttributeSetRepositoryInterface $attributeSetRepository,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->configData = $configData;
        $this->productRepository = $productRepository;
        $this->attributeSetRepository = $attributeSetRepository;
        $this->customTabsCollection = $customTabsCollection;
    }

    /**
     * Get sorted child block names.
     *
     * @param string $groupName
     * @param string $callback
     * @return array
     * @throws LocalizedException
     *
     */
    public function getGroupSortedChildNames(string $groupName, string $callback): array
    {
        $groupChildNames = $this->getGroupChildNames($groupName);
        $childNamesSortOrder = [];
        $hideDefaultTabs = $this->configData->HideDefaultTabsEnabled();
        if (!$hideDefaultTabs) {
            $layout = $this->getLayout();
            foreach ($groupChildNames as $childName) {
                $alias = $layout->getElementAlias($childName);
                $sortOrder = (int)$this->getChildData($alias, 'sort_order') ?? 0;
                $childNamesSortOrder[$childName] = $sortOrder;
            }
        }
        if (!empty($customTabs = $this->tabs)) {
            foreach ($customTabs as $tab) {
                $sortOrder = (int)$tab["sort_order"];
                $childNamesSortOrder["product.info.details.{$tab['title']}"] = $sortOrder;
            }
        }
        asort($childNamesSortOrder, SORT_NUMERIC);
        return array_keys($childNamesSortOrder);
    }

    /**
     * @param $block
     * @param $tabs
     * @return void
     */
    public function AddCustomTabs($block, $tabs)
    {
        foreach ($tabs as $key => $tab) {
            $block->addChild(
                $key,
                View::class,
                [
                    "template" => "DeveloperHub_ProductCustomTabs::product/View/custom_tab-render.phtml",
                    "title" => $tab['title'] ?? "",
                    "sort_order" => $tab['sort_order'] ?? 0,
                    "css_class" => "mycustomtabs",
                    "content" => $tab['content'] ?? ""
                ]
            );
        }
    }

    /**
     * @param $layout
     * @param $id
     * @return void
     * @throws NoSuchEntityException
     * @throws \Zend_Db_Select_Exception
     */
    public function productContainCustomTab($layout, $id)
    {
        $id = implode($id);
        $product = $this->productRepository->getById($id);
        $productAttributeSetId = $product->getData('attribute_set_id');
        $category_ids = $product->getData("category_ids");
        $attributeSet = $this->attributeSetRepository->get($productAttributeSetId);
        $attributeSetName = $attributeSet->getData("attribute_set_name");
        $result = $this->fetchDesiredTabs($id, $attributeSetName, $category_ids);
        if ($result->getItems()) {
            foreach ($result as $tab) {
                $this->tabs[$tab->getData('title')] = $tab->getData();
            }
            $block = $layout->getBlock("product.info.details");
            if ($block) {
                $this->AddCustomTabs($block, $this->tabs);
            }
        }
    }

    /**
     * @param $id
     * @param $attributeSetName
     * @param $category_ids
     * @return Collection
     * @throws \Zend_Db_Select_Exception
     */
    public function fetchDesiredTabs($id, $attributeSetName, $category_ids)
    {
        $result = $this->customTabsCollection->create()
            ->addFieldToFilter(
                ['product_id', 'allProducts', 'attribute_set'],
                [
                    ['finset' => [$id]],
                    ['eq' => "1"],
                    ['finset' => [$attributeSetName]]
                ]
            )->addFieldToFilter('enable_tab', ['eq' => '1']);
        $where = $result->getSelect()->getPart('where');
        foreach ($category_ids as $id) {
            $where[0] = $where[0] . ' OR (FIND_IN_SET(' . $id . ', `categories`))';
        }
        $where[0] = '(' . $where[0] . ')';
        $result->getSelect()->setPart('where', $where);
        return $result;
    }
}
