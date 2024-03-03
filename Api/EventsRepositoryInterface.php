<?php

declare(strict_types=1);

namespace Dvdam\Events\Api;

use Dvdam\Events\Api\Data\EventsInterface;

interface EventsRepositoryInterface
{
    /**
     * @param EventsInterface $event
     * @return void
     */
    public function save(EventsInterface $event): void;

    /**
     * @param EventsInterface $event
     * @return void
     */
    public function delete(EventsInterface $event): void;

    /**
     * @param int $eventId
     * @return EventsInterface
     */
    public function getById(int $eventId): EventsInterface;
}
