<?php

declare(strict_types=1);

namespace Dvdam\Events\Ui\Component\Listing\Column;

/**
 * Class Updated
 *
 * @api
 * @since 100.1.0
 */
class Updated extends AbstractDateEvent
{

    /**
     * {@inheritdoc}
     * @since 100.1.0
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        foreach ($dataSource['data']['items'] as &$item) {
            $item['updated_at'] = $this->formatEventDate($item['updated_at']);
        }

        return $dataSource;
    }
}

