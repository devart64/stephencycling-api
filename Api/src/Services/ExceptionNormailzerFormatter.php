<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\Response;

class ExceptionNormailzerFormatter implements ExceptionNormalizerFormatterInterface
{
    public function format(string $message, int $statusCode = Response::HTTP_BAD_REQUEST): array
    {
        return [
            'code' => $statusCode,
            'message' => $message
        ];
    }
}