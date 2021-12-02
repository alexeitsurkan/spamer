<?php namespace app\commands;

use app\modules\anecdote\components\crons\AnecdotePostCronTask;
use app\modules\anecdote\components\crons\PlohiePesniPostCronTask;
use app\modules\citaty\components\crons\CitatyPostCronTask;
use yii\console\Controller;

/**
 * Class PostController
 * @package app\commands
 */
class PostController extends Controller
{

    public function actionAnecdote()
    {
        (new AnecdotePostCronTask())->run();
    }

    public function actionPlohiePesni()
    {
        (new PlohiePesniPostCronTask())->run();
    }


    public function actionCitaty()
    {
        (new CitatyPostCronTask())->run();
    }
}
