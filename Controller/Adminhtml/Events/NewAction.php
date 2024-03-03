<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Adminhtml\Events;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class NewAction
 */
class NewAction implements HttpGetActionInterface
{
    /**
     * NewAction constructor
     *
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        private readonly ResultFactory $resultFactory
    ) {}

    public function execute(): ResultInterface
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $page->forward('edit');
    }
}
