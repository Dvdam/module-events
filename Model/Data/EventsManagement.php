<?php

declare(strict_types=1);

namespace Dvdam\Events\Model\Data;

use Dvdam\Events\Api\Data\EventsInterface;
use Dvdam\Events\Api\EventsManagementInterface;
use Dvdam\Events\Model\ResourceModel\Events\Collection;
use Dvdam\Events\Model\ResourceModel\Events\CollectionFactory;

/**
 * Class EventsManagement
 */
class EventsManagement implements EventsManagementInterface
{
    /**
     * EventsManagement constructor
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        private readonly CollectionFactory $collectionFactory
    ) {}

    /**
     * @return Collection
     */
    public function getEvents(): Collection
    {
        return $this->getCollection();
    }

    /**
     * @inheritDoc
     */
    public function getApplicableEvent(): EventsInterface
    {
        /** @var EventsInterface $event */
        $event = $this->getCollection()
            ->addFieldToFilter(EventsInterface::EVENT_ACTIVE, EventsInterface::STATUS_ENABLED)
            ->addOrder(EventsInterface::EVENT_ID)
            ->getFirstItem();
        ;

        return  $event;
    }

    /**
     * @inheritDoc
     */
    public function getLastEventCreate($title): EventsInterface
    {
        /** @var EventsInterface $event */
        $event = $this->getCollection()
            ->addFieldToFilter(EventsInterface::EVENT_TITLE, $title)
            ->getFirstItem();
        ;

        return  $event;
    }

    /**
     * @return Collection
     */
    private function getCollection(): Collection
    {
        return $this->collectionFactory->create();
    }
}

