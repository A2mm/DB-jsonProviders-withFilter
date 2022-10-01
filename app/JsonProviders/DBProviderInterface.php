<?php

namespace App\JsonProviders;

interface DBProviderInterface
{
    public function filterByStatus(string $status);
    public function filterByBalanceMin(int $from);
    public function filterByBalanceMax(int $to);
    public function filterByCurrency(string $currency);
    public function getAll();
}
