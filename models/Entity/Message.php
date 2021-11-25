<?php namespace app\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class Message
 * @package app\models\Entity
 */
class Message extends ActiveRecord
{
    public static function tableName()
    {
        return 'message';
    }
}