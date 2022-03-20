<?php declare(strict_types=1);

namespace TechBit\Snow\Animation\Scene;


class UserSceneProvider
{

    protected string $customScene = '';


    public function makeFromUserArgument(string $argument): bool
    {
        if ($argument === '') {
            return false;
        }

        if (str_starts_with($argument, 'base64:')) {
            $customSceneContent = (string)@base64_decode(preg_replace('/^base64:/', '', $argument));
        } else {
            $customSceneContent = (string)@file_get_contents($argument);
        }

        if ($customSceneContent === '') {
            return false;
        }

        $this->customScene = $customSceneContent;
        return true;
    }

    public function isAvailable(): bool
    {
        return $this->contentText() != '';
    }

    public function contentText(): string
    {
        if ($this->customScene != '') {
            return $this->customScene;
        }

        if (file_exists("/app/scene.txt")) {
            return file_get_contents("/app/scene.txt");
        }

        return '';
    }
}