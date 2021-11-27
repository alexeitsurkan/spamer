<?php namespace app\commands\modules\cron_manager\helpers;

use Yii;

class CronHelper
{
    public static function getCronTaskObj()
    {
        return Yii::$app->cache->getOrSet('cron_manager', function () {
            $data = self::iterateCronTask('@app');
            return $data;
        });
    }

    protected static function iterateCronTask($dir)
    {
        $data = [];
        $path = 'crons';
        $scan_data = scandir(Yii::getAlias($dir));
        if (!empty($scan_data)) {
            foreach ($scan_data as $key => $name) {
                if ($key < 2) continue;
                if ($name == 'modules') {
                    $scan_modules = scandir(Yii::getAlias($dir . DIRECTORY_SEPARATOR . $name));
                    if (!empty($scan_modules)) {
                        foreach ($scan_modules as $m_key => $m_name) {
                            if ($m_key < 2) continue;
                            $module_path = $dir . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $m_name;
                            if (is_dir(Yii::getAlias($module_path))) {
                                $data = array_merge($data, self::iterateCronTask($module_path));
                            }
                        }
                    }
                }
                if ($name == 'components') {
                    $cron_path = $dir . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $path;
                    if (is_dir(Yii::getAlias($cron_path))) {
                        $cron_data = scandir(Yii::getAlias($cron_path));
                        foreach ($cron_data as $c_key => $c_class) {
                            if ($c_key < 2) continue;
                            if (strrpos($c_class, 'CronTask.php')) {
                                $c_class = preg_replace('/\.php/', '', $c_class);
                                $className = str_replace('/', '\\', $cron_path . DIRECTORY_SEPARATOR . $c_class);
                                $className = substr_replace($className, '', 0, 1);
                                $data[] = (new $className);
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }
}