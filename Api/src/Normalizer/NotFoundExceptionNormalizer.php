<?php


namespace App\Normalizer;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class NotFoundExceptionNormalizer extends AbstractNormalizer
{
    public function normalize(Exception $exception): array
    {
        return $this->exceptionNormalizerFormatter->format(
            $exception->getMessage(),
            Response::HTTP_NOT_FOUND
        );
    }
}
