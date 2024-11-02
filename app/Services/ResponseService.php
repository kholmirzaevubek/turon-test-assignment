<?php

namespace App\Services;

use App\DTOs\ServiceResponseDTO;

final class ResponseService
{
    private function formatResponse(string $message, array $data, bool $error, string $column): ServiceResponseDTO
    {
        return new ServiceResponseDTO(
            message: $message,
            data: $data,
            error: $error,
            column: $column
        );
    }

    public function successResponse(array $data = [], string $message = '', string $column = ''): ServiceResponseDTO
    {
        return $this->formatResponse($message, $data, false, $column);
    }

    public function failureResponse(string $message = 'Operation failed', string $column = '', array $data = []): ServiceResponseDTO
    {
        return $this->formatResponse($message, $data, true, $column);
    }
}
