<?php

namespace Dexa\ProductSlider\Controller\Adminhtml\Slider;

use Dexa\ProductSlider\Controller\Adminhtml\Slider as AbstractSlider;

/**
 * Class Edit
 * Edit controller action to display edit slider form.
 *
 * @package Dexa\ProductSlider\Controller\Adminhtml\Slider
 */
class Edit extends AbstractSlider
{
    /**
     * Edit slider controller action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->initSlider();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dexa_ProductSlider::dexa_productslider');

        $resultPage->getConfig()->getTitle()->prepend(__('Edit Slider Form'));

        return $resultPage;
    }
}
