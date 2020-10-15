<?php


namespace App\Normalizer;


interface NormalizerInterface
{
        public function nomalize(\Exception $exception): array;
        public function supports(\Exception $exception): bool;
}