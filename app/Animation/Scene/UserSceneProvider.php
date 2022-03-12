<?php

namespace TechBit\Snow\Animation\Scene;

class UserSceneProvider
{

    /**
     * @var string
     */
    protected $customScene = '';


    public function makeCustomScene($text)
    {
        $this->customScene = $text;
    }


    /**
     * @return bool
     */
    public function isAvailable()
    {
        return !empty($this->customScene) || trim($this->contentText()) != '';
    }

    /**
     * @return string
     */
    public function contentText()
    {
        if (!empty($this->customScene)) {
            return $this->customScene;
        }

        if (!file_exists("/app/scene.txt")) {
            return '';
        }
        return file_get_contents("/app/scene.txt", "rt");
    }
}