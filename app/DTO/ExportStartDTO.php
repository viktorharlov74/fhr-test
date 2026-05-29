<?php

namespace App\DTO;

use JsonSerializable;

readonly class ExportStartDTO implements JsonSerializable
{
    public function __construct(
        public string $exportId,
        public int $total,
        public int $perPage,
        public int $pages,
        public int $remaining,
        public int $lastId,
        public string $fields,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'export_id' => $this->exportId,
            'total'     => $this->total,
            'per_page'  => $this->perPage,
            'pages'     => $this->pages,
            'remaining' => $this->remaining,
            'last_id'   => $this->lastId,
            'fields'    => $this->fields,
        ];
    }
}
