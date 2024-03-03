<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Adminhtml\Events;

use Dvdam\Events\Api\EventsRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class Delete
 */
class Delete implements HttpPostActionInterface
{
    /**
     * Delete constructor
     *
     * @param ManagerInterface $messageManager
     * @param RequestInterface $request
     * @param ResultFactory $resultFactory
     * @param EventsRepositoryInterface $eventRepository
     */
    public function __construct(
        private readonly ManagerInterface $messageManager,
        private readonly RequestInterface $request,
        private readonly ResultFactory $resultFactory,
        private readonly EventsRepositoryInterface $eventRepository
    ) {

    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $eventId = (int) $this->request->getParam('event_id', 0);
        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (!$eventId) {
            $this->messageManager->addWarningMessage(
                __('The event with the provided id wa not found.')
            );
            return $result->setPath('dvdam_events/events/index');
        }

        try {
            $event = $this->eventRepository->getById($eventId);

            if (!$event->getEventId()) {
                $this->messageManager->addWarningMessage(
                    __('The event with the provided id wa not found.')
                );
            } else {
                $this->eventRepository->delete($event);
                $this->messageManager->addSuccessMessage(
                    __(' The event has been Deleted.')
                );
            }

        } catch (\Throwable $exception) {
            $this->messageManager->addErrorMessage(
                __('Something went wrong while processing the operation')
            );
        }

        return $result->setPath('dvdam_events/events/index');
    }

}
