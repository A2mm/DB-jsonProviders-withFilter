<?php

namespace App\Services;

class DBJsonProviderService
{
    protected $JsonProviders = [
        'UsersProvider',
        'TransactionsProvider'
    ];
    
    protected $allowedFilters = [
        'provider',
        'statusCode',
        'balanceMin',
        'balanceMax',
        'currency'
    ];

    public function getAllParents(array $filters = [])
    {
        $parents = [];
        //make sure that no other GET attribute is here
        $filters = $this->validateFilters($filters);

        //get list of valid data sources based on the request
        $dataSources = $this->getValidDataSources($filters);
        foreach ($dataSources as $dataSource){
            // return $dataSource;
            //apply filters on each data source
            $this->processFilters($dataSource, $filters);
            //combine all datasources data
            $parents = array_merge($parents, json_decode($dataSource->getAll(), true));
        }
        return $parents;
        return array_values($parents)[0];
    }

    protected function validateFilters(array $filters = [])
    {
        $allowedFilters = $this->allowedFilters;
        $filtered = array_filter(
            $filters,
            function ($key) use ($allowedFilters) {
                return in_array($key, $allowedFilters);
            },
            ARRAY_FILTER_USE_KEY
        );

        return $filtered;
    }

    protected function getValidDataSources(array $filters = []):array
    {
        $dataSources = [];

        if(array_key_exists('provider', $filters) && in_array($filters['provider'], $this->JsonProviders)){
            $dataSources[] = app('App\JsonProviders\\'.$filters['provider']);
        }else{
            foreach ($this->JsonProviders as $dataSource){
                $dataSources[] = app('App\JsonProviders\\'.$dataSource);
            }
        }

        return $dataSources;
    }

    protected function processFilters($dataSource, $filters = [])
    {
        if(!empty($filters)){
            if(array_key_exists('statusCode', $filters) && !empty($filters['statusCode'])){
                $dataSource->filterByStatus($filters['statusCode']);
            }
             if(array_key_exists('balanceMin', $filters) && $filters['balanceMin'] >= 0 && $filters['balanceMin'] != ''){
                $dataSource->filterByBalanceMin($filters['balanceMin']);
            }
            if(array_key_exists('balanceMax', $filters) && $filters['balanceMax'] >= 0 && $filters['balanceMax'] != ''){
                $dataSource->filterByBalanceMax($filters['balanceMax']);
            }
            if(array_key_exists('currency', $filters) && !empty($filters['currency'])){
                $dataSource->filterByCurrency($filters['currency']);
            }
        }
    }
}