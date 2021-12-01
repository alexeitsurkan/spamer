<?php namespace app\components\api\vkontakte;

use GuzzleHttp\Client;

/**
 * Class VkontakteAPI
 * @package app\components\vkontakte\api
 */
class VkontakteAPI
{
    public const VERSION  = '5.131';
    public const TEMP_URL = 'https://api.vk.com/method/<METHOD>';

    private $token;

    /**
     * VkontakteAPI constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @param $method
     * @param array $params
     * @return array
     * @throws \Exception
     */
    private function sendQuery($method, $params = []): array
    {
        $url                    = str_replace(['<METHOD>'], [$method], self::TEMP_URL);
        $params['access_token'] = $this->token;
        $params['v']            = '5.131';

        $json = file_get_contents($url . '?' . http_build_query($params));

        $client   = new Client();
        $response = $client->post($url, ['form_params' => $params]);
        $content  = json_decode($response->getBody()->getContents(), true);

        if ($content['error']) {
            throw new \Exception($content['error']['error_msg'], $content['error']['error_code']);
        }
        return $content['response'];
    }

    public function wallPost($group_id, $text = '', array $photo = []): array
    {
        $temp_attachmet = '<type><owner_id>_<media_id>';
        $params         = [
            'owner_id'    => '-' . $group_id,
            'from_group'  => '1',
            'message'     => $text,
            'attachments' => []
        ];

        //добавляем фото к посту
        if ($photo) {
            $params['attachments'][] = str_replace(
                ['<type>', '<owner_id>', '<media_id>'],
                ['photo', $photo['owner_id'], $photo['id']],
                $temp_attachmet
            );
        }


        $params['attachments'] = implode(',', $params['attachments']);

        return $this->sendQuery('wall.post', $params);
    }

    /**
     * @param $group_id
     * @param $photo_path
     * @return array
     * @throws \Exception
     */
    public function savePhoto($group_id, $photo_path): array
    {
        //получем сервер загрузки
        $params = [
            'group_id' => $group_id,
        ];
        $server = $this->sendQuery('photos.getWallUploadServer', $params);

        //загружаем на сервер
        $client   = new Client();
        $response = $client->post(
            $server['upload_url'],
            [
                'multipart' => [
                    [
                        'name'     => 'photo',
                        'contents' => fopen($photo_path, 'r')
                    ],
                ]
            ]
        );
        $data     = json_decode($response->getBody()->getContents(), true);

        //сохраняем в альбом
        $params = [
            'group_id' => $group_id,
            'server'   => $data['server'],
            'photo'    => $data['photo'],
            'hash'     => $data['hash'],
        ];
        $result = $this->sendQuery('photos.saveWallPhoto', $params);

        return $result[0];
    }
}