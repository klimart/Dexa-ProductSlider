<?php

namespace Dexa\ProductSlider\Model\Slider\Sorting;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Dexa\ProductSlider\Api\Data\SortParamsInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface, SortParamsInterface
{
    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('Not Applied'),
                'value' => ProductSliderInterface::SORT_NO_SORT
            ],
            [
                'label' => __('Price Ascending'),
                'value' => ProductSliderInterface::SORT_PRICE_ASC
            ],
            [
                'label' => __('Price Descending'),
                'value' => ProductSliderInterface::SORT_PRICE_DESC
            ],
            [
                'label' => __('Name Ascending'),
                'value' => ProductSliderInterface::SORT_NAME_ASC
            ],
            [
                'label' => __('Name Descending'),
                'value' => ProductSliderInterface::SORT_NAME_DESC
            ],
            [
                'label' => __('Newest Descending'),
                'value' => ProductSliderInterface::SORT_ID_DESC
            ],
        ];

        return $options;
    }

    /**
     * @inheritdoc
     */
    public function getSortParams($sorter)
    {
        $sortField = '';
        $sortDirection = 'DESC';

        switch (true) {
            case $sorter == ProductSliderInterface::SORT_NO_SORT:
                break;

            case $sorter == ProductSliderInterface::SORT_ID_DESC:
                $sortField = 'entity_id';
                break;

            case $sorter == ProductSliderInterface::SORT_NAME_ASC:
                $sortField = ProductInterface::NAME;
                $sortDirection = ProductSliderInterface::SORT_DIR_ASC;
                break;

            case $sorter == ProductSliderInterface::SORT_NAME_DESC:
                $sortField = ProductInterface::NAME;
                break;

            case $sorter == ProductSliderInterface::SORT_PRICE_ASC:
                $sortField = ProductInterface::PRICE;
                $sortDirection = ProductSliderInterface::SORT_DIR_ASC;
                break;

            case $sorter == ProductSliderInterface::SORT_PRICE_DESC:
                $sortField = ProductInterface::PRICE;
                break;
        }

        return [$sortField, $sortDirection];
    }
}
