<?php namespace TechBit\Snow\Animation;

use TechBit\Snow\Animation\Frame\FrameStabilizer;
use TechBit\Snow\Animation\Object\Collector;
use TechBit\Snow\Animation\Renderer\Renderer;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;


class Animation
{

    /**
     * @var Console
     */
    protected $console;
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var FrameStabilizer
     */
    protected $stabilizer;
    /**
     * @var Collector
     */
    protected $collector;
    /**
     * @var AnimationObjectsList
     */
    protected $animationObjects;
    /**
     * @var Renderer
     */
    protected $renderer;

    public function __construct(
        Console   $console, Config $config, FrameStabilizer $stabilizer,
        Collector $collector, AnimationObjectsList $animationObjects,
        Renderer  $renderer
    )
    {
        $this->console = $console;
        $this->config = $config;
        $this->stabilizer = $stabilizer;
        $this->collector = $collector;
        $this->animationObjects = $animationObjects;
        $this->renderer = $renderer;
    }

    public function initialize()
    {
        $this->collector->collect($this->animationObjects);
        foreach ($this->collector->allObjects() as $object) {
            $object->initialize();
        }
    }

    public function play()
    {
        $this->renderer->clearWholeWindow();

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