<?php namespace app\components\telegram\api;

use GuzzleHttp\Client;

/**
 * Class TelegramAPI
 * @package app\components\telegram\api
 */
class TelegramAPI
{
    protected const TEMP_URL = 'https://api.telegram.org/bot<token>/<method>';
    protected $token;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
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

        return $this->sendQuery('sendMessage', $params);
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
    }


}