<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Ajax;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Psr\Log\LoggerInterface;
use Dvdam\Events\Api\Data\EventsInterfaceFactory;
use Dvdam\Events\Api\EventsRepositoryInterface;
use Dvdam\Events\Api\EventsManagementInterface;
use Dvdam\Events\Model\Utils\Validators;

/**
 * Abstract Class AbstractEvents
 */
abstract class AbstractEvents
{
    /**
     * Checkout Ajax handler Constructor
     *
     * @param ResultFactory $resultFactory
     * @param RequestInterface $request
     * @param SerializerInterface $serializer
     * @param FormKeyValidator $formKeyvalidator
     * @param EventsRepositoryInterface $eventRepository
     * @param EventsInterfaceFactory $eventFactory
     * @param EventsManagementInterface $eventsManagement
     * @param LoggerInterface $logger
     * @param Validators $validators
     */
    public function __construct(
        protected readonly ResultFactory $resultFactory,
        protected readonly RequestInterface $request,
        protected readonly SerializerInterface $serializer,
        protected readonly FormKeyValidator $formKeyValidator,
        protected EventsRepositoryInterface $eventRepository,
        protected EventsInterfaceFactory $eventFactory,
        protected EventsManagementInterface $eventsManagement,
        protected readonly LoggerInterface $logger,
        protected readonly Validators $validators
    ) {
    }
}
