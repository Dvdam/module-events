<?php

declare(strict_types=1);

namespace Dvdam\Events\Ui\Source\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class IsActive implements OptionSourceInterface
{
    private const ENABLED = 1;
    private const DISABLED = 0;

    /**
     * Options to array
     *
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::ENABLED,
                'label' => __('Enabled')
            ],
            [
                'value' => self::DISABLED,
                'label' => __('Disabled')
            ]
        ];
    }
}
