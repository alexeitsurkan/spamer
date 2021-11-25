<?php namespace app\components\telegram;

use GuzzleHttp\Client;
use yii\base\Component;

/**
 * Class TelegramService
 * @package app\components\telegram
 */
class TelegramService extends Component
{
    protected const TEMP_URL = 'https://api.telegram.org/bot<token>/<method>';

    protected $token;

    public function init()
    {
        parent::init();
        $this->token = env('TELEGRAM_TOKEN');
    }

    /**
     * @param $method
     * @param $params
     * @return mixed
     */
    protected function sendQuery($method, $params = [])
    {
        $url    = str_replace(['<method>', '<token>'], [$method, $this->token], self::TEMP_URL);

        $client = new Client();
        $response = $client->post($url, ['form_params' => $params]);

        return json_decode($response->getBody()->getContents(),true);
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


}