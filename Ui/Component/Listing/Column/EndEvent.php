<?php

declare(strict_types=1);

namespace Dvdam\Events\Ui\Component\Listing\Column;

/**
 * Class EndEvent
 *
 * @api
 * @since 100.1.0
 */
class EndEvent extends AbstractDateEvent
{

    /**
     * {@inheritdoc}
     * @since 100.1.0
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        foreach ($dataSource['data']['items'] as &$item) {
            $item['end'] = $this->formatEventDate($item['end']);
        }

        return $dataSource;
    }
}

