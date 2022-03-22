<?php declare(strict_types=1);

namespace TechBit\Snow\Animation;

use TechBit\Snow\Animation\Frame\FrameStabilizer;
use TechBit\Snow\Animation\Scene\Scene;
use TechBit\Snow\Animation\Snow\SnowAnimator;
use TechBit\Snow\Animation\Snow\SnowBasis;
use TechBit\Snow\Animation\Snow\SnowGenerator;
use TechBit\Snow\Animation\Snow\SnowProducer;
use TechBit\Snow\Animation\Wind\BlowWind;
use TechBit\Snow\Animation\Wind\FieldWind;
use TechBit\Snow\Animation\Wind\MicroWavingWind;
use TechBit\Snow\Animation\Wind\StaticWind;
use TechBit\Snow\Animation\Wind\WindComposition;


class AnimationObjectsList
{

    public function allElements(): array
    {
        return [
            FrameStabilizer::class,
            Scene::class,
            WindComposition::class,
            FieldWind::class,
            StaticWind::class,
            BlowWind::class,
            MicroWavingWind::class,
            SnowBasis::class,
            SnowAnimator::class,
            SnowGenerator::class,
            SnowProducer::class,
        ];
    }

}