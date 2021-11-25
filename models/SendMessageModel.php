<?php namespace app\models;

use yii\base\Model;

/**
 * Class SendMessageModel
 * @package app\models
 */
class SendMessageModel extends Model
{
    public $message;

    public function rules()
    {
        return [
            ['message', 'string']
        ];
    }

    public function send()
    {
        return true;
    }
}