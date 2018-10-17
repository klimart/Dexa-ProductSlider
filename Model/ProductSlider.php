<?php

namespace Dexa\ProductSlider\Model;

use Magento\Framework\Model\AbstractModel;
use Dexa\ProductSlider\Api\Data\ProductSliderInterface;

/**
 * Class ProductSlider Model.
 *
 * @package Dexa\ProductSlider\Model
 */
class ProductSlider extends AbstractModel implements ProductSliderInterface
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dexa\ProductSlider\Model\ResourceModel\ProductSlider');
    }

    /**
     * Get Categories
     * @return string
     */
    public function getCategoryIds()
    {
        return $this->getData('category_ids');
    }

    /**
     * Get slider type
     * @return integer
     */
    public function getType()
    {
        return $this->getData('type');
    }

    /**
     * Check if current slider is category slider
     * @return bool
     */
    public function isCategorySlider()
    {
        return $this->getType() == self::SLIDER_TYPE_CATEGORY;
    }

    /**
     * In case of multiple categories are used in slider,
     * retrieves the first category id.
     * @return int|null
     */
    public function getFirstCategoryId()
    {
        $categoryIds = $this->getCategoryIds();
        $categoriesArr = explode(self::CATEGORIES_DELIMITER, $categoryIds);

        $categoryId = array_shift($categoriesArr);

        return $categoryId ?: null;
    }

    /**
     * @return mixed
     */
    public function getSliderId()
    {
        return $this->getData('slider_id');
    }

    /**
     * Get parameter name
     */
    public function getName()
    {
        $this->getData('name');
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->setData('name', $name);
        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->setData('type', $type);
        return $this;
    }

    /**
     * @param $ids
     * @return $this
     */
    public function setCategoryIds($ids)
    {
        $this->setData('category_ids', $ids);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductIds()
    {
        return $this->getData('product_ids');
    }

    /**
     * @param $ids
     * @return $this
     */
    public function setProductIds($ids)
    {
        $this->setData('product_ids', $ids);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->getData('sort');
    }

    /**
     * @param $direction
     * @return $this
     */
    public function setSort($direction)
    {
        $this->setData('sort', $direction);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartNum()
    {
        return $this->getData('start_num');
    }

    /**
     * @param $num
     * @return $this
     */
    public function setStartNum($num)
    {
        $this->setData('start_num', $num);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMax()
    {
        return $this->getData('max');
    }

    /**
     * @param $max
     * @return $this
     */
    public function setMax($max)
    {
        $this->setData('max', $max);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUseAjax()
    {
        return $this->getData('use_ajax');
    }

    /**
     * @param $useAjax
     * @return $this
     */
    public function setUseAjax($useAjax)
    {
        $this->setData('use_ajax', $useAjax);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->getData('status');
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->setData('status', $status);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreationTime()
    {
        return $this->getData('creation_time');
    }

    /**
     * @param $time
     * @return $this
     */
    public function setCreationTime($time)
    {
        $this->setData('creation_time', $time);
        return $this;
    }
}
