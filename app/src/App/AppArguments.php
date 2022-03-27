<?php declare(strict_types=1);

namespace TechBit\Snow\App;

use TechBit\Snow\SnowFallAnimation\Wind\IWind;

final class AppArguments
{

    /**
     * @param string[]|class-string<IWind>[] $windForces
     */
    public function __construct(
        private readonly bool $isDeveloperMode,
        private readonly array $windForces,
        private readonly string $presetName,
        private readonly ?string $customScene,

    )
    {
    }

    public function isDeveloperMode(): bool
    {
        return $this->isDeveloperMode;
    }

    /**
     * @return string[]|class-string<IWind>[]
     */
    public function windForces(): array
    {
        return $this->windForces;
    }

    public function presetName(): string
    {
        return $this->presetName;
    }

    public function customScene(): ?string
    {
        return $this->customScene;
    }

}