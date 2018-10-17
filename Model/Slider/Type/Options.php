<?php

namespace Dexa\ProductSlider\Model\Slider\Type;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;

class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @return array|null
     */
    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('Category'),
                'value' => ProductSliderInterface::SLIDER_TYPE_CATEGORY
            ],
            [
                'label' => __('Products'),
                'value' => ProductSliderInterface::SLIDER_TYPE_PRODUCTS
            ],
        ];

        return $options;
    }
}
