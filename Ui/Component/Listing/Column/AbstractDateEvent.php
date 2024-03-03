<?php

declare(strict_types=1);

namespace Dvdam\Events\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;

/**
 * Class AbstractDateEvent
 *
 * @api
 * @since 100.1.0
 */
abstract class AbstractDateEvent extends Column
{

    /**
     * AbstractDateEvent constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param DateTime $locale
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface   $context,
        UiComponentFactory $uiComponentFactory,
        private readonly DateTime $locale,
        array              $components = [],
        array              $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Format Event Date
     *
     * @since 100.1.0
     */
    protected function formatEventDate($date): string
    {
        return $this->locale->date($date);
    }
}

