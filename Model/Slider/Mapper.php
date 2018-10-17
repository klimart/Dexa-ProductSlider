<?php

namespace Dexa\ProductSlider\Model\Slider;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Convert\ConvertArray;

class Mapper
{
    /**
     * @var \Magento\Framework\Api\ExtensibleDataObjectConverter
     */
    private $extensibleDataObjectConverter;

    /**
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(ExtensibleDataObjectConverter $extensibleDataObjectConverter)
    {
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * Convert address data object to a flat array
     *
     * @param ProductSliderInterface $slider
     * @return array
     */
    public function toFlatArray(ProductSliderInterface $slider)
    {
        $flatArray = $this->extensibleDataObjectConverter->toNestedArray($slider, [], ProductSliderInterface::class);
        return ConvertArray::toFlatArray($flatArray);
    }
}
