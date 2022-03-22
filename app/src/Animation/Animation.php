<?php declare(strict_types=1);

namespace TechBit\Snow\Animation;

use Psr\Container\ContainerExceptionInterface;
use TechBit\Snow\Animation\Frame\FrameStabilizer;
use TechBit\Snow\Animation\Object\Collector;
use TechBit\Snow\Animation\Renderer\Renderer;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Console\InvalidConsoleSizeException;


class Animation
{

    public function __construct(
        protected readonly Console $console,
        protected readonly Config $config,
        protected readonly FrameStabilizer $stabilizer,
        protected readonly Collector $collector,
        protected readonly AnimationObjectsList $animationObjects,
        protected readonly Renderer $renderer)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws InvalidConsoleSizeException
     */
    public function initialize(): void
    {
        $this->ensureConsoleValidSize();

        $this->collector->collect($this->animationObjects);
        foreach ($this->collector->allObjects() as $object) {
            $object->initialize();
        }
    }

    public function play(): void
    {
        $this->renderer->clearWindow();

        $visibleObjects = $this->collector->allVisibleObjects();
        $aliveObjects = $this->collector->allAliveObjects();

        foreach ($visibleObjects as $object) {
            $object->renderFirstFrame();
        }

        $maxFrames = $this->config->animationLengthInFrames();
        while (--$maxFrames) {
            $this->stabilizer->beginFrame();

            foreach ($aliveObjects as $object) {
                $object->update();
            }

            foreach ($visibleObjects as $object) {
                $object->renderLoopFrame();
            }

            $this->stabilizer->endFrame();

            if ($this->config->showFps()) {
                $this->console->printAt(0, 0, 'fps: ' . $this->stabilizer->fps() . '     ');
            }
        }
    }

    /**
     * @throws InvalidConsoleSizeException
     */
    protected function ensureConsoleValidSize(): void
    {
        $width = $this->console->width();
        $height = $this->console->height();

        $minWidth = $this->config->minRequiredConsoleWidth();
        $minHeight = $this->config->minRequiredConsoleHeight();

        if ($width < $minWidth || $height < $minHeight) {
            throw new InvalidConsoleSizeException("Console size must be at least ${minWidth}x${minHeight}!\n" .
                "Current console size is {$width}x{$height}.\n\nPlease make your terminal window larger!");
        }
    }
}