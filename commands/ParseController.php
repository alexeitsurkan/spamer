<?php namespace app\commands;

use app\modules\anecdote\components\parsers\AnecdoteParse;
use app\modules\anecdote\components\parsers\PlohiePesniParse;
use app\modules\citaty\components\parsers\CitatyParse;
use yii\console\Controller;

/**
 * Class ParseController
 * @package app\commands
 */
class ParseController extends Controller
{
    public function actionPlohiePesni()
    {
        (new PlohiePesniParse())->execute();
    }

    public function actionAnecdote()
    {
        (new AnecdoteParse())->execute();
    }

    public function actionCitaty()
    {
        (new CitatyParse())->execute();
    }
}
