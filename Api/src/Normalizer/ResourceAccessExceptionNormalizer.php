<?php


namespace App\Normalizer;


use Symfony\Component\HttpFoundation\Response;

class ResourceAccessExceptionNormalizer extends AbstractNormalizer
{
    public function nomalize(\Exception $exception): array
    {
        return $this->exceptionNormalizerFormatter->format(
            $exception->getMessage(),
            Response::HTTP_UNAUTHORIZED
        );
    }
}