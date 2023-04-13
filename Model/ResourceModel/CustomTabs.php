<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomTabs extends AbstractDb
{
    /** Main table for Product Custom Tabs and its PK */
    const MAIN_TABLE = "developerhub_product_custom_tabs";
    const ID_FIELD_NAME = 'id';

    /** @return void */
    public function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
