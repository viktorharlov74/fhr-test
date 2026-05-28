<?php

namespace App\Services\Sorting;

use App\Contracts\SortInterface;

class BubbleSortService implements SortInterface
{
    /**
     * Реализация пузырьковой сортировки.
     * Флаг $swapped даёт досрочный выход, если массив частично упорядочен, экономим проходы.
     * Сужение верхней границы убирает отсортированный "хвост" каждой итерации.
     * @param array $data
     * @return array
     */
    public function sort(array $data): array
    {
        $totalElements = count($data);

        if ($totalElements === 0) {
            return $data;
        }
        $lastIndex = $totalElements - 1; // элементы правее границы уже стоят на месте

        for ($pass = 0; $pass < $lastIndex; $pass++) {
            $swapped = false;
            $unsortedBoundary = $lastIndex - $pass; // с каждым проходом правая граница сужается

            for ($current = 0; $current < $unsortedBoundary; $current++) {
                if ($data[$current] > $data[$current + 1]) {
                    $temp = $data[$current];
                    $data[$current] = $data[$current + 1];
                    $data[$current + 1] = $temp;
                    $swapped = true;
                }
            }

            if (!$swapped) {
                break;
            }
        }

        return $data;
    }
}
