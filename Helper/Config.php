<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Config extends AbstractHelper
{
    /** Configuration Path of Database */
    const XML_PATH_ENABLED ='addCustomAttributeToProduct/general/enabled';
    const HIDE_DEFAULT_TAB_ENABLE= "addCustomAttributeToProduct/general/hide_default_tabs";

    /** @return bool */
    public function ShowCustomTabs()
    {
        return (bool) $this->scopeConfig->getValue(self::XML_PATH_ENABLED);
    }

    /** @return bool */
    public function HideDefaultTabsEnabled()
    {
        if (!$this->ShowCustomTabs()) {
            return false;
        }
        return (bool) $this->scopeConfig->getValue(self::HIDE_DEFAULT_TAB_ENABLE);
    }
}
