<?php

declare(strict_types=1);

namespace Dvdam\Events\Model;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Source
 */
abstract class Source implements OptionSourceInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    abstract public function toOptionArray(): array;

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray(): array
    {
        $_tmpOptions = $this->toOptionArray();
        $_options = [];
        foreach ($_tmpOptions as $option) {
            $_options[$option['value']] = $option['label'];
        }
        return $_options;
    }
}
