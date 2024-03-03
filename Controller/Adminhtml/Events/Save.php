<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Adminhtml\Events;

use Magento\Backend\Model\View\Result\Redirect;
use Dvdam\Events\Api\Data\EventsInterface;
use Dvdam\Events\Api\Data\EventsInterfaceFactory;
use Dvdam\Events\Api\EventsRepositoryInterface;
use Dvdam\Events\Model\Events;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;

/**
 * Saveevent action.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Save implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Dvdam_Events::save';

    public function __construct(
        private readonly ResultFactory $resultFactory,
        private readonly RequestInterface $request,
        private readonly ManagerInterface $messageManager,
        private readonly EventsRepositoryInterface $eventRepository,
        private readonly EventsInterfaceFactory $eventFactory,
        private readonly DataPersistorInterface $dataPersistor
    ) {}

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->request->getPostValue();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = EventsInterface::STATUS_ENABLED;
            }
            if (empty($data['event_id'])) {
                $data['event_id'] = null;
            }

            /** @var Events $model */
            $model = $this->eventFactory->create();

            $id = (int) $this->request->getParam('event_id');
            if ($id) {
                try {
                    $model = $this->eventRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This event no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->eventRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the event.'));
                $this->dataPersistor->clear('dvdam_events_event');
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the event.'));
            }

            $this->dataPersistor->set('dvdam_events_event', $data);
            return $resultRedirect->setPath('*/*/edit', ['event_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
