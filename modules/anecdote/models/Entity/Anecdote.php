<?php namespace app\modules\anecdote\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class Anecdote
 * @package app\modules\anecdote\models\Entity
 * @property $id
 * @property $text
 * @property $viewed
 */
class Anecdote extends ActiveRecord
{
    public static function tableName()
    {
        return 'anecdote';
    }
}