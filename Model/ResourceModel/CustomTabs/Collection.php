<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Model\ResourceModel\CustomTabs;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use DeveloperHub\ProductCustomTabs\Model\CustomTabs as CustomTabsModel;
use DeveloperHub\ProductCustomTabs\Model\ResourceModel\CustomTabs as CustomTabsResourceModel;

class Collection extends AbstractCollection
{
    /** @return void */
    public function _construct()
    {
        $this->_init(CustomTabsModel::class, CustomTabsResourceModel::class);
    }
}
