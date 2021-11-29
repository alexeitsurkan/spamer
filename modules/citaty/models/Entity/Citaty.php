<?php namespace app\modules\citaty\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class Citaty
 * @package app\modules\citaty\models\Entity
 * @property $id
 * @property $text
 * @property $info
 * @property $theme
 * @property $viewed
 */
class Citaty extends ActiveRecord
{
    public static function tableName()
    {
        return 'citaty';
    }
}