<?php namespace app\commands;

use app\components\telegram\TelegramService;
use app\models\ChatModel;
use app\models\ClientModel;
use app\models\MessageModel;
use yii\console\Controller;

/**
 * Class DefaultController
 * @package app\commands
 */
class SyncController extends Controller
{
    public function actionTelegram()
    {
        $result = (new TelegramService())->getUpdates();
        foreach ($result as $item) {
            $client             = ClientModel::findOne(['sid' => $item['message']['from']['id']]) ?? new ClientModel();
            $client->sid        = $item['message']['from']['id'];
            $client->first_name = $item['message']['from']['first_name'];
            $client->last_name  = $item['message']['from']['last_name'] ?? null;
            $client->username   = $item['message']['from']['username'] ?? null;
            $client->language   = $item['message']['from']['language_code'] ?? null;
            $client->save();

            $chat        = ChatModel::findOne(['sid' => $item['message']['chat']['id']]) ?? new ChatModel();
            $chat->sid   = $item['message']['chat']['id'];
            $chat->title = $item['message']['chat']['title'] ?? null;
            $chat->type  = $item['message']['chat']['type'];
            $chat->save();

            $message              = MessageModel::findOne(['message_sid' => $item['message']['message_id']]) ?? new MessageModel();
            $message->chat_id     = $chat->id;
            $message->client_id   = $client->id;
            $message->message_sid = $item['message']['message_id'];
            $message->text        = $item['message']['text'];
            $message->date        = $item['message']['date'];
            $message->save();
        }
    }
}
