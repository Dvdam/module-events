<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Ajax;

use Exception;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Dvdam\Events\Model\Events;
use Dvdam\Events\Model\Utils\Validators;
use function json_encode;

/**
 * Class Events
 */
class Create extends AbstractEvents implements HttpPostActionInterface
{
    private const STATUS = 'status';
    private const TITLE = 'title';
    private const CONTENT = 'content';
    private const ERROR = 'error';

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
            self::STATUS => false
        ];

        try {
            $data = $this->request->getParams();
            if ($this->validateData($data)[self::STATUS] === false) {
                return $this->createResponse($resultJson, $this->validateData($data));
            }

            if ($data[self::TITLE] != '' &&
                $data['request_type'] === 'addEvent' &&
                $data['start'] != ''
            ) {

                /** @var Events $event */
                $event = $this->eventFactory->create();
                $event->setData($data);

                $this->eventRepository->save($event);

                // get new event data
                $eventCreate = $this->eventsManagement->getLastEventCreate($data['title']);

                $response[self::STATUS] = true;
                $response['event_id'] = $eventCreate->getEventId();
                $response['event_title'] = $eventCreate->getTitle();
                $response['event_start'] = $eventCreate->getStartAt();
                $response['event_end'] = $eventCreate->getEndAt();
                $response['event_type'] = $eventCreate->getLabelType();
            } else {
                $response[self::ERROR] = 'Some Error';
            }
        } catch (Exception $e) {
            $this->logger->error(__METHOD__. $this->serializer->serialize($e->getMessage()));
            $response[self::ERROR] = $e->getMessage();
        }

        return $this->createResponse($resultJson, $response);
    }

    /**
     * Validate Event Data
     *
     * @param array $data
     * @return array
     */
    private function validateData(array $data): array
    {
        $errors = [];
        $process = [];

        $this->logger->info(__METHOD__ . ' '. json_encode($data));

        $title = $data[self::TITLE];
        $content = $data[self::CONTENT];

        if (!is_string($title) &&
            '' !== $title ||
            $this->validators->notValidStrLen($title, Validators::MIN, Validators::MAX) ||
            $this->validators->notOnlyText($title)
        ) {
            $errors[self::TITLE] = self::ERROR;
        }

        if (!is_string($content) &&
            '' !== $content ||
            $this->validators->notValidStrLen($content, Validators::MIN, Validators::MAX) ||
            $this->validators->notOnlyText($content)
        ) {
            $errors[self::CONTENT] = self::ERROR;
        }

        if (!empty($errors)) {
            $this->logger->info(__METHOD__ . ' Process Data Error Input ' . json_encode($errors));
            $process[self::ERROR] = 'Some Data is not valid';
            $process[self::STATUS] = false;
        } else {
            $process[self::STATUS] = true;
        }

        // TODO: Remove logs
        $this->logger->info(__METHOD__ . ' Process Data ' . json_encode($process));

        return $process;
    }

    /**
     * @param $resultJson
     * @param $data
     * @return mixed
     */
    private function createResponse($resultJson, $data)
    {
        $resultJson->setData($data);
        return $resultJson;
    }
    // @codingStandardsIgnoreEnd
}
