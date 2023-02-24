<?php declare(strict_types=1);

namespace TechBit\Snow\Math;
use RuntimeException;

final class WeightedRandom {

    private readonly array $items;

    private int $totalWeight = 0;

    public function __construct(array $itemsWeightMap) { 
        $this->items = $itemsWeightMap;
        $this->totalWeight = array_sum($itemsWeightMap);
    }

    public function next(): mixed
    {
        $random = rand(0, $this->totalWeight);
        
        $weightIndex = 0;
        foreach($this->items as $item => $itemWeight) {
            $weightIndex += $itemWeight;
            if ($random <= $weightIndex) {
                return $item;
            }
        }

        throw new RuntimeException("No items to random!");
    }

}