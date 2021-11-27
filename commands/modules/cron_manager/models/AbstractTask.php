<?php namespace app\commands\modules\cron_manager\models;

/**
 * Class AbstractTask
 * @package app\commands\modules\cron_manager\models
 */
abstract class AbstractTask extends \Crontask\Tasks\Task
{
    public function __construct()
    {
        $this->setExpression($this->getSchedulerTime());
    }

    /**
     * строка с временем планировщика
     * @return string
     */
    abstract public function getSchedulerTime():string;

    abstract public function execute():void;

    public function run()
    {
        try{
            $this->execute();
        }catch (\Exception $e){
            \Yii::error($e->getMessage().' : '.$e->getTraceAsString(),'cron_task');
        }
    }
}