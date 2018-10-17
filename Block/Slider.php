<?php

namespace Dexa\ProductSlider\Block;

use Dexa\ProductSlider\Api\ProductSliderRepositoryInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Catalog\Block\Product\Context;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Helper\DefaultCategory;

/**
 * Class Slider
 * @package Dexa\ProductSlider\Block
 */
class Slider extends AbstractProduct
{
    protected $_template = 'slider.phtml';

    /**
     * @var ProductSliderRepositoryInterface
     */
    protected $productSliderRepo;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepo;

    /**
     * @var DefaultCategory
     */
    protected $defaultCategory;

    /**
     * @var \Dexa\ProductSlider\Api\Data\ProductSliderInterface
     */
    protected $productSlider;

    /**
     * @var int
     */
    protected $sliderId;

    /**
     * Slider constructor.
     * @param Context $context
     * @param ProductSliderRepositoryInterface $productSliderRepo
     * @param CategoryRepositoryInterface $categoryRepo
     * @param DefaultCategory $defaultCategory
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductSliderRepositoryInterface $productSliderRepo,
        CategoryRepositoryInterface $categoryRepo,
        DefaultCategory $defaultCategory,
        array $data = []
    ) {
        $this->productSliderRepo = $productSliderRepo;
        $this->categoryRepo = $categoryRepo;
        $this->defaultCategory = $defaultCategory;

        parent::__construct($context, $data);

        /** Retrieves sliderId from block/widget config in xml or db */
        $this->sliderId = $this->getSliderId();
        $this->productSlider = $this->productSliderRepo->getSliderById($this->sliderId);
    }

    /**
     * Retrieve product for current slider.
     * @return array
     */
    public function getProducts()
    {
        return $this->productSliderRepo->getProductsBySliderId($this->sliderId);
    }

    /**
     * @inheritdoc
     */
    public function isCategorySlider()
    {
        return $this->productSlider->isCategorySlider();
    }

    /**
     * Generate category bread crumbs html
     * @return string
     */
    public function getCategoryBreadCrumbs()
    {
        $crumbsHtml = '';
        $crumbsDelimiter = '<span class="slider-title-delimiter">&nbsp;&nbsp;&#10070;&nbsp;&nbsp;</span>';

        $categoryId = $this->productSlider->getFirstCategoryId();
        if (!$categoryId) {
            return '';
        }

        // Generate parent categories array
        $defaultCategoryId = $this->defaultCategory->getId();
        $categoriesArr = [];
        $currentCategoryId = $categoryId;
        while ($currentCategoryId) {
            /** @var \Magento\Catalog\Api\Data\CategoryInterface $category */
            $category = $this->categoryRepo->get($currentCategoryId);
            array_unshift($categoriesArr, $category);

            $parentCategoryId = $category->getParentId();

            $currentCategoryId = $parentCategoryId;
            if (!$parentCategoryId || $parentCategoryId == $defaultCategoryId) {
                $currentCategoryId = null;
            }
        }

        // Render categories array as bread crumbs
        while (count($categoriesArr)) {
            $currentCategory = array_shift($categoriesArr);
            $categoryLink = $currentCategory->getUrl();
            $categoryName = $currentCategory->getName();
            $crumbTemplate = "<a href=\"{$categoryLink}\" class=\"slider-title-category\">{$categoryName}</a>";
            $crumbsHtml .= $crumbTemplate;
            if (count($categoriesArr)) {
                $crumbsHtml .= $crumbsDelimiter;
            }
        }

        return $crumbsHtml;
    }
}
