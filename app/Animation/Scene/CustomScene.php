<?php namespace TechBit\Snow\Animation\Scene;

use TechBit\Snow\Animation\Object\IAnimationVisibleObject;
use TechBit\Snow\Animation\Snow\SnowBasis;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;


class CustomScene implements IAnimationVisibleObject
{
    /**
     * @var UserSceneProvider
     */
    protected $userCustomScene;

    /**
     * @var Config
     */
    protected $config;
    /**
     * @var SnowBasis
     */
    protected $basis;
    /**
     * @var Console
     */
    protected $console;

    public function __construct(Config $config, SnowBasis $basis, Console $console, UserSceneProvider $userSceneProvider)
    {
        $this->config = $config;
        $this->basis = $basis;
        $this->console = $console;
        $this->userCustomScene = $userSceneProvider;
    }

    public function initialize()
    {
    }

    public function renderFirstFrame()
    {
        if (!$this->config->showScene()) {
            return;
        }

        $chars = $this->userCustomScene->contentText();

        $this->basis->drawChars($chars,
            $this->console->centerX(),
            $this->console->centerY() - 7,
            "light_blue"
        );

    }

    public function renderLoopFrame()
    {
    }

}