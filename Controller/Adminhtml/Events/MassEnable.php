<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Adminhtml\Events;

use Dvdam\Events\Api\Data\EventsInterface;
use Dvdam\Events\Api\EventsRepositoryInterface;
use Dvdam\Events\Model\ResourceModel\Events\Collection;
use Dvdam\Events\Model\ResourceModel\Events\CollectionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class MassEnable
 */
class MassEnable implements HttpPostActionInterface
{
    /**
     * MassEnable constructor
     *
     * @param ManagerInterface $messageManager
     * @param ResultFactory $resultFactory
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param EventsRepositoryInterface $eventRepository
     */
    public function __construct(
        private readonly ManagerInterface $messageManager,
        private readonly ResultFactory $resultFactory,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly EventsRepositoryInterface $eventRepository
    ) {}

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        try {
            /** @var Collection $collection */
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();

            /** @var EventsInterface $event */
            foreach ($collection as $event) {
                $event->setIsActive(EventsInterface::STATUS_ENABLED);
                $this->eventRepository->save($event);
            }

            $this->messageManager->addSuccessMessage(
                __(' A total of %1 record(s) have been Enabled.', $collectionSize)
            );

        } catch (\Throwable $exception) {
            $this->messageManager->addErrorMessage(
                __('Something went wrong while processing the operation')
            );
        }

        // update
        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $result->setPath('dvdam_events/events/index');
    }

}
