<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Wind;


use TechBit\Snow\SnowFallAnimation\AnimationContext;

final class WindComposition implements IWind
{

    /**
     * @param IWind[] $windForces
     */
    public function __construct(private readonly array $windForces)
    {
    }

    public function initialize(AnimationContext $context): void
    {
        foreach ($this->windForces as $wind) {
            $wind->initialize($context);
        }
    }

    public function update(): void
    {
        foreach ($this->windForces as $wind) {
            $wind->update();
        }
    }

    public function moveParticle(int $idx): void
    {
        foreach ($this->windForces as $wind) {
            $wind->moveParticle($idx);
        }
    }

}