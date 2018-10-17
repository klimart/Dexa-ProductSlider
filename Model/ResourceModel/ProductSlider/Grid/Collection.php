<?php

namespace Dexa\ProductSlider\Model\ResourceModel\ProductSlider\Grid;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Magento\Framework\Api;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Psr\Log\LoggerInterface as Logger;

/**
 * Class Collection
 * @package Dexa\ProductSlider\Model\ResourceModel\ProductSlider\Grid
 */
class Collection extends SearchResult
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable,
        $resourceModel,
        DateTime $date
    ) {
        $this->date = $date;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }
}
