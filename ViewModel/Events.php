<?php

declare(strict_types=1);

namespace Dvdam\Events\ViewModel;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Data\Form\FormKey;
use Dvdam\Events\Api\Data\EventsInterface;
use Dvdam\Events\Api\EventsManagementInterface;

/**
 * Class Events
 */
class Events implements ArgumentInterface
{
    /**
     * Events constructor
     *
     * @param FormKey $formKey
     * @param SerializerInterface $serializer
     * @param EventsManagementInterface $eventManagement
     */
    public function __construct(
        private readonly FormKey $formKey,
        private readonly SerializerInterface $serializer,
        private readonly EventsManagementInterface $eventManagement
    ) {}

    /**
     * Get all events
     *
     * @return bool|array|null
     */
    public function getEvents(): bool|array|null
    {
        $events = $this->eventManagement->getEvents();
        $eventsData = [];
        $eventData = [];
        $data = false;

        if ($events->count() > 0) {
            /** @var  $event EventsInterface */
            foreach ($events as $key => $event) {
                if ($event->getIsActive()) {
                    $eventData['title'] = $event->getTitle();
                    $eventData['start'] = $event->getStartAt();
                    $eventData['end'] = $event->getEndAt();
                    $eventData['allDay'] = false;
                    $eventData['overlap'] = false;
                    $eventData['color'] = $event->getLabelType();
                    $eventData['textColor'] = $event->getLabelType();
                    $eventData['id'] = $event->getEventId();
    
                    $eventsData[] = $eventData;
                }
           }
           $data = $eventsData;
        }

       return $data;
    }

    public function serialize($data): bool|string
    {
        return $this->serializer->serialize($data);
    }

    /**
     * Get Form Key
     * @return string
     * @throws LocalizedException
     */
    public function getFormKey(): string
    {
        return $this->formKey->getFormKey();
    }
}
