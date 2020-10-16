<?php


namespace App\Normalizer;


use App\Services\ExceptionNormalizerFormatterInterface;

abstract class AbstractNormalizer implements NormalizerInterface
{

    /**
     * @var array
     */
    private $exceptionTypes;
    /**
     * @var ExceptionNormalizerFormatterInterface
     */
    protected $exceptionNormalizerFormatter;

    public function __construct(array $exceptionTypes, ExceptionNormalizerFormatterInterface $exceptionNormalizerFormatter)
    {

        $this->exceptionTypes = $exceptionTypes;
        $this->exceptionNormalizerFormatter = $exceptionNormalizerFormatter;
    }



    public function supports(\Exception $exception): bool
    {
        return in_array(get_class($exception), $this->exceptionTypes, true);
    }


}