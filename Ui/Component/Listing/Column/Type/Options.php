<?php

namespace Dexa\ProductSlider\Ui\Component\Listing\Column\Type;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Options
 */
class Options implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $this->options = [
                [
                    'label' => __('Category'),
                    'value' => ProductSliderInterface::SLIDER_TYPE_CATEGORY
                ],
                [
                    'label' => __('Products'),
                    'value' => ProductSliderInterface::SLIDER_TYPE_PRODUCTS
                ],
            ];
        }
        return $this->options;
    }
}
