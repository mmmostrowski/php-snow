<?php

namespace TechBit\Snow\Animation\Scene;

class UserSceneProvider
{

    /**
     * @return bool
     */
    public function isAvailable()
    {
        return trim($this->contentText()) != '';
    }

    public function contentText()
    {
        return file_get_contents("/app/scene.txt", "rt");
    }
}