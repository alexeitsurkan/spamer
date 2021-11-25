<?php namespace app\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class Client
 * @package app\models\Entity
 */
class Client extends ActiveRecord
{
    public static function tableName()
    {
        return 'client';
    }
}