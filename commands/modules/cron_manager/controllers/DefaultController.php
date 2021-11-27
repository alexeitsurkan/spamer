<?php namespace app\commands\modules\cron_manager\controllers;

use app\commands\modules\cron_manager\helpers\CronHelper;
use Crontask\TaskList;
use Yii;
use yii\console\Controller;

/**
 * Class DefaultController
 * @package app\commands\cron_manager\controllers
 */
class DefaultController extends Controller
{
    public function actionRun()
    {
        try{
            $taskList = new TaskList();
            $taskList->addTasks(CronHelper::getCronTaskObj());
            $taskList->run();
        }catch (\Exception $e){
            Yii::error($e->getMessage().': '.$e->getTraceAsString(),'cron_manager');
        }catch (\Throwable $e){
            Yii::error($e->getMessage().': '.$e->getTraceAsString(),'cron_manager');
        }
    }
}