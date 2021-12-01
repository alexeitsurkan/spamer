<?php namespace app\components\soc\platforms;

use app\components\api\vkontakte\VkontakteAPI;

/**
 * Class VkontakteService
 * @package app\components\soc\platforms
 */
class VkontakteService implements ServiceInterface
{
    public function sendMessage(array $param, string $text): bool
    {
        $api = new VkontakteAPI(env('VKONTAKTE_TOKEN'));
        $result = $api->wallPost($param['vk']['group'], $text);
        return !empty($result);
    }

    public function sendPhoto(array $param, string $photo_path): bool
    {
        $api  = new VkontakteAPI(env('VKONTAKTE_TOKEN'));
        $data = $api->savePhoto($param['vk']['group'], $photo_path);
        $result = $api->wallPost($param['vk']['group'], '', $param['vk']['post_link'], $data);

        return !empty($result);
    }
}