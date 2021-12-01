<?php namespace app\components\soc\platforms;

/**
 * Interface ServiceInterface
 * @package app\components\soc\platforms
 */
interface ServiceInterface
{
    public function sendMessage(array $param, string $text): bool;

    public function sendPhoto(array $param, string $photo_path): bool;
}