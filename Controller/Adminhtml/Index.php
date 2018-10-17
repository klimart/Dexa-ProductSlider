<?php

namespace Dexa\ProductSlider\Controller\Adminhtml;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Dexa\ProductSlider\Api\Data\ProductSliderInterfaceFactory;
use Dexa\ProductSlider\Api\ProductSliderRepositoryInterface;
use Dexa\ProductSlider\Model\Slider\Mapper;
use Magento\Framework\Message\Error;
use Magento\Framework\DataObjectFactory as ObjectFactory;
use Magento\Framework\Api\DataObjectHelper;

/**
 * Class Index
 * @package Dexa\ProductSlider\Controller\Adminhtml
 */
abstract class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Dexa_ProductSlider::edit';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;

    /**
     * @var ObjectFactory
     */
    protected $objectFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

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
     * @var Mapper
     */
    protected $sliderMapper;

    /**
     * Index controller constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param DataObjectHelper $dataObjectHelper
     * @param ObjectFactory $objectFactory
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param ProductSliderRepositoryInterface $productSliderRepository
     * @param ProductSliderInterface $productSliderInterface
     * @param ProductSliderInterfaceFactory $productSliderInterfaceFactory
     * @param Mapper $sliderMapper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        DataObjectHelper $dataObjectHelper,
        ObjectFactory $objectFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        ProductSliderRepositoryInterface $productSliderRepository,
        ProductSliderInterface $productSliderInterface,
        ProductSliderInterfaceFactory $productSliderInterfaceFactory,
        Mapper $sliderMapper
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->fileFactory = $fileFactory;
        $this->objectFactory = $objectFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productSliderRepository = $productSliderRepository;
        $this->productSliderInterface = $productSliderInterface;
        $this->productSliderInterfaceFactory = $productSliderInterfaceFactory;
        $this->sliderMapper = $sliderMapper;
        parent::__construct($context);
    }

    /**
     * Customer initialization
     *
     * @return string customer id
     */
    protected function initCurrentSlider()
    {
        $sliderId = (int)$this->getRequest()->getParam('slider_id');

        if ($sliderId) {
            $this->coreRegistry->register('slider_id', $sliderId);
        }

        return $sliderId;
    }

    /**
     * Add errors messages to session.
     *
     * @param array|string $messages
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function addSessionErrorMessages($messages)
    {
        $messages = (array)$messages;
        $session = $this->_getSession();

        $callback = function ($error) use ($session) {
            if (!$error instanceof Error) {
                $error = new Error($error);
            }
            $this->messageManager->addMessage($error);
        };
        array_walk_recursive($messages, $callback);
    }
}
