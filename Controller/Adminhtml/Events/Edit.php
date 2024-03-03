<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Adminhtml\Events;

use Dvdam\Events\Api\Data\EventsInterfaceFactory;
use Dvdam\Events\Api\EventsRepositoryInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\Page;

/**
 * Class Edit
 */
class Edit implements HttpGetActionInterface
{
    /**
     * Edit constructor
     *
     * @param PageFactory $resultPageFactory
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     * @param EventsInterfaceFactory $eventFactory
     * @param EventsRepositoryInterface $eventRepository
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        private readonly PageFactory $resultPageFactory,
        private readonly RequestInterface $request,
        private readonly ManagerInterface $messageManager,
        private readonly EventsInterfaceFactory $eventFactory,
        private readonly EventsRepositoryInterface $eventRepository,
        private readonly DataPersistorInterface $dataPersistor
    ) {}

    public function execute(): ResultInterface
    {
        /** @var Page $page */
        $page = $this->resultPageFactory->create();

        $eventId = (int) $this->request->getParam('event_id',0);

        if ($eventId) {
            $event = $this->eventRepository->getById($eventId);
            try {
                $this->dataPersistor->set('dvdam_events_event', $event->getData());
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(
                    __('The event with the given id does not exist.')
                );
            }
        } else {
            $event = $this->eventFactory->create();
        }
        $page->setActiveMenu('Dvdam_Events::events');
        $page->addBreadcrumb(__('Events'), __('Events'));
        $page->addBreadcrumb(
            $event->getEventId() ? __('Edit Event') : __('New Event'),
            $event->getEventId() ? __('Edit Event') : __('New Event')
        );
        $page->getConfig()->getTitle()->prepend(
            $event->getEventId() ? $event->getTitle() : __('New Event')
        );

        return $page;
    }
}
