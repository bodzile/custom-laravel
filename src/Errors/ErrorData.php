<?php

namespace Src\Errors;

final readonly class ErrorData{

    public function __construct(
        public int $statusCode,
        public string $title,
        public string $description
    ){}

}