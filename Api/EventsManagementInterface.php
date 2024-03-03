<?php

declare(strict_types=1);

namespace Dvdam\Events\Api;

use Dvdam\Events\Api\Data\EventsInterface;
use Dvdam\Events\Model\ResourceModel\Events\Collection;

interface EventsManagementInterface
{
    /**
     * @return Collection
     */
    public function getEvents(): Collection;

    /**
     * @return EventsInterface
     */
    public function getApplicableEvent(): EventsInterface;

    /**
     * @param string $title
     * @return EventsInterface
     */
    public function getLastEventCreate(string $title): EventsInterface;
}
