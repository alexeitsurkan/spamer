<?php namespace app\modules\citaty\components\crons;

use app\commands\modules\cron_manager\models\AbstractTask;
use app\components\ImageConstructor;
use app\modules\citaty\models\Entity\Citaty;
use Yii;

/**
 * Class CitatyPostCronTask
 * @package app\modules\citaty\components\crons
 */
class CitatyPostCronTask extends AbstractTask
{
    //таймер
    public function getSchedulerTime(): string
    {
        return "*/100 6-23 * * *";
    }

    //отправка поста
    public function execute(): void
    {
        try {
            $model = $this->getModel();
            if (mb_strlen($model->text) > 240) {
                $text = $this->textFormater($model->text) . "\n\n" . $model->info;
                Yii::$app->soc->for('citaty')->sendMessage($text);
            } else {
                $text = $this->textFormater($model->text);
                $watermark = $this->textFormater($model->info);

                $path = (new ImageConstructor())
                    ->setTitle('')
                    ->setText($text)
                    ->setWatermark($watermark)
                    ->setBackgroundImage($this->getImagePath($model->theme_id))
                    ->create()
                ;
                Yii::$app->soc->for('citaty')->sendPhoto($path);
            }
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
        }
    }

    private function getModel()
    {
        $model = Citaty::find()
            ->where(
                [
                    'viewed' => false,
                ]
            )
            ->one()
        ;
        if (empty($model)) {
            $sql = 'UPDATE citaty SET viewed=false;';
            \Yii::$app->db->createCommand($sql)->execute();
            $model = Citaty::find()->one();
        }
        $model->viewed = true;
        $model->save();

        return $model;
    }

    private function textFormater(string $str): string
    {
        $str_length = 30;

        $text = '';
        while (mb_strlen($str) >= $str_length) {
            $s_pos = mb_strripos(mb_substr($str, 0, $str_length), ' ');
            $text  .= trim(mb_substr($str, 0, $s_pos)) . "\n";
            $str   = mb_substr($str, $s_pos);
        }
        $text .= $str . "\n";
        $text = trim($text);

        return $text;
    }

    /**
     * @return string
     */
    private function getImagePath($theme_id): string
    {
        $images_folder = Yii::getAlias('@app/modules/citaty/web/images');
        $items        = scandir($images_folder);
        foreach ($items as $item){
            if(is_dir($images_folder . '/' . $item) && preg_match("/_{$theme_id}_/",$item)){
                $images = scandir($images_folder . '/' . $item);
                return $images_folder . '/'. $item . '/' . $images[rand(2, count($images) - 1)];
            }
        }

        $images = scandir($images_folder . '/default/');
        return $images_folder . '/default/' . $images[rand(2, count($images) - 1)];
    }
}
