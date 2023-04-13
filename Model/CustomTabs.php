<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use DeveloperHub\ProductCustomTabs\Api\Data\CustomTabsInterface;
use DeveloperHub\ProductCustomTabs\Model\ResourceModel\CustomTabs as CustomTabsResourceModel;

class CustomTabs extends AbstractExtensibleModel implements CustomTabsInterface
{
    /** @return void */
    public function _construct()
    {
        $this->_init(CustomTabsResourceModel::class);
    }

    /**
     * @param $value
     * @return CustomTabs
     */
    public function setTabId($value)
    {
        return $this->setData(self::TAB_ID, $value);
    }

    /**
     * @param $tabTitle
     * @return CustomTabs
     */
    public function setTabTitle($tabTitle)
    {
        return $this->setData(self::TAB_TITLE, $tabTitle);
    }

    /**
     * @param $tabSortOrder
     * @return CustomTabs
     */
    public function setTabSortOrder($tabSortOrder)
    {
        return $this->setData(self::TAB_SORT_ORDER, $tabSortOrder);
    }

    /**
     * @param $tabContent
     * @return CustomTabs
     */
    public function setTabContent($tabContent)
    {
        return $this->setData(self::TAB_CONTENT, $tabContent);
    }

    /**
     * @param $productId
     * @return CustomTabs
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @param $attributeSet
     * @return CustomTabs
     */
    public function setAttributeSet($attributeSet)
    {
        return $this->setData(self::ATTRIBUTE_SET, $attributeSet);
    }

    /**
     * @param $allProducts
     * @return CustomTabs
     */
    public function setAllProducts($allProducts)
    {
        return $this->setData(self::ALL_PRODUCTS, $allProducts);
    }

    /**
     * @param $categories
     * @return CustomTabs
     */
    public function setCategories($categories)
    {
        return $this->setData(self::CATEGORIES, $categories);
    }

    /**
     * @param $selectType
     * @return CustomTabs
     */
    public function setSelectType($selectType)
    {
        return $this->setData(self::SELECT_TYPE, $selectType);
    }

    /**
     * @param $enable
     * @return CustomTabs
     */
    public function setEnableTab($enable)
    {
        return $this->setData(self::TAB_ENABLE, $enable);
    }

    /** @return int */
    public function getTabId()
    {
        return $this->getData(self::TAB_ID);
    }

    /** @return string */
    public function getTabTitle()
    {
        return $this->getData(self::TAB_TITLE);
    }

    /** @return int */
    public function getTabSortOrder()
    {
        return $this->getData(self::TAB_SORT_ORDER);
    }

    /** @return string */
    public function getTabContent()
    {
        return $this->getData(self::TAB_CONTENT);
    }

    /** @return string */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /** @return string */
    public function getAttributeSet()
    {
        return $this->getData(self::ATTRIBUTE_SET);
    }

    /** @return string */
    public function getCategories()
    {
        return $this->getData(self::CATEGORIES);
    }

    /** @return string */
    public function getSelectType()
    {
        return $this->getData(self::SELECT_TYPE);
    }

    /** @return string */
    public function getAllProducts()
    {
        return $this->getData(self::ALL_PRODUCTS);
    }

    /** @return mixed */
    public function getEnableTab()
    {
        return $this->getData(self::TAB_ENABLE);
    }
}
