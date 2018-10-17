<?php

namespace Dexa\ProductSlider\Controller\Adminhtml\Index;

use Dexa\ProductSlider\Api\ProductSliderRepositoryInterface;
use Dexa\ProductSlider\Model\ResourceModel\ProductSlider\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Class MassDelete
 */
class MassDelete extends AbstractMassAction
{
    /**
     * @var ProductSliderRepositoryInterface
     */
    protected $sliderRepository;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ProductSliderRepositoryInterface $sliderRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ProductSliderRepositoryInterface $sliderRepository
    ) {
        parent::__construct($context, $filter, $collectionFactory);
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * @param AbstractCollection $collection
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        $slidersDeleted = 0;
        foreach ($collection->getAllIds() as $sliderId) {
            $this->sliderRepository->deleteById($sliderId);
            $slidersDeleted++;
        }

        if ($slidersDeleted) {
            $this->messageManager->addSuccess(__('A total of %1 record(s) were deleted.', $slidersDeleted));
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->getComponentRefererUrl());

        return $resultRedirect;
    }
}
