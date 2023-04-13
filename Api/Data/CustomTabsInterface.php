<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface CustomTabsInterface extends ExtensibleDataInterface
{
    /** Fields of  custom tabs*/
    const TAB_ID = 'id';
    const TAB_TITLE = 'title';
    const TAB_SORT_ORDER = 'sort_order';
    const TAB_CONTENT = 'content';
    const PRODUCT_ID = 'product_id';
    const ATTRIBUTE_SET = 'attribute_set';
    const SELECT_TYPE = 'select_type';
    const ALL_PRODUCTS = 'allProducts';
    const CATEGORIES = "categories";
    const TAB_ENABLE = "enable_tab";

    /** @param int $value */
    public function setTabId($value);

    /** @param string $tabTitle */
    public function setTabTitle($tabTitle);

    /** @param int $tabSortOrder */
    public function setTabSortOrder($tabSortOrder);

    /** @param string $tabContent */
    public function setTabContent($tabContent);

    /** @param string $productId */
    public function setProductId($productId);

    /** @param string $attributeSet */
    public function setAttributeSet($attributeSet);

    /** @param string $selectType  */
    public function setSelectType($selectType);

    /** @param string $allProducts */
    public function setAllProducts($allProducts);

    /** @param string $categories */
    public function setCategories($categories);

    /** @param boolean $enable */
    public function setEnableTab($enable);

    /** @return int */
    public function getTabId();

    /** @return string */
    public function getTabTitle();

    /** @return int */
    public function getTabSortOrder();

    /** @return string */
    public function getTabContent();

    /** @return string */
    public function getProductId();

    /** @return string */
    public function getAttributeSet();

    /** @return string */

    public function getSelectType();

    /** @return string */
    public function getAllProducts();

    /** @return string */
    public function getCategories();

    /** @return boolean */
    public function getEnableTab();
}
