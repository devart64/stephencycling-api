<?php


namespace App\Normalizer;


use Symfony\Component\HttpFoundation\Response;

class AuthentificationExceptionNormalizer extends AbstractNormalizer
{
    public function nomalize(\Exception $exception): array
    {
        $result['code'] = Response::HTTP_UNAUTHORIZED;
        $result['body'] = [
            'code' => $result['code'],
            'message' => $exception->getMessage()
        ];
        return $result;
    }
}