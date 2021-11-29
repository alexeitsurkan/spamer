<?php namespace app\commands;

use app\modules\anecdote\components\crons\AnecdotePostCronTask;
use app\modules\anecdote\components\crons\PlohiePesniPostCronTask;
use app\modules\citaty\components\crons\CitatyPostCronTask;
use app\modules\citaty\components\parsers\CitatyParse;
use yii\console\Controller;

/**
 * Class DefaultController
 * @package app\commands
 */
class SyncController extends Controller
{
//    public function actionUpdate()
//    {
//        (new TelegramAPI())->getUpdates();
//    }

    public function actionParse()
    {
//        (new PlohiePesniParse())->execute();
//        (new AnecdoteParse())->execute();
        (new CitatyParse())->execute();
    }

    public function actionPostAnecdote()
    {
        (new AnecdotePostCronTask())->run();
    }

    public function actionPostPlohiePesni()
    {
        (new PlohiePesniPostCronTask())->run();
    }


    public function actionPostCitaty()
    {
        (new CitatyPostCronTask())->run();
    }
}
