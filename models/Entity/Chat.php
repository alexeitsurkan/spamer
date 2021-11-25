<?php namespace app\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class Chat
 * @package app\models\Entity
 */
class Chat extends ActiveRecord
{
    public static function tableName()
    {
        return 'chat';
    }
}