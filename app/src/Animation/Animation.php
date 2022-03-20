<?php declare(strict_types=1);

namespace TechBit\Snow\Animation;

use Psr\Container\ContainerExceptionInterface;
use TechBit\Snow\Animation\Frame\FrameStabilizer;
use TechBit\Snow\Animation\Object\Collector;
use TechBit\Snow\Animation\Renderer\Renderer;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;


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
     */
    public function initialize(): void
    {
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

}