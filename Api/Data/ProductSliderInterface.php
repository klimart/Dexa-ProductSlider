<?php

namespace Dexa\ProductSlider\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Interface ProductSliderInterface
 * @package Dexa\ProductSlider\Api\Data
 */
interface ProductSliderInterface extends ExtensibleDataInterface
{
    const SLIDER_TYPE_CATEGORY        = 1;
    const SLIDER_TYPE_PRODUCTS        = 2;
    /** Both categories and specified products */
    const SLIDER_TYPE_MIXED           = 3;
    const SLIDER_TYPE_CATEGORY_LATEST = 4;
    const SLIDER_TYPE_ALL_LATEST      = 5;
    const SLIDER_TYPE_LAST_VIEWED     = 6;


    const SORT_NO_SORT                = 0;
    const SORT_PRICE_ASC              = 1;
    const SORT_PRICE_DESC             = 2;
    const SORT_NAME_ASC               = 3;
    const SORT_NAME_DESC              = 4;
    const SORT_ID_DESC                = 5;

    const SORT_DIR_ASC                = 'ASC';
    const SORT_DIR_DESC               = 'DESC';

    const CATEGORIES_DELIMITER        = ',';
    const PRODUCTS_DELIMITER          = ',';

    const SLIDER_INDEX_FIELD          = 'slider_id';

    /**
     * @return mixed
     */
    public function getSliderId();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param $name
     * @return mixed
     */
    public function setName($name);

    /**
     * Get slider type
     * @return integer
     */
    public function getType();

    /**
     * @param $type
     * @return mixed
     */
    public function setType($type);

    /**
     * Get Categories
     * @return string
     */
    public function getCategoryIds();

    /**
     * @param $ids
     * @return mixed
     */
    public function setCategoryIds($ids);

    /**
     * Get Products
     * @return string
     */
    public function getProductIds();

    /**
     * @param $ids
     * @return mixed
     */
    public function setProductIds($ids);

    /**
     * @return mixed
     */
    public function getSort();

    /**
     * @param $direction
     * @return mixed
     */
    public function setSort($direction);

    /**
     * @return mixed
     */
    public function getStartNum();

    /**
     * @param $num
     * @return mixed
     */
    public function setStartNum($num);

    /**
     * @return mixed
     */
    public function getMax();

    /**
     * @param $max
     * @return mixed
     */
    public function setMax($max);

    /**
     * @return mixed
     */
    public function getUseAjax();

    /**
     * @param $useAjax
     * @return mixed
     */
    public function setUseAjax($useAjax);

    /**
     * @return mixed
     */
    public function getStatus();

    /**
     * @param $status
     * @return mixed
     */
    public function setStatus($status);

    /**
     * @return mixed
     */
    public function getCreationTime();

    /**
     * @param $time
     * @return mixed
     */
    public function setCreationTime($time);

    /**
     * In case of multiple categories are used in slider,
     * retrieves the first category id.
     * @return int|null
     */
    public function getFirstCategoryId();

    /**
     * Check if current slider is category slider
     * @return bool
     */
    public function isCategorySlider();
}
