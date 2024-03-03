<?php

declare(strict_types=1);

namespace Dvdam\Events\Block\Adminhtml\Events\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'dvdam_events_form.dvdam_events_form',
                                'actionName' => 'save',
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
