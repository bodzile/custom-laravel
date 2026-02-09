<?php

namespace Src\Queries;

final readonly class QueryParts
{
    public function __construct(
        public array $select = [],
        public string $selectRaw = "",
        public bool $aggregates = false,
        public array $where = [
            "columns" => [],
            "sql" => ""
        ],
        public string $groupBy = "",
        public string $orderBy = "",
        public int $limit= 0
    ){}
}