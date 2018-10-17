<?php

namespace Dexa\ProductSlider\Model\Slider;

/**
 * Class DataProvider
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $collection
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        $collection,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $collection;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $slider) {
            $result['slider'] = $slider->getData();

            $this->loadedData[$slider->getId()] = $result;
        }

//        $data = $this->getSession()->getCustomerFormData();
//        if (!empty($data)) {
//            $customerId = isset($data['customer']['entity_id']) ? $data['customer']['entity_id'] : null;
//            $this->loadedData[$customerId] = $data;
//            $this->getSession()->unsCustomerFormData();
//        }

        return $this->loadedData;
    }
}
