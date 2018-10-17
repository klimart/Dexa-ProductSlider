<?php

namespace Dexa\ProductSlider\Block\Adminhtml\Edit;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

/**
 * Class GenericButton
 * Parent class for form buttons.
 *
 * @package Dexa\ProductSlider\Block\Adminhtml\Edit
 */
class GenericButton
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * GenericButton constructor.
     *
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
    }

    /**
     * Return the customer Id.
     *
     * @return int|null
     */
    public function getSliderId()
    {
        return $this->registry->registry(ProductSliderInterface::SLIDER_INDEX_FIELD);
    }

    /**
     * @param null $routePath
     * @param null $routeParams
     * @return string
     */
    public function getUrl($routePath = null, $routeParams = null)
    {
        return $this->urlBuilder->getUrl($routePath, $routeParams);
    }
}
