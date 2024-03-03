<?php

declare(strict_types=1);

namespace Dvdam\Events\Api\Data;

interface EventsInterface
{
    public const EVENT_ID = 'event_id';
    public const EVENT_TITLE = 'title';
    public const EVENT_CONTENT = 'content';
    public const EVENT_LABEL_TYPE = 'label_type';
    public const EVENT_START = 'start';
    public const EVENT_END = 'end';
    public const EVENT_CREATED = 'created_at';
    public const EVENT_UPDATED = 'updated_at';
    public const EVENT_ACTIVE = 'is_active';

    public const STATUS_DISABLED = 0;
    public const STATUS_ENABLED = 1;

    public function getEventId(): int;
    public function setEventId(int $eventId);
    public function getTitle(): string;
    public function setTitle(string $title);

    public function getContent(): string;
    public function setContent(string $content);

    public function getLabelType(): string;
    public function setLabelType(string $type);

    public function getStartAt(): string;
    public function setStartAt(string $startAt);
    public function getEndAt(): string;
    public function setEndAt(string $endAt);

    public function getCreatedAt(): string;
    public function setCreatedAt(string $createdAt);
    public function getUpdatedAt(): string;
    public function setUpdatedAt(string $updatedAt);
    public function getIsActive(): bool;
    public function setIsActive(int $status);
}
