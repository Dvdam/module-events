<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Ajax;

use Exception;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Dvdam\Events\Api\Data\EventsInterface;

/**
 * Class Events
 */
class Events extends AbstractEvents implements HttpGetActionInterface
{
    // @codingStandardsIgnoreStart
    /**
     * Ajax call handler
     *
     * @inheirtDoc
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $response = [
            'status' => false
        ];

        $data = $this->request->getParams();

        if (!$this->formKeyValidator->validate($this->request)) {
            $response['message'] = 'Invalid Data';
            return $resultJson->setData($response);
        }

        try {

            if ($data['requestType'] === 'getEvents' && $data['isAjax']) {

                $events =  $this->eventsManagement->getEvents();
                $eventsData = [];
                $eventData = [];
                $data = false;

                if ($events->count() > 0) {
                    /** @var  $event EventsInterface */
                    foreach ($events as $key => $event) {
                        if($event->getIsActive()) {
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

                    $response['status'] = true;;
                    $response['events'] = $eventsData;
                }
            } else {
                $response['message'] = 'Some Error';
            }
        } catch (Exception $e) {
            $this->logger->error(__METHOD__. $this->serializer->serialize($e->getMessage()));
            $response['message'] = $e->getMessage();
        }

        $resultJson->setData($response);
        return $resultJson;
    }
    // @codingStandardsIgnoreEnd
}
