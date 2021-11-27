<?php namespace app\commands;

use app\modules\anecdote\components\crons\AnecdotePostCronTask;
use app\modules\anecdote\components\crons\PlohiePesniPostCronTask;
use app\modules\anecdote\components\parsers\AnecdoteParse;
use app\modules\anecdote\components\parsers\PlohiePesniParse;
use yii\console\Controller;

/**
 * Class DefaultController
 * @package app\commands
 */
class SyncController extends Controller
{
    public function actionParse()
    {
        (new PlohiePesniParse())->execute();
        (new AnecdoteParse())->execute();
    }

    public function actionPostAnecdote()
    {
        (new AnecdotePostCronTask())->run();
    }

    public function actionPostPlohiePesni()
    {
        (new PlohiePesniPostCronTask())->run();
    }
}
