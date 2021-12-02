<?php namespace app\modules\citaty\models\Entity;

use yii\db\ActiveRecord;

/**
 * Class CitatyTheme
 * @package app\modules\citaty\models\Entity
 */
class CitatyTheme extends ActiveRecord
{
    public static function tableName()
    {
        return 'citaty_theme';
    }
}