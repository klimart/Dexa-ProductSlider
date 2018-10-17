<?php

namespace Dexa\ProductSlider\Controller\Adminhtml\Slider;

use Dexa\ProductSlider\Controller\Adminhtml\Slider as AbstractSlider;

/**
 * Class Index
 * Controller action displays product sliders grid.
 *
 * @package Dexa\ProductSlider\Controller\Adminhtml\Slider
 */
class Index extends AbstractSlider
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Dexa_ProductSlider::content';

    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('Dexa_ProductSlider::dexa_productslider');
        $resultPage->getConfig()->getTitle()->prepend(__('Dexa Product Slider'));

        /**
         * Add breadcrumb item
         */
        $resultPage->addBreadcrumb(__('Product Slider'), __('Product Slider'));

        return $resultPage;
    }
}
