<?php

declare(strict_types=1);

namespace DeveloperHub\ProductCustomTabs\Ui;

use Magento\Framework\Data\OptionSourceInterface;

class OptionsProvider implements OptionSourceInterface
{
    /** @return array */
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->getOptions() as $value => $label) {
            $result[] = [
                'value' => $value,
                'label' => $label,
            ];
        }
        return $result;
    }

    /** @return array */
    public function getOptions()
    {
        return [
            '0' => __('Select Type'),
            '1' => __('All Products'),
            '2' => __('Attribute Set'),
            '3' => __('Specific Product'),
            '4'=>__('Select Categories'),
        ];
    }
}
