<?php

namespace TechBit\Snow\Animation\Wind;

use TechBit\Snow\Animation\Object\IAnimationAliveObject;
use TechBit\Snow\Animation\Snow\ParticlesSet;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Math\Interpolation;
use TechBit\Snow\Math\PerlinNoise3D;

class FieldWind implements IAnimationAliveObject, IWind
{

    /**
     * @var ParticlesSet
     */
    protected $particles;

    /**
     * @var int
     */
    protected $gridSize = 0;

    /**
     * @var float
     */
    protected $time = 0.0;

    /**
     * @var PerlinNoise3D
     */
    protected $vectorDirectionNoise;

    /**
     * @var PerlinNoise3D
     */
    protected $vectorPowerNoise;

    /**
     * @var array[]
     */
    protected $grid = [];
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Console
     */
    protected $console;

    /**
     * @var float
     */
    protected $strengthMin = 0.0;

    /**
     * @var float
     */
    protected $strengthMax = 0.0;

    /**
     * @var int
     */
    protected $updateGridFrameCounter = 0;

    /**
     * @var int
     */
    protected $updateGridEveryNthFrame = 0;

    /**
     * @var float
     */
    protected $fieldWindVariation = 0.0;
    /**
     * @var Interpolation
     */
    protected $interpolation;


    public function __construct(
        ParticlesSet  $particles, PerlinNoise3D $vectorDirectionNoise,
        PerlinNoise3D $vectorPowerNoise, Config $config, Console $console,
        Interpolation $interpolation
    )
    {
        $this->particles = $particles;
        $this->vectorDirectionNoise = $vectorDirectionNoise;
        $this->vectorPowerNoise = $vectorPowerNoise;
        $this->config = $config;
        $this->console = $console;
        $this->interpolation = $interpolation;
    }

    public function initialize()
    {
        $this->time = (float)time();

        $this->gridSize = (int)$this->config->windFieldGridSize();
        $this->vectorPowerNoise->initialize(3);
        $this->vectorDirectionNoise->initialize(20);

        $this->updateGridEveryNthFrame = $this->config->windFieldGridUpdateEveryNthFrame();
        $this->updateGridFrameCounter = $this->updateGridEveryNthFrame;
        $this->fieldWindVariation = $this->config->windFieldVariation();
        $this->strengthMin = $this->config->windFieldStrengthMin() * 0.005;
        $this->strengthMax = $this->config->windFieldStrengthMax() * 0.005;

        $this->updateGrid();
    }

    public function update()
    {
        $this->time += 0.01 * $this->fieldWindVariation;
        if (!--$this->updateGridFrameCounter) {
            $this->updateGridFrameCounter = $this->updateGridEveryNthFrame;
            $this->updateGrid();
        }
    }


    public function moveParticle($idx)
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

    protected function updateGrid()
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

