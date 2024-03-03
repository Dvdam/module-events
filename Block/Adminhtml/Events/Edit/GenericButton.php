<?php

declare(strict_types=1);

namespace Dvdam\Events\Block\Adminhtml\Events\Edit;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

/**
 * Abstract Class GenericButton
 */
abstract class GenericButton
{
    /**
     * @param UrlInterface $url
     * @param RequestInterface $request
     */
    public function __construct(
        private readonly UrlInterface $url,
        private readonly RequestInterface $request
    ) {}

    /**
     * Return DAM Events ID
     *
     * @return int
     */
    public function getEventId(): int
    {
        return (int) $this->request->getParam('event_id', 0);
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->url->getUrl($route, $params);
    }
}
