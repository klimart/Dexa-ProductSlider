<?php

namespace Dexa\ProductSlider\Api\Data;

/**
 * Interface SortParamsInterface
 * @package Dexa\ProductSlider\Api\Data
 */
interface SortParamsInterface
{
    /**
     * Return array sort_field-sort_direction
     *
     * @param int $sorter
     * @return array Format: array('sort_field', 'sort_direction')
     */
    public function getSortParams($sorter);
}
