<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Frame;

use TechBit\Snow\Animation\Object\IAnimationObject;
use TechBit\Snow\Config\Config;

class FrameStabilizer implements IAnimationObject
{

    protected float $lastFrame = 0.0;

    protected float $targetFps = 0.0;

    protected int $intervalMs = 0;

    protected int $lastSecond = 0;

    protected int $frameCounter = 0;

    protected int $currentFps = 0;

    public function __construct(
        protected readonly Config $config)
    {
    }

    public function initialize(): void
    {
        $this->targetFps = $this->config->fps();
        $this->intervalMs = (int)(1000 / $this->targetFps);
        $this->lastSecond = (int)microtime(true);;
    }

    public function fps(): int
    {
        return $this->currentFps;
    }

    public function beginFrame(): void
    {
        $this->lastFrame = microtime(true);
    }

    public function endFrame(): void
    {
        $nowMicro = microtime(true);
        $nowSec = (int)$nowMicro;

        ++$this->frameCounter;
        if ($this->lastSecond < $nowSec) {
            $this->lastSecond = $nowSec;
            $this->currentFps = $this->frameCounter;
            $this->frameCounter = 0;
        }

        $deltaSec = $nowMicro - $this->lastFrame;

        $waitMs = $this->intervalMs - $deltaSec * 1000;
        if ($waitMs > 0) {
            usleep((int)($waitMs * 1000));
        }
    }

}