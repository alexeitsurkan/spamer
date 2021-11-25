<?php namespace app\models;

use app\components\telegram\TelegramService;
use app\models\Entity\Chat;
use yii\base\Model;

/**
 * Class SendMessageModel
 * @package app\models
 */
class SendMessageModel extends Model
{
    public $chat_id;
    public $text;

    public function rules()
    {
        return [
            ['text', 'string'],
            ['chat_id', 'integer']
        ];
    }

    public function send()
    {
        $chat = Chat::findOne($this->chat_id);
        (new TelegramService())->sendMessage($chat->sid,$this->text);
        return true;
    }
}