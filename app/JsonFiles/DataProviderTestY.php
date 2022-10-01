<?php

namespace App\JsonFiles;

class DataProviderTestY extends AbstractDataProvider
{
    protected $storageFolder = "dataproviders/tests";
    protected $fileName = "DataProviderTestY.json";
    protected $filters = [];
    
    protected $statusCodes = [
        'authorised'       => 1,
        'decline'          => 2,
        'refunded'         => 3,
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
            'name'       => 'paidAmount',
            'value'      => $from,
            'operator'   => '>='
        ];
    }

    public function filterByBalanceMax(int $to)
    {
        $this->filters[] = [
            'name'       => 'paidAmount',
            'value'      => $to,
            'operator'   => '<='
        ];
    }

    public function filterByCurrency(string $currency)
    {
        $this->filters[] = [
            'name'       => 'Currency',
            'value'      => $currency,
            'operator'   => '='
        ];
    }
}
