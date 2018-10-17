<?php

namespace Dexa\ProductSlider\Controller\Adminhtml\Index;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends \Dexa\ProductSlider\Controller\Adminhtml\Index
{
    /**
     * Delete slider action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(ProductSliderInterface::SLIDER_INDEX_FIELD);
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->productSliderRepository->deleteById($id);
                $this->messageManager->addSuccess(__('You deleted the product slider.'));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError(__('The product slider no longer exists.'));
                return $resultRedirect->setPath('dexa_productslider/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('dexa_productslider/slider/edit', ['id' => $id]);
            }
        }
        return $resultRedirect->setPath('dexa_productslider/slider');
    }
}
