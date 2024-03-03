<?php

declare(strict_types=1);

namespace Dvdam\Events\Model\Data;

use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Dvdam\Events\Api\Data\EventsInterface;
use Dvdam\Events\Api\EventsRepositoryInterface;
use Dvdam\Events\Model\EventsFactory;
use Dvdam\Events\Model\ResourceModel\Events as EventsResource;

/**
 * Class EventsRepository
 */
class EventsRepository implements EventsRepositoryInterface
{
    /**
     * EventsRepository constructor
     *
     * @param EventsResource $resource
     * @param EventsFactory $factory
     */
    public function __construct(
        private readonly EventsResource $resource,
        private readonly EventsFactory $factory
    ) {

    }

    /**
     * @inheritDoc
     * @throws AlreadyExistsException
     */
    public function save(EventsInterface $event): void
    {
        $this->resource->save($event);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function delete(EventsInterface $event): void
    {
        $this->resource->delete($event);
    }

    /**
     * @inheritDoc
     * @throws NoSuchEntityException
     */
    public function getById(int $eventId): EventsInterface
    {
        $event = $this->factory->create();

        $this->resource->load($event, $eventId);

        if (!$event->getId()) {
            throw new NoSuchEntityException(
                __('The event with id %1 does not exit.', $eventId)
            );
        }

        return $event;
    }
}
