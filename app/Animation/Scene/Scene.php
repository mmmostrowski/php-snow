<?php namespace TechBit\Snow\Animation\Scene;

use TechBit\Snow\Animation\Object\IAnimationVisibleObject;
use TechBit\Snow\Animation\Snow\SnowBasis;
use TechBit\Snow\Config\Config;
use TechBit\Snow\Console\Console;


class Scene implements IAnimationVisibleObject
{

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

    public function __construct(Config $config, SnowBasis $basis, Console $console)
    {
        $this->config = $config;
        $this->basis = $basis;
        $this->console = $console;
    }

    public function initialize()
    {
    }

    public function renderFirstFrame()
    {
        $this->basis->drawGround();

        if ($this->config->showScene()) {
            $this->drawPHP();
            $this->drawIsAwesome();
            $this->drawCredentials();
        }
    }

    public function renderLoopFrame()
    {
    }

    protected function drawPHP()
    {
        $chars = <<<EOL
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


        $this->basis->drawCharsInCenter($chars, 0, -7, "light_blue");
    }

    protected function drawIsAwesome()
    {
        $chars = <<<EOL
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

        $this->basis->drawCharsInCenter($chars, 0, 10, "blue");
    }

    protected function drawCredentials()
    {
        $text = "( 2022 (C) Maciej Ostrowski )";

        $this->basis->drawChars($text,
            $this->console->maxX() - strlen($text) / 2,
            $this->console->maxY(),
            "blue"
        );
    }

}