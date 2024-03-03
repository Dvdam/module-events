<?php

declare(strict_types=1);

namespace Dvdam\Events\Model;

use Magento\Framework\Model\AbstractModel;
use Dvdam\Events\Model\ResourceModel\Events as EventsResource;
use Dvdam\Events\Api\Data\EventsInterface;

/**
 * Class Events
 */
class Events extends AbstractModel implements EventsInterface
{
    /**
     * Events constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_eventPrefix = 'dvdam_events';
        $this->_eventObject = 'event';
        $this->_idFieldName = self::EVENT_ID;
        $this->_init(EventsResource::class);
    }

    public function getEventId(): int
    {
        return (int) $this->getData(self::EVENT_ID);
    }

    public function setEventId(int $eventId)
    {
        $this->setData(self::EVENT_ID, $eventId);
    }

    public function getTitle(): string
    {
        return (string) $this->getData(self::EVENT_TITLE);
    }

    public function setTitle(string $title)
    {
        $this->setData(self::EVENT_TITLE, $title);
    }

    public function getContent(): string
    {
        return (string) $this->getData(self::EVENT_CONTENT);
    }

    public function setContent(string $content)
    {
        $this->setData(self::EVENT_CONTENT, $content);
    }

    public function getLabelType(): string
    {
        return (string) $this->getData(self::EVENT_LABEL_TYPE);
    }

    public function setLabelType(string $type)
    {
        $this->setData(self::EVENT_LABEL_TYPE, $type);
    }

    public function getStartAt(): string
    {
        return (string) $this->getData(self::EVENT_START);
    }

    public function setStartAt(string $startAt)
    {
        $this->setData(self::EVENT_START, $startAt);
    }

    public function getEndAt(): string
    {
        return (string) $this->getData(self::EVENT_END);
    }

    public function setEndAt(string $endAt)
    {
        $this->setData(self::EVENT_END, $endAt);
    }

    public function getCreatedAt(): string
    {
        return (string) $this->getData(self::EVENT_CREATED);
    }

    public function setCreatedAt(string $createdAt)
    {
        $this->setData(self::EVENT_CREATED, $createdAt);
    }

    public function getUpdatedAt(): string
    {
        return (string) $this->getData(self::EVENT_UPDATED);
    }

    public function setUpdatedAt(string $updatedAt)
    {
        $this->setData(self::EVENT_UPDATED, $updatedAt);
    }

    public function getIsActive(): bool
    {
        return (bool) $this->getData(self::EVENT_ACTIVE);
    }

    public function setIsActive(int $status)
    {
        $this->setData(self::EVENT_ACTIVE, $status);
    }
}
