<?php

namespace App\DTOs;

final class ServiceResponseDTO
{
    public function __construct(
        public readonly string $message,
        public readonly mixed $data,
        public readonly bool $error,
        public readonly string $column
    ){
    }
}
