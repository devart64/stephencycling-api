<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\Response;

interface ExceptionNormalizerFormatterInterface
{
    public function format(string $message, int $statusCode = Response::HTTP_BAD_REQUEST): array;
}
