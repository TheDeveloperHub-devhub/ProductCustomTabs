<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Ui;

use Exception;
use Magento\Catalog\Api\CategoryListInterface;
use Magento\Catalog\Api\Data\CategorySearchResultsInterface;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Api\SearchCriteriaBuilder;

class CategoriesListProvider extends AbstractSource
{
    /** @var CategoryListInterface */
    protected $categoryList;

    /** @var SearchCriteriaBuilder */
    protected $searchCriteriaBuilder;

    /**
     * @param CategoryListInterface $categoryList
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        CategoryListInterface $categoryList,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->categoryList = $categoryList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return array|CategorySearchResultsInterface
     * @throws Exception
     */
    public function listCategories()
    {
        $categoryList = [];
        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $categorySet = $this->categoryList->getList($searchCriteria);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        if ($categorySet->getTotalCount()) {
            $categoryList = $categorySet;
        }

        return $categoryList;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getOptionArray()
    {
        $options = [];
        $categoryList = $this->listCategories();
        if ($categoryList) {
            foreach ($categoryList->getItems() as $list) {
                $options[$list->getEntityId()] = $list->getName();
            }
        }
        return $options;
    }

    /** @return array */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
