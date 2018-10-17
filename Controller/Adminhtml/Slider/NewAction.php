<?php

namespace Dexa\ProductSlider\Controller\Adminhtml\Slider;

use Dexa\ProductSlider\Controller\Adminhtml\Slider as AbstractSlider;

/**
 * Class NewAction
 * Create new product slider form controller action.
 *
 * @package Dexa\ProductSlider\Controller\Adminhtml\Slider
 */
class NewAction extends AbstractSlider
{
    /**
     * Edit or create slider.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $sliderId = $this->initSlider();

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dexa_ProductSlider::dexa_productslider');
        $resultPage->getConfig()->getTitle()->prepend(__('Product Slider'));
        $resultPage->addBreadcrumb(__('Sliders'), __('Sliders'));
        $resultPage->addBreadcrumb(
            __('Sliders Grid'),
            __('Sliders Grid'),
            $this->getUrl('dexa_productslider/slider/index')
        );

        if ($sliderId === null) {
            $resultPage->addBreadcrumb(__('New Slider'), __('New Slider'));
            $resultPage->getConfig()->getTitle()->prepend(__('New Product Slider'));
        } else {
            $resultPage->addBreadcrumb(__('Edit Slider'), __('Edit Product Slider'));
            $resultPage->getConfig()->getTitle()->prepend(
                $this->productSliderRepository->getSliderById($sliderId)->getSliderId()
            );
        }

        return $resultPage;
    }
}
