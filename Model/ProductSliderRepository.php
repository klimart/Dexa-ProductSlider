<?php

namespace Dexa\ProductSlider\Model;

use Dexa\ProductSlider\Api\ProductSliderRepositoryInterface;
use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Dexa\ProductSlider\Api\Data\ProductSliderInterfaceFactory;
use Dexa\ProductSlider\Model\ResourceModel\ProductSlider as ProductSliderResource;
use Dexa\ProductSlider\Model\ResourceModel\ProductSlider\CollectionFactory as ProductSliderCollectionFactory;
use Dexa\ProductSlider\Model\Slider\Sorting\Options as SortingOptions;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;

/**
 * Class ProductSliderRepository
 * @package Dexa\ProductSlider\Model
 */
class ProductSliderRepository implements ProductSliderRepositoryInterface
{
    /**
     * @var ProductSliderInterfaceFactory
     */
    protected $productSliderFactory;

    /**
     * @var ProductSliderResource
     */
    protected $sliderResource;

    /**
     * @var Product\CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var ProductSliderCollectionFactory
     */
    protected $productSliderCollectionFactory;

    /**
     * @var SortingOptions
     */
    protected $sortingOptions;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var \Magento\Framework\Api\Search\FilterGroupBuilder
     */
    protected $filterGroupBuilder;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $productStatus;

    /**
     * ProductSliderRepository constructor.
     *
     * @param ProductSliderInterfaceFactory $productSliderInterfaceFactory
     * @param ProductSliderResource $sliderResource
     * @param ProductSliderCollectionFactory $productSliderCollectionFactory
     * @param ProductCollectionFactory $productCollectionFactory
     * @param CategoryFactory $categoryFactory
     * @param ProductRepositoryInterface $productRepositoryInterface
     * @param SortingOptions $sortingOptions
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param Status $productStatus
     * @param array $data
     */
    public function __construct(
        ProductSliderInterfaceFactory $productSliderInterfaceFactory,
        ProductSliderResource $sliderResource,
        ProductSliderCollectionFactory $productSliderCollectionFactory,
        ProductCollectionFactory $productCollectionFactory,
        CategoryFactory $categoryFactory,
        ProductRepositoryInterface $productRepositoryInterface,
        SortingOptions $sortingOptions,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        FilterBuilder $filterBuilder,
        SortOrderBuilder $sortOrderBuilder,
        Status $productStatus,
        array $data = []
    ) {
        $this->productSliderFactory = $productSliderInterfaceFactory;
        $this->productSliderCollectionFactory = $productSliderCollectionFactory;
        $this->sliderResource = $sliderResource;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryFactory = $categoryFactory;
        $this->productRepository = $productRepositoryInterface;
        $this->sortingOptions = $sortingOptions;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->productStatus = $productStatus;
    }

    /**
     * Retrieve product slider collection by slider id
     * @param $id
     * @return array|\Magento\Framework\DataObject[]
     */
    public function getProductsBySliderId($id)
    {
        /* @var \Magento\Framework\Model\AbstractModel */
        $productSlider = $this->getSliderById($id);
        $productCollection = $this->productCollectionFactory->create();

        if (!$productSlider->getId()) {
            return array();
        }

        $startProductsNum = $productSlider->getStartNum();
        $maxProductsNum = $productSlider->getMax();
        $sort = $productSlider->getSort();

        switch ($productSlider->getType()) {
            case ProductSliderInterface::SLIDER_TYPE_CATEGORY:
                $categoryIds = explode(',', $productSlider->getCategoryIds());

                $loadLimit = ($maxProductsNum && ($maxProductsNum < $startProductsNum))
                    ? $maxProductsNum : $startProductsNum;
                list($sortField, $sortDir) = $this->sortingOptions->getSortParams($sort);
                $products = $this->getCategoriesProducts($categoryIds, $loadLimit, $sortField, $sortDir);
                break;
            case ProductSliderInterface::SLIDER_TYPE_PRODUCTS:
                $productIds = explode(',', $productSlider->getProductIds());

                $productCollection
                    ->addAttributeToSelect('name')
                    ->addAttributeToSelect('image')
                    ->addAttributeToSelect('small_image')
                    ->addFieldToFilter('entity_id', ['in' => $productIds]);

                $products = $productCollection->getItems();
                break;
            case ProductSliderInterface::SLIDER_TYPE_MIXED:
            case ProductSliderInterface::SLIDER_TYPE_CATEGORY_LATEST:
            case ProductSliderInterface::SLIDER_TYPE_ALL_LATEST:
            default:
                $products = [];
        }

        return $products;
    }

    /**
     * @inheritdoc
     */
    public function getSliderById($id)
    {
        $sliderCollection = $this->productSliderCollectionFactory->create();
        return $sliderCollection
            ->addFieldToFilter('slider_id', ['eq' => $id])
            ->getFirstItem();
    }

    /**
     * @param ProductSliderInterface $slider
     * @return $this
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save($slider)
    {
        return $this->sliderResource->save($slider);
    }

    /**
     * @param int $id
     * @return $this
     * @throws \Exception
     */
    public function deleteById($id)
    {
        $sliderCollection = $this->productSliderCollectionFactory->create();
        /** @var ProductSliderInterface $slider */
        $slider = $sliderCollection
            ->addFilter(ProductSliderInterface::SLIDER_INDEX_FIELD, $id)
            ->load()
            ->getFirstItem();
        $this->sliderResource->delete($slider);

        return $this;
    }

    /**
     * Retrieve products for slider by category id using direct collection approach
     *
     * @param $categoryId
     * @param $limit
     * @param $sortField
     * @param string $sortDir
     * @return \Magento\Framework\DataObject[]
     */
    protected function getCategoryProducts($categoryId, $limit, $sortField, $sortDir = 'DESC')
    {
        $productCollection = $this->productCollectionFactory->create();
        $category = $this->categoryFactory->create();

        $category->getResource()->load($category, $categoryId);
        $productCollection->addCategoryFilter($category);

        $productCollection
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('image')
            ->addAttributeToSelect('small_image')
            ->addWebsiteNamesToResult()
            ->addFinalPrice()
            ->applyFrontendPriceLimitations();

        return $productCollection->getItems();
    }

    /**
     * Retrieve products assigned directly to particular category.
     *
     * @param array $categories
     * @param $limit
     * @param $sortField
     * @param string $sortDir
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    protected function getCategoriesProducts(array $categories, $limit, $sortField, $sortDir = 'DESC')
    {
        $searchCriteriaBuilder = $this->searchCriteriaBuilder;

        $visibilityFilter = $this->filterBuilder
            ->setField(ProductInterface::VISIBILITY)
            ->setConditionType('neq')
            ->setValue(Visibility::VISIBILITY_NOT_VISIBLE)
            ->create();

        $visibilityGroup = $this->filterGroupBuilder
            ->addFilter($visibilityFilter)
            ->create();

        $statusFilter = $this->filterBuilder
            ->setField(ProductInterface::STATUS)
            ->setConditionType('in')
            ->setValue($this->productStatus->getVisibleStatusIds())
            ->create();

        $statusGroup = $this->filterGroupBuilder
            ->addFilter($statusFilter)
            ->create();

        $categoryFilter = $this->filterBuilder
            ->setField('category_id')
            ->setConditionType('in')
            ->setValue($categories)
            ->create();

        $categoryGroup = $this->filterGroupBuilder
            ->addFilter($categoryFilter)
            ->create();

        $sortOrder = $this->sortOrderBuilder
            ->setField('price')
            ->setDirection(SortOrder::SORT_ASC)
            ->create();

        $searchCriteriaBuilder
            ->setFilterGroups([$visibilityGroup, $statusGroup, $categoryGroup])
            ->addSortOrder($sortOrder);

        /** @var SortOrder $sortOrder */
        if ($sortField) {
            $sortDir = $sortDir ?: ProductSliderInterface::SORT_DIR_DESC;
            $sortOrder = $this->sortOrderBuilder->setField($sortField)->setDirection($sortDir)->create();
            $searchCriteriaBuilder->setSortOrders([$sortOrder]);
        }

        if ($limit) {
            $searchCriteriaBuilder->setPageSize($limit);
            $searchCriteriaBuilder->setCurrentPage(1);
        }
        $searchCriteria = $searchCriteriaBuilder->create();

        return $this->productRepository
            ->getList($searchCriteria)
            ->getItems();
    }
}
