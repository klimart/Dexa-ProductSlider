<?php

namespace Dexa\ProductSlider\Ui\Component\Listing;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentInterface;

class Columns extends \Magento\Ui\Component\Listing\Columns
{
    /** @var int */
    protected $columnSortOrder;

    /** @var InlineEditUpdater */
    protected $inlineEditUpdater;

    /**
     * @var array
     */
    protected $filterMap = [
        'default' => 'text',
        'select' => 'select',
        'boolean' => 'select',
        'multiselect' => 'select',
        'date' => 'dateRange',
    ];

    public function __construct(
        ContextInterface $context,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $components, $data);
    }

    /**
     * @return int
     */
    protected function getDefaultSortOrder()
    {
//        $max = 0;
//        foreach ($this->components as $component) {
//            $config = $component->getData('config');
//            if (isset($config['sortOrder']) && $config['sortOrder'] > $max) {
//                $max = $config['sortOrder'];
//            }
//        }
//        return ++$max;
    }

    /**
     * Update actions column sort order
     *
     * @return void
     */
    protected function updateActionColumnSortOrder()
    {
        if (isset($this->components['actions'])) {
            $component = $this->components['actions'];
            $component->setData(
                'config',
                array_merge($component->getData('config'), ['sortOrder' => ++$this->columnSortOrder])
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepare()
    {
//        $this->columnSortOrder = $this->getDefaultSortOrder();
//
        $this->updateActionColumnSortOrder();
        parent::prepare();
    }

    /**
     * @param array $attributeData
     * @param string $columnName
     * @return void
     */
    public function addColumn(array $attributeData, $columnName)
    {
    }

    /**
     * @param array $attributeData
     * @param string $newAttributeCode
     * @return void
     */
    public function updateColumn(array $attributeData, $newAttributeCode)
    {
    }

    /**
     * Add options to component
     *
     * @param UiComponentInterface $component
     * @param array $attributeData
     * @return void
     */
    public function addOptions(UiComponentInterface $component, array $attributeData)
    {
    }

    /**
     * Retrieve filter type by $frontendInput
     *
     * @param string $frontendInput
     * @return string
     */
    protected function getFilterType($frontendInput)
    {
        return isset($this->filterMap[$frontendInput]) ? $this->filterMap[$frontendInput] : $this->filterMap['default'];
    }
}
