<?php

namespace Dexa\ProductSlider\Controller\Adminhtml\Index;

use Dexa\ProductSlider\Api\Data\ProductSliderInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\DataObjectFactory as ObjectFactory;
use Magento\Framework\Message\Error;

class Validate extends \Dexa\ProductSlider\Controller\Adminhtml\Index
{
    protected function validateSlider($response)
    {
        $slider = null;
        $errors = [];

        try {
            $sliderData = $this->getRequest()->getParam('slider');
            if (empty($sliderData)) {
                $errors[] = __('Cannot retrieve slider data');
            }
            $sliderId = !empty($sliderData['slider_id']) ? $sliderData['slider_id'] : null;
            $createdAt = !empty($sliderData['creation_time']) ? $sliderData['creation_time'] : null;
            $name = !empty($sliderData['name']) ? $sliderData['name'] : null;
            $type = !empty($sliderData['type']) ? $sliderData['type'] : null;
            $categories = !empty($sliderData['category_ids']) ? $sliderData['category_ids'] : null;
            $products = !empty($sliderData['product_ids']) ? $sliderData['product_ids'] : null;
            $sort = !empty($sliderData['sort']) ? $sliderData['sort'] : null;
            $startNum = !empty($sliderData['start_num']) ? $sliderData['start_num'] : null;
            $max = !empty($sliderData['max']) ? $sliderData['max'] : null;
            $useAjax = !empty($sliderData['use_ajax']) ? $sliderData['use_ajax'] : null;
            $status = !empty($sliderData['status']) ? $sliderData['status'] : null;

            switch ($type) {
                case ProductSliderInterface::SLIDER_TYPE_CATEGORY:
                    if (empty($categories)) {
                        $errors[] = __('Category Ids field is mandatory for category type slider');
                    }

                    $categoryIds = explode(ProductSliderInterface::CATEGORIES_DELIMITER, $categories);
                    $foundIds = array_filter($categoryIds, function ($val) {
                        return ctype_digit($val);
                    });
                    if (!count($foundIds)) {
                        $errors[] = __('Category Ids should contain comma delimited numbers');
                    }
                    break;

                case ProductSliderInterface::SLIDER_TYPE_PRODUCTS:
                    if (empty($products)) {
                        $errors[] = __('Product Ids field is mandatory for product type slider');
                    }

                    $productIds = explode(ProductSliderInterface::CATEGORIES_DELIMITER, $products);
                    $foundIds = array_filter($productIds, function ($val) {
                        return ctype_digit($val);
                    });
                    if (!count($foundIds)) {
                        $errors[] = __('Products Ids should contain comma delimited numbers');
                    }
                    break;

                default:
                    $errors[] = __('Error slider type definition');
            }

        } catch (\Magento\Framework\Validator\Exception $exception) {
            /* @var $error Error */
            foreach ($exception->getMessages(\Magento\Framework\Message\MessageInterface::TYPE_ERROR) as $error) {
                $errors[] = $error->getText();
            }
        }

        if ($errors) {
            $messages = $response->hasMessages() ? $response->getMessages() : [];
            foreach ($errors as $error) {
                $messages[] = $error;
            }
            $response->setMessages($messages);
            $response->setError(1);
        }

        return $slider;
    }

    /**
     * AJAX slider validation action
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $response = new \Magento\Framework\DataObject();
        $response->setError(0);

        $slider = $this->validateSlider($response);

        $resultJson = $this->resultJsonFactory->create();
        if ($response->getError()) {
            $response->setError(true);
            $response->setMessages($response->getMessages());
        }

        $resultJson->setData($response);
        return $resultJson;
    }
}
