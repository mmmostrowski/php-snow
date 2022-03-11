<?php

namespace TechBit\Snow\Animation\Frame;

use TechBit\Snow\Animation\Object\IAnimationObject;
use TechBit\Snow\Config\Config;

class FrameStabilizer implements IAnimationObject
{

    /**
     * @var float
     */
    protected $lastFrame = 0.0;

    /**
     * @var float
     */
    protected $targetFps = 0.0;

    /**
     * @var int
     */
    protected $intervalMs = 0;

    /**
     * @var int
     */
    protected $lastSecond = 0;

    /**
     * @var int
     */
    protected $frameCounter = 0;

    /**
     * @var int
     */
    protected $currentFps = 0;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function initialize()
    {
        $this->targetFps = (int)$this->config->fps();
        $this->intervalMs = (int)(1000 / $this->targetFps);
        $this->lastSecond = (int)microtime(true);;
    }

    public function beginFrame()
    {
        $this->lastFrame = microtime(true);
    }

    public function endFrame()
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

        $howMuchWaitMs = $this->intervalMs - $deltaSec * 1000;
        if ($howMuchWaitMs > 0) {
            usleep((int)($howMuchWaitMs * 1000));
        }
    }

    public function fps()
    {
        return $this->currentFps;
    }

}