<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Adminhtml\Events;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\Page;

/**
 * Class Index
 */
class Index implements HttpGetActionInterface
{
    /**
     * Index constructor
     *
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        private readonly PageFactory $resultPageFactory
    ) {
    }

    public function execute(): ResultInterface
    {
        /** @var Page $page */
        $page = $this->resultPageFactory->create();

        $page->setActiveMenu('Dvdam_Events::event');
        $page->addBreadcrumb(__('Events'), __('Events'));
        $page->addBreadcrumb(__('Manage Events'), __('Manage Events'));
        $page->getConfig()->getTitle()->prepend(__('Events'));

        return $page;
    }

}
