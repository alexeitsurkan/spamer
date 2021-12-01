<?php namespace app\components\api\vkontakte;

/**
 * Class VkontakteOauth
 * @package app\components\api\vkontakte
 */
class VkontakteOauth
{
    public function getUrl()
    {
        $url = 'https://oauth.vk.com/authorize?';

        $params = [
            'client_id' => env('VKONTAKTE_CLIENT_ID'),
            'redirect_uri' => 'http://127.0.0.1:81/vkontakte/index',
            'scope' => 'groups,offline,wall,photos',
            'display' => 'popup',
            'response_type' => 'token'
        ];

        return $url . http_build_query($params);
    }
}