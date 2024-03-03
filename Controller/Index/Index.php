<?php

declare(strict_types=1);

namespace Dvdam\Events\Controller\Index;

use Exception;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Result\Page;
use Psr\Log\LoggerInterface;

/**
 * Class Index
 */
class Index implements HttpGetActionInterface
{
    /**
     * Index Constructor
     *
     * @param ResultFactory $resultFactory
     * @param RequestInterface $request
     * @param SerializerInterface $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ResultFactory $resultFactory,
        private readonly RequestInterface $request,
        private readonly SerializerInterface $serializer,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        try {
            /** @var Page $page */
            $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            // Add Metadata START
            $page->getConfig()->getTitle()->set(__('Full Calendar Magento 2'));

            $page->getConfig()->setRobots('NOINDEX,NOFOLLOW');
            $descriptionPage = __('This is a super test for learning magento 2 and full calendar use');
            $page->getConfig()->setDescription($descriptionPage);
            $page->getConfig()->setKeywords($this->keywords((string)$descriptionPage));
            // Add Metadata END
        } catch (Exception $e) {
            $msgError = $this->serializer->serialize($e->getMessage());
            $this->logger->error(__METHOD__ . $msgError);
        }

        return $page;
    }

    /**
     * Generate Meta keywords from large string
     *
     * @param string $string
     * @return string
     */
    private function keywords(string $string): string
    {
        $stringArray = explode(' ', $string);
        return implode(', ', $stringArray);
    }
}
