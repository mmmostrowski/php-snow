<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Wind;

use TechBit\Snow\SnowFallAnimation\Wind\Type\NoWind;
use TechBit\Snow\App\NamedClass;

final class WindFactory implements IWindFactory
{

    /**
     * @param class-string<IWind>[] $allWindForces
     */
    public function __construct(
        private readonly array $allWindForces,
        private readonly NamedClass $namedClass = new NamedClass("SnowFallAnimation\\Wind\\Type\\", ""),
    )
    {
    }

    /**
     * @param string[]|class-string<IWind>[] $limitToWindForces
     */
    public function create(bool $windEnabled, array $limitToWindForces): IWind
    {
        if (!$windEnabled) {
            return new NoWind();
        }

        if (!$limitToWindForces) {
            $limitToWindForces = $this->allWindForces;
        }

        $windObjects = [];
        foreach ($limitToWindForces as $classOrName) {
            $windObjects[] = $this->createWindObject($classOrName);
        }

        if (count($limitToWindForces) > 1) {
            return new WindComposition($windObjects);
        }
        return reset($windObjects);
    }

    /**
     * @param string|class-string<IWind> $classOrName
     */
    private function createWindObject(mixed $classOrName): IWind
    {
        $classname = $this->namedClass->toClassName($classOrName);
        return new $classname();
    }


}