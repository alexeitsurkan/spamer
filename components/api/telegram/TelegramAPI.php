<?php namespace app\components\api\telegram;

use GuzzleHttp\Client;

/**
 * Class TelegramAPI
 * @package app\components\api\telegram
 */
class TelegramAPI
{
    protected const TEMP_URL = 'https://api.telegram.org/bot<token>/<method>';
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @param $method
     * @param $params
     * @return mixed
     */
    protected function sendQuery($method, $params = [])
    {
        $url = str_replace(['<method>', '<token>'], [$method, $this->token], self::TEMP_URL);

        $client   = new Client();
        $response = $client->post($url, ['form_params' => $params]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getUpdates()
    {
        $response = $this->sendQuery('getUpdates');
        return $response['result'];
    }

    /**
     * @param $chat_id
     * @param $text
     * @return mixed
     */
    public function sendMessage($chat_id, $text)
    {
        $params = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];
        $response = $this->sendQuery('sendMessage', $params);

        return $response['ok'];
    }

    /**
     * @param $chat_id
     * @param $text
     * @return mixed
     */
    public function sendPhoto($chat_id, $photo_path)
    {

        $url = str_replace(['<method>', '<token>'], ['sendPhoto', $this->token], self::TEMP_URL);

        $client   = new Client();
        $response = $client->post(
            $url,
            [
                'multipart' => [
                    [
                        'name'     => 'chat_id',
                        'contents' => $chat_id
                    ],
                    [
                        'name'     => 'photo',
                        'contents' => fopen($photo_path, 'r')
                    ],
                ]
            ]
        );

        $response = json_decode($response->getBody()->getContents(), true);

        return $response['ok'];
    }
}