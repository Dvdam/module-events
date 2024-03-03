<?php

declare(strict_types=1);

namespace Dvdam\Events\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Event
 */
class Events extends AbstractDb
{
    private const TABLE_NAME = 'dvdam_events';
    private const FIELD_NAME = 'event_id';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::FIELD_NAME);
    }

    protected function _beforeSave(AbstractModel $object)
    {
        $object->setData('updated_at', 0);
        return parent::_beforeSave($object);
    }
}
