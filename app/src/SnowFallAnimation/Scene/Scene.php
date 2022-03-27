<?php declare(strict_types=1);

namespace TechBit\Snow\SnowFallAnimation\Scene;

use TechBit\Snow\SnowFallAnimation\AnimationContext;
use TechBit\Snow\SnowFallAnimation\Config\Config;
use TechBit\Snow\SnowFallAnimation\Object\IAnimationVisibleObject;
use TechBit\Snow\SnowFallAnimation\Snow\SnowBasis;
use TechBit\Snow\Console\ConsoleColor;
use TechBit\Snow\Console\IConsole;


final class Scene implements IAnimationVisibleObject
{

    private readonly string $credentialsText;

    private readonly IConsole $console;

    private readonly SnowBasis $basis;

    private readonly Config $config;


    public function __construct()
    {
        $this->credentialsText = "[ 2022 (C) Maciej Ostrowski | https://github.com/mmmostrowski ]";
    }

    public function initialize(AnimationContext $context): void
    {
        $this->console = $context->console();
        $this->basis = $context->snowBasis();
        $this->config = $context->config();
    }

    public function renderFirstFrame(): void
    {
        if (!$this->config->showScene()) {
            return;
        }

        $this->basis->drawGround();

        $this->basis->drawCharsInCenter($this->drawPHP(),
            0,
            -7,
            ConsoleColor::LIGHT_BLUE);

        $this->basis->drawCharsInCenter($this->drawIsAwesome(),
            0,
            10,
            ConsoleColor::BLUE
        );

        $this->basis->drawChars($this->credentialsText,
            (int)($this->console->maxX() - strlen($this->credentialsText) / 2),
            (int)($this->console->maxY()),
            ConsoleColor::BLUE
        );
    }

    private function drawPHP(): string
    {
        return <<<EOL
PPPPPPPPPPPPPPPPP        HHHHHHHHH     HHHHHHHHH     PPPPPPPPPPPPPPPPP   
P::::::::::::::::P       H:::::::H     H:::::::H     P::::::::::::::::P  
P::::::PPPPPP:::::P      H:::::::H     H:::::::H     P::::::PPPPPP:::::P 
PP:::::P     P:::::P     HH::::::H     H::::::HH     PP:::::P     P:::::P
  P::::P     P:::::P       H:::::H     H:::::H         P::::P     P:::::P
  P::::P     P:::::P       H:::::H     H:::::H         P::::P     P:::::P
  P::::PPPPPP:::::P        H::::::HHHHH::::::H         P::::PPPPPP:::::P 
  P:::::::::::::PP         H:::::::::::::::::H         P:::::::::::::PP  
  P::::PPPPPPPPP           H:::::::::::::::::H         P::::PPPPPPPPP    
  P::::P                   H::::::HHHHH::::::H         P::::P            
  P::::P                   H:::::H     H:::::H         P::::P            
  P::::P                   H:::::H     H:::::H         P::::P            
PP::::::PP               HH::::::H     H::::::HH     PP::::::PP          
P::::::::P               H:::::::H     H:::::::H     P::::::::P          
P::::::::P               H:::::::H     H:::::::H     P::::::::P          
PPPPPPPPPP               HHHHHHHHH     HHHHHHHHH     PPPPPPPPPP
EOL;
    }

    private function drawIsAwesome(): string
    {
        return <<<EOL
                          _                                                                            
68b                      dM.                                                                           
Y89                     ,MMb                                                                           
___   ____              d'YM.    ____    _    ___   ____     ____     _____   ___  __    __     ____   
`MM  6MMMMb\           ,P `Mb    `MM(   ,M.   )M'  6MMMMb   6MMMMb\  6MMMMMb  `MM 6MMb  6MMb   6MMMMb  
 MM MM'    `           d'  YM.    `Mb   dMb   d'  6M'  `Mb MM'    ` 6M'   `Mb  MM69 `MM69 `Mb 6M'  `Mb 
 MM YM.               ,P   `Mb     YM. ,PYM. ,P   MM    MM YM.      MM     MM  MM'   MM'   MM MM    MM 
 MM  YMMMMb           d'    YM.    `Mb d'`Mb d'   MMMMMMMM  YMMMMb  MM     MM  MM    MM    MM MMMMMMMM 
 MM      `Mb         ,MMMMMMMMb     YM,P  YM,P    MM            `Mb MM     MM  MM    MM    MM MM       
 MM L    ,MM         d'      YM.    `MM'  `MM'    YM    d9 L    ,MM YM.   ,M9  MM    MM    MM YM    d9
_MM_MYMMMM9        _dM_     _dMM_    YP    YP      YMMMM9  MYMMMM9   YMMMMM9  _MM_  _MM_  _MM_ YMMMM9
EOL;
    }

    public function renderLoopFrame(): void
    {
    }

}