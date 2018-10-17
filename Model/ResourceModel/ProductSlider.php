<?php

namespace Dexa\ProductSlider\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ProductSlider
 * @package Dexa\ProductSlider\Model\ResourceModel
 */
class ProductSlider extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dexa_productslider', 'slider_id');
    }
}
