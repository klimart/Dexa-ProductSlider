<?php

namespace Dexa\ProductSlider\Controller\Adminhtml;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Dexa\ProductSlider\Api\Data\ProductSliderInterfaceFactory;
use Dexa\ProductSlider\Api\ProductSliderRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

/**
 * Abstract parent controller for Slider/* actions
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class Slider extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Dexa_ProductSlider::edit';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var ProductSliderRepositoryInterface
     */
    protected $productSliderRepository;

    /**
     * @var ProductSliderInterface
     */
    protected $productSliderInterface;

    /**
     * @var ProductSliderInterfaceFactory
     */
    protected $productSliderInterfaceFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Slider constructor.
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param ProductSliderRepositoryInterface $productSliderRepository
     * @param ProductSliderInterface $productSliderInterface
     * @param ProductSliderInterfaceFactory $productSliderInterfaceFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        ProductSliderRepositoryInterface $productSliderRepository,
        ProductSliderInterface $productSliderInterface,
        ProductSliderInterfaceFactory $productSliderInterfaceFactory
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->productSliderRepository = $productSliderRepository;
        $this->productSliderInterface = $productSliderInterface;
        $this->productSliderInterfaceFactory = $productSliderInterfaceFactory;
        parent::__construct($context);
    }

    /**
     * Register current slider id.
     *
     * @return mixed
     */
    protected function initSlider()
    {
        $sliderId = $this->getRequest()->getParam(ProductSliderInterface::SLIDER_INDEX_FIELD);

        if ($sliderId && !$this->coreRegistry->registry(ProductSliderInterface::SLIDER_INDEX_FIELD)) {
            $this->coreRegistry->register(ProductSliderInterface::SLIDER_INDEX_FIELD, $sliderId);
        }

        return $sliderId;
    }
}
