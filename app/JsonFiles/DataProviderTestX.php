<?php

namespace App\JsonFiles;

class DataProviderTestX extends AbstractDataProvider
{
    protected $storageFolder = "dataproviders/tests";
    protected $fileName = "DataProviderTestX.json";
    protected $filters = [];
    protected $statusCodes = [
        'authorised' => 1,
        'decline' => 2,
        'refunded' => 3
    ];

    public function filterByStatus(string $status)
    {
        $this->filters[] = [
            'name'       => 'statusCode',
            'value'      => $this->statusCodes[$status],
            'operator'   => '='
        ];
    }

    public function filterByBalanceMin(int $from)
    {
        $this->filters[] = [
            'name'       => 'balance',
            'value'      => $from,
            'operator'   => '>='
        ];
    }

    public function filterByBalanceMax(int $to)
    {
        $this->filters[] = [
            'name'       => 'balance',
            'value'      => $to,
            'operator'   => '<='
        ];
    }

    public function filterByCurrency(string $currency)
    {
        $this->filters[] = [
            'name'       => 'currency',
            'value'      => $currency,
            'operator'   => '='
        ];
    }
}
