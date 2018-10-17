<?php

namespace Dexa\ProductSlider\Block\Adminhtml\Edit;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context, $registry);
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $deleteUrl = $this->getDeleteUrl();
        if (!$deleteUrl) {
            return null;
        }

        $data = [
            'label' => __('Delete Slider'),
            'class' => 'delete',
            'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . $this->getDeleteUrl() . '\')',
            'sort_order' => 20,
        ];

        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        $sliderId = $this->getSliderId();
        return $sliderId
            ? $this->getUrl('*/index/delete', [ProductSliderInterface::SLIDER_INDEX_FIELD => $sliderId])
            : null;
    }
}
