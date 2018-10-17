<?php

namespace Dexa\ProductSlider\Api;

/**
 * Interface ProductSliderRepository
 * @package Dexa\ProductSlider\Api
 */
interface ProductSliderRepositoryInterface
{
    /**
     * Get product list by slider id
     *
     * @param $id
     * @return array
     */
    public function getProductsBySliderId($id);

    /**
     * Get slider by id.
     *
     * @param string $id
     * @return \Dexa\ProductSlider\Api\Data\ProductSliderInterface
     */
    public function getSliderById($id);

    /**
     * @param \Dexa\ProductSlider\Api\Data\ProductSliderInterface $slider
     * @return mixed
     */
    public function save($slider);

    /**
     * @param integer $id
     * @return self
     */
    public function deleteById($id);
}
