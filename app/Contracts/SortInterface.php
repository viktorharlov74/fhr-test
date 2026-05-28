<?php

namespace App\Contracts;

interface SortInterface
{
    public function sort(array $data): array;
}