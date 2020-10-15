<?php


namespace App\Normalizer;


abstract class AbstractNormalizer implements NormalizerInterface
{

    /**
     * @var array
     */
    private $exceptionTypes;

    public function __construct(array $exceptionTypes)
    {

        $this->exceptionTypes = $exceptionTypes;
    }



    public function supports(\Exception $exception): bool
    {
        // TODO: Implement supports() method.
    }

    public function nomalize(\Exception $exception): array
    {
        // TODO: Implement nomalize() method.
    }
}