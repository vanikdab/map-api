<?php


namespace App\Classes;

use App\Contracts\MapStrategyInterface;

class MapContext
{
    private $mapStrategy;

    public function __construct(MapStrategyInterface $mapStrategy) {
        $this->mapStrategy = $mapStrategy;
    }

    public function executeHttpRequest(string $purpose, string$input) {
        return $this->mapStrategy->httpRequest($purpose, $input)->collect();
    }

    public function switchMapStrategy(MapStrategyInterface $mapStrategy)
    {
        $this->mapStrategy = $mapStrategy;

        return $this;
    }
}
