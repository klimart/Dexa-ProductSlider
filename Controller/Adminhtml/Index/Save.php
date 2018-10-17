<?php

namespace Dexa\ProductSlider\Controller\Adminhtml\Index;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Dexa\ProductSlider\Controller\RegistryConstants;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 * Action Save slider by accepted form data (new & edited).
 *
 * @package Dexa\ProductSlider\Controller\Adminhtml\Index
 */
class Save extends \Dexa\ProductSlider\Controller\Adminhtml\Index
{
    /**
     * Retrieve current slider ID
     *
     * @return int
     */
    protected function getCurrentSliderId()
    {
        $originalRequestData = $this->getRequest()->getPostValue('slider');

        $sliderId = isset($originalRequestData['slider_id'])
            ? $originalRequestData['slider_id']
            : null;

        return $sliderId;
    }

    /**
     * @return array
     */
    protected function extractSliderData()
    {
        $slider = [];

        $sliderData = $this->getRequest()->getPost('slider');
        if (empty($sliderData)) {
            return $slider;
        }

        $slider['slider_id'] = !empty($sliderData['slider_id']) ? $sliderData['slider_id'] : null;
        $slider['creation_time'] = !empty($sliderData['creation_time']) ? $sliderData['creation_time'] : null;
        $slider['name'] = !empty($sliderData['name']) ? $sliderData['name'] : null;
        $slider['type'] = !empty($sliderData['type']) ? $sliderData['type'] : null;
        $slider['category_ids'] = !empty($sliderData['category_ids']) ? $sliderData['category_ids'] : null;
        $slider['product_ids'] = !empty($sliderData['product_ids']) ? $sliderData['product_ids'] : null;
        $slider['sort'] = !empty($sliderData['sort']) ? $sliderData['sort'] : null;
        $slider['start_num'] = !empty($sliderData['start_num']) ? $sliderData['start_num'] : null;
        $slider['max'] = !empty($sliderData['max']) ? $sliderData['max'] : null;
        $slider['use_ajax'] = isset($sliderData['use_ajax']) ? $sliderData['use_ajax'] : 0;
        $slider['status'] = isset($sliderData['status']) ? $sliderData['status'] : 0;

        return $slider;
    }

    /**
     * Save customer action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $returnToEdit = false;
        $originalRequestData = $this->getRequest()->getPostValue();

        $sliderId = $this->getCurrentSliderId();

        if ($originalRequestData) {
            try {
                $sliderData = $this->extractSliderData();

                if ($sliderId) {
                    $slider = $this->productSliderRepository->getSliderById($sliderId);
                    $sliderData = array_merge(
                        $this->sliderMapper->toFlatArray($slider),
                        $sliderData
                    );
                } else {
                    /** @var productSliderInterface $slider */
                    $slider = $this->productSliderInterfaceFactory->create();
                }

                $this->dataObjectHelper->populateWithArray(
                    $slider,
                    $sliderData,
                    ProductSliderInterface::class
                );

                $this->_eventManager->dispatch(
                    'adminhtml_product_slider_prepare_save',
                    ['product_slider' => $slider, 'request' => $this->getRequest()]
                );

                // Save slider
                $this->productSliderRepository->save($slider);
                if (!$sliderId) {
                    $sliderId = $slider->getSliderId();
                }

                // After save
                $this->_eventManager->dispatch(
                    'adminhtml_product_slider_save_after',
                    ['product_slider' => $slider, 'request' => $this->getRequest()]
                );

                // Done Saving slider, finish save action
                $this->coreRegistry->register(RegistryConstants::CURRENT_SLIDER_ID, $sliderId);
                $this->messageManager->addSuccess(__('You saved the slider.'));
                $returnToEdit = (bool)$this->getRequest()->getParam('back', false);
            } catch (\Magento\Framework\Validator\Exception $exception) {
                $messages = $exception->getMessages();
                if (empty($messages)) {
                    $messages = $exception->getMessage();
                }
                $this->_addSessionErrorMessages($messages);
                $this->_getSession()->setSliderFormData($originalRequestData);
                $returnToEdit = true;
            } catch (LocalizedException $exception) {
                $this->_addSessionErrorMessages($exception->getMessage());
                $this->_getSession()->setSliderFormData($originalRequestData);
                $returnToEdit = true;
            } catch (\Exception $exception) {
                $this->messageManager->addException($exception, __('Something went wrong while saving the slider.'));
                $this->_getSession()->setSliderFormData($originalRequestData);
                $returnToEdit = true;
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($returnToEdit) {
            if ($sliderId) {
                $resultRedirect->setPath(
                    '*/slider/edit',
                    ['slider_id' => $sliderId, '_current' => true]
                );
            } else {
                $resultRedirect->setPath(
                    '*/slider/index'
                );
            }
        } else {
            $resultRedirect->setPath('*/slider/index');
        }

        return $resultRedirect;
    }
}
