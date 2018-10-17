<?php

namespace Dexa\ProductSlider\Model\ResourceModel\ProductSlider;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Dexa\ProductSlider\Model\ResourceModel\ProductSlider
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = ProductSliderInterface::SLIDER_INDEX_FIELD;

    protected function _construct()
    {
        $this->_init(
            'Dexa\ProductSlider\Model\ProductSlider',
            'Dexa\ProductSlider\Model\ResourceModel\ProductSlider'
        );
    }
}
