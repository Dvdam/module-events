<?php

declare(strict_types=1);

namespace Dvdam\Events\Model\ResourceModel\Events;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Dvdam\Events\Model\Events;
use Dvdam\Events\Model\ResourceModel\Events as EventsResource;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    /**
     * Collection contructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Events::class, EventsResource::class);
    }
}
