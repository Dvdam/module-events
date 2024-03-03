<?php

declare(strict_types=1);

namespace Dvdam\Events\Model\Source;

use Dvdam\Events\Model\Source;

/**
 * Class EventsTypes
 */
class EventsTypes extends Source
{
    /**
     *
     * {@inheritDoc}
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => 'personal',
                'label' => 'Personal'
            ],
            [
                'value' => 'business',
                'label' => 'Business'
            ],
            [
                'value' => 'family',
                'label' => 'Family'
            ],
            [
                'value' => 'holiday',
                'label' => 'Holiday'
            ],
            [
                'value' => 'free',
                'label' => 'Free'
            ]
        ];
    }
}
