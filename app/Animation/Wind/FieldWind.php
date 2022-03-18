<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Wind;

use TechBit\Snow\Animation\Object\IAnimationAliveObject;
use TechBit\Snow\Animation\Snow\ParticlesSet;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Math\PerlinNoise3D;


class FieldWind implements IAnimationAliveObject, IWind
{

    protected int $gridSize = 0;

    protected float $time = 0.0;

    protected array $grid = [];

    protected float $strengthMin = 0.0;

    protected float $strengthMax = 0.0;

    protected int $updateGridFrameCounter = 0;

    protected int $updateGridEveryNthFrame = 0;

    protected float $fieldWindVariation = 0.0;


    public function __construct(
        protected readonly ParticlesSet  $particles,
        protected readonly PerlinNoise3D $vectorDirectionNoise,
        protected readonly PerlinNoise3D $vectorPowerNoise,
        protected readonly Config $config,
        protected readonly Console $console )
    {
    }

    public function initialize(): void
    {
        $this->time = (float)time();

        $this->gridSize = $this->config->windFieldGridSize();
        $this->vectorPowerNoise->initialize(3);
        $this->vectorDirectionNoise->initialize(20);

        $this->updateGridEveryNthFrame = $this->config->windFieldGridUpdateEveryNthFrame();
        $this->updateGridFrameCounter = $this->updateGridEveryNthFrame;
        $this->fieldWindVariation = $this->config->windFieldVariation();
        $this->strengthMin = $this->config->windFieldStrengthMin() * 0.005;
        $this->strengthMax = $this->config->windFieldStrengthMax() * 0.005;

        $this->updateGrid();
    }

    public function update(): void
    {
        $this->time += 0.01 * $this->fieldWindVariation;
        if (!--$this->updateGridFrameCounter) {
            $this->updateGridFrameCounter = $this->updateGridEveryNthFrame;
            $this->updateGrid();
        }
    }


    public function moveParticle(int $idx): void
    {
        $particleX = (int)(($this->gridSize) * ($this->particles->x($idx) - $this->console->minX()) / $this->console->width());
        if ($particleX >= $this->gridSize || $particleX < 0) {
            return;
        }

        $particleY = (int)(($this->gridSize) * ($this->particles->y($idx) - $this->console->minY()) / $this->console->height());
        if ($particleY >= $this->gridSize || $particleY < 0) {
            return;
        }

        $this->particles->updateMomentumArr($idx, $this->grid[$particleX][$particleY]);
    }

    protected function updateGrid(): void
    {
        $squeezeFactor = 0.3;
        $howMuchUpRad = M_PI * 0.7;
        $strengthRange = $this->strengthMax - $this->strengthMin;

        for ($gy = 0; $gy < $this->gridSize; ++$gy) {
            for ($gx = 0; $gx < $this->gridSize; ++$gx) {
                $direction = $this->vectorDirectionNoise->generate($gx, $gy, $this->time);
                $power = $this->vectorPowerNoise->generate($gx, $gy, $this->time);

                $directionRad = -$howMuchUpRad + (0.5 + ($direction / 2)) * (M_PI + 2 * $howMuchUpRad);
                $powerScaled = exp($this->strengthMin + (0.5 + ($power / 2)) * ($strengthRange)) - 1;

                $this->grid[$gx][$gy] = [
                    -cos($directionRad) * $powerScaled,
                    sin($directionRad) * $powerScaled * $squeezeFactor,
                ];
            }
        }
    }
}

