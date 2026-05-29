<?php

namespace App\Services\Export;

use App\Contracts\ExportServiceInterface;
use App\Contracts\PersonRepositoryInterface;

class ExportService implements ExportServiceInterface
{
    private const int PER_PAGE = 10000;

    private const array ALLOWED_FIELDS = ['last_name', 'first_name', 'phone', 'email'];

    private const array FIELD_LABELS = [
        'last_name' => 'Фамилия',
        'first_name' => 'Имя',
        'phone' => 'Телефон',
        'email' => 'E-mail',
    ];

    public function __construct(private readonly PersonRepositoryInterface $personRepository)
    {
    }

    public function start(int $requested, array $fields): array
    {
        $fields = $this->filterFields($fields);
        $max = $this->personRepository->count();
        $total = $requested > 0 ? min($requested, $max) : $max;

        $exportId = uniqid('export_', true);
        $path = $this->getFilePath($exportId);

        $handle = fopen($path, 'w');
        fputcsv($handle, array_map(fn($f) => self::FIELD_LABELS[$f], $fields));
        fclose($handle);

        return [
            'export_id' => $exportId,
            'total' => $total,
            'per_page' => self::PER_PAGE,
            'pages' => (int)ceil($total / self::PER_PAGE),
            'remaining' => $total,
            'last_id' => 0,
            'fields' => implode(',', $fields),
        ];
    }

    public function processChunk(string $exportId, int $lastId, int $remaining, array $fields): array
    {
        $fields = $this->filterFields($fields);
        $path = $this->getFilePath($exportId);
        $take = min(self::PER_PAGE, $remaining);

        $rows = $this->personRepository->getChunk($fields, $lastId, $take);

        $buffer = '';
        foreach ($rows as $row) {
            $row = (array)$row;
            $line = array_map(fn($f) => '"' . str_replace('"', '""', $row[$f]) . '"', $fields);
            $buffer .= implode(',', $line) . "\n";
        }

        file_put_contents($path, $buffer, FILE_APPEND);

        $processed = $rows->count();
        $newLastId = $processed > 0 ? $rows->last()->id : $lastId;

        return [
            'processed' => $processed,
            'last_id' => $newLastId,
            'remaining' => $remaining - $processed,
        ];
    }

    public function getFilePath(string $exportId): string
    {
        return storage_path("app/exports/$exportId.csv");
    }

    private function filterFields(array $fields): array
    {
        $filtered = array_values(array_filter($fields, fn($f) => in_array($f, self::ALLOWED_FIELDS, true)));

        return !empty($filtered) ? $filtered : self::ALLOWED_FIELDS;
    }
}
