<?php
namespace App\Contracts;

use Illuminate\Support\Collection;

interface MapStrategyInterface {
    /**
     * @param string $purpose
     * @param string $input
     * @return MapStrategyInterface
     */
    public function httpRequest(string$purpose, string$input): MapStrategyInterface;

    /**
     * Must return collected data.
     * @return Collection
     */
    public function collect(): Collection;
}
