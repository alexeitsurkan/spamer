<?php namespace app\modules\anecdote\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class PlohiePesni
 * @package app\modules\anecdote\models\Entity
 * @property $id
 * @property $text
 * @property $viewed
 */
class PlohiePesni extends ActiveRecord
{
    public static function tableName()
    {
        return 'plohie_pesni';
    }
}