<?php

declare(strict_types=1);

namespace Dvdam\Events\Ui\Component\Listing\Column;

/**
 * Class Created
 *
 * @api
 * @since 100.1.0
 */
class Created extends AbstractDateEvent
{

    /**
     * {@inheritdoc}
     * @since 100.1.0
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        foreach ($dataSource['data']['items'] as &$item) {
            $item['created_at'] = $this->formatEventDate($item['created_at']);
        }

        return $dataSource;
    }
}

