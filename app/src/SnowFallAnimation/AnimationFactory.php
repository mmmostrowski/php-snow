<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation;

use TechBit\Snow\SnowFallAnimation\Config\IPresetFactory;
use TechBit\Snow\SnowFallAnimation\Config\PresetFactory;
use TechBit\Snow\SnowFallAnimation\Frame\FramePainter;
use TechBit\Snow\SnowFallAnimation\Frame\FrameStabilizer;
use TechBit\Snow\SnowFallAnimation\Frame\IFramePainter;
use TechBit\Snow\SnowFallAnimation\Object\AnimationObjects;
use TechBit\Snow\SnowFallAnimation\Object\IAnimationObject;
use TechBit\Snow\SnowFallAnimation\Scene\ISceneFactory;
use TechBit\Snow\SnowFallAnimation\Scene\SceneFactory;
use TechBit\Snow\SnowFallAnimation\Snow\ISnowFlakeShape;
use TechBit\Snow\SnowFallAnimation\Snow\Snow;
use TechBit\Snow\SnowFallAnimation\Snow\SnowFall;
use TechBit\Snow\SnowFallAnimation\Snow\SnowBasis;
use TechBit\Snow\SnowFallAnimation\Snow\SnowFlakeShape;
use TechBit\Snow\SnowFallAnimation\Snow\SnowParticles;
use TechBit\Snow\SnowFallAnimation\Wind\IWindFactory;
use TechBit\Snow\SnowFallAnimation\Wind\WindFactory;
use TechBit\Snow\App\AppArguments;
use TechBit\Snow\App\IAnimation;
use TechBit\Snow\App\IAnimationFactory;
use TechBit\Snow\Console\Console;
use TechBit\Snow\Console\IConsole;
use TechBit\Snow\ObjectsPool;


final class AnimationFactory implements IAnimationFactory
{

    /**
     * @var IAnimationObject[]
     */
    private readonly array $animationObjects;

    private readonly IWindFactory $windFactory;

    private readonly IPresetFactory $presetFactory;


    public function __construct(
        private          readonly ISnowFlakeShape $flakeShapes = new SnowFlakeShape(),
        private          readonly ISceneFactory $sceneFactory = new SceneFactory(),
        private          readonly IFramePainter $renderer = new FramePainter(),
        private          readonly IAnimationObject $snowBasis = new SnowBasis(),
        private          readonly IConsole $console = new Console(),
        IAnimationObject $frameStabilizer = new FrameStabilizer(),
        ObjectsPool      $objectsPool = new ObjectsPool(),
        IAnimationObject $snowFall = new SnowFall(),
        IAnimationObject $snow = new Snow(),
        ?IPresetFactory  $presetFactory = null,
        ?IWindFactory    $windFactory = null,
    )
    {
        $this->windFactory = $windFactory ?? new WindFactory(
                $objectsPool->allWindForces());

        $this->presetFactory = $presetFactory ?? new PresetFactory(
                $objectsPool->allConfigPresets(),
                $objectsPool->defaultConfigPresets());

        $this->animationObjects = [
            $frameStabilizer, $renderer,
            $snowBasis, $snow, $snowFall,
        ];
    }

    public function create(AppArguments $arguments): IAnimation
    {
        $config = $this->presetFactory->create($arguments->presetName());

        $wind = $this->windFactory->create($config->hasWind(), $arguments->windForces());

        $scene = $this->sceneFactory->create($arguments->customScene());

        return new SnowFallAnimation(
            new AnimationContext(
                $this->console, $this->renderer,
                $wind,
                $this->flakeShapes,
                $config,
                $this->snowBasis,
                new SnowParticles(),
            ),
            new AnimationObjects([
                $wind,
                $scene,
                ...$this->animationObjects,
            ]),
        );
    }

}