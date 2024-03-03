<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Adminhtml\Events;

use Dvdam\Events\Api\EventsRepositoryInterface;
use Dvdam\Events\Model\Events;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\RequestInterface;

/**
 * Class InlineEdit
 */
class InlineEdit implements HttpPostActionInterface
{
    /**
     * InlineEdit constructor
     *
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     * @param EventsRepositoryInterface $eventRepository
     */
    public function __construct(
        private readonly RequestInterface $request,
        private readonly ResultFactory $resultFactory,
        private readonly EventsRepositoryInterface $eventRepository
    ) {}

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $items = $this->request->getParam('items');
        $messages = [];
        $error = false;

        if (!count($items)) {
            $messages[] = __('Please correct the data sent.');
            $error = true;
        } else {

            foreach (array_keys($items) as $eventId) {
                try {
                    /** @var Events $event */
                    $event = $this->eventRepository->getById((int) $eventId);
                    $event->setData(array_merge($event->getData(), $items[$eventId]));
                    $this->eventRepository->save($event);
                } catch (\Throwable $exception) {
                    $messages[] = '[Event ID: ' . $eventId . '] ' . $exception->getMessage();
                    $error = true;
                }
            }
        }

        return $result->setData(
            [
                'messages' => $messages,
                'error' => $error
            ]
        );
    }

}
