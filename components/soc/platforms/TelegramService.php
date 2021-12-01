<?php namespace app\components\soc\platforms;

use app\components\api\telegram\TelegramAPI;

/**
 * Class TelegramService
 * @package app\components\soc\platforms
 */
class TelegramService implements ServiceInterface
{
    public function sendMessage(array $param, string $text): bool
    {
        $api = new TelegramAPI(env('TELEGRAM_BOT_TOKEN'));
        return $api->sendMessage($param['tg']['chat_id'], $text);
    }

    public function sendPhoto(array $param, string $photo_path): bool
    {
        $api = new TelegramAPI(env('TELEGRAM_BOT_TOKEN'));
        return $api->sendPhoto($param['tg']['chat_id'], $photo_path);
    }
}