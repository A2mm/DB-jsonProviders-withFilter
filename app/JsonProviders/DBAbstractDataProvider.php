<?php

namespace App\JsonProviders;

abstract class DBAbstractDataProvider implements DBProviderInterface
{
    protected $storageFolder = "dataproviders";

    abstract public function filterByStatus(string $status);
    abstract public function filterByBalanceMin(int $from);
    abstract public function filterByBalanceMax(int $to);
    abstract public function filterByCurrency(string $currency);

    public function getAll()
    {
        # DATA FROM DB TABLE
        $tableName     = $this->fileName;
        $filteredUsers = \DB::table($tableName)->get();

        if(!empty($this->filters)){
            foreach ($filteredUsers as $parentKey => $parent){
                foreach ($this->filters as $filter){
                    if(!$this->compareFilterValue($parent, $filter)){
                        unset($filteredUsers[$parentKey]);
                    }
                }
            }
        }

        return $filteredUsers;
    }

    private function compareFilterValue($parent, array $filter)
    {
        $condition = false;
        switch ($filter['operator']){
            case ">=":
                if($parent->{$filter['name']} >= $filter['value']){
                    $condition = true;
                }
                break;
            case "<=":
                if($parent->{$filter['name']} <= $filter['value']){
                    $condition = true;
                }
                break;
            case "=":
            default:
                if(isset($parent->{$filter['name']}) && $parent->{$filter['name']} == $filter['value']){
                    $condition = true;
                }
                break;
        }
        return $condition;
    }
}
