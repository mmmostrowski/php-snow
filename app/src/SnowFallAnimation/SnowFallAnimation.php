<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation;

use TechBit\Snow\SnowFallAnimation\Config\Config;
use TechBit\Snow\SnowFallAnimation\Frame\IFramePainter;
use TechBit\Snow\SnowFallAnimation\Object\AnimationObjects;
use TechBit\Snow\App\IAnimation;
use TechBit\Snow\Console\IConsole;
use TechBit\Snow\Console\InvalidConsoleSizeException;


final class SnowFallAnimation implements IAnimation
{

    private IConsole $console;
    private IFramePainter $painter;
    private Config $config;

    public function __construct(
        private readonly AnimationContext $context,
        private readonly AnimationObjects $objects,
    )
    {
        $this->console = $this->context->console();
        $this->painter = $this->context->painter();
        $this->config = $this->context->config();
    }

    /**
     * @throws InvalidConsoleSizeException
     */
    public function initialize(): void
    {
        $this->console->ensureConsoleValidSize(
            $this->config->minRequiredConsoleWidth(),
            $this->config->minRequiredConsoleHeight(),
        );

        foreach ($this->objects->allObjects() as $object) {
            $object->initialize($this->context);
        }
    }

    public function play(): void
    {
        $this->painter->clearWindow();

        $visibleObjects = $this->objects->allVisibleObjects();
        $aliveObjects = $this->objects->allAliveObjects();

        foreach ($visibleObjects as $object) {
            $object->renderFirstFrame();
        }

        $maxFrames = $this->context->config()->animationLengthInFrames();
        while (--$maxFrames) {
            foreach ($aliveObjects as $object) {
                $object->update();
            }

            foreach ($visibleObjects as $object) {
                $object->renderLoopFrame();
            }
        }
    }

}