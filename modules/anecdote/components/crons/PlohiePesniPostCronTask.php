<?php namespace app\modules\anecdote\components\crons;

use app\commands\modules\cron_manager\models\AbstractTask;
use app\components\ImageConstructor;
use app\modules\anecdote\models\Entity\PlohiePesni;
use Yii;

/**
 * Class PlohiePesniPostCronTask
 * @package app\modules\anecdote\components\crons
 */
class PlohiePesniPostCronTask extends AbstractTask
{
    //таймер
    public function getSchedulerTime(): string
    {
        return "*/175 6-23 * * *";
    }

    public function execute(): void
    {
        try{
            $text = $this->getText();
            if (mb_strlen($text) > 240) {
                Yii::$app->soc->for('anecdote')->sendMessage($text);
            } else {
                $path = (new ImageConstructor())
                    ->setTitle('«Плохие песни»')
                    ->setText($text)
                    ->setWatermark('СмеXлыст@smehlist')
                    ->setBackgroundImage($this->getImagePath())
                    ->create()
                ;
                Yii::$app->soc->for('anecdote')->sendPhoto($path);
            }
        }catch (\Exception $e){
            Yii::error($e->getMessage(),__METHOD__);
        }
    }

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    private function getText():string
    {
        $model = PlohiePesni::find()
            ->where(
                [
                    'viewed' => false,
                ]
            )
            ->one()
        ;
        if (empty($model)) {
            $sql = 'UPDATE plohie_pesni SET viewed=false;';
            \Yii::$app->db->createCommand($sql)->execute();
            $model = PlohiePesni::find()->one();
        }
        $model->viewed = true;
        $model->save();

        return $this->textFormater($model->text);
    }

    /**
     * рабзивает текст на строки
     * @param string $str
     * @return string
     */
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
    private function getImagePath():string
    {
        $images_folder = Yii::getAlias('@app/modules/anecdote/web/images');
        $images = scandir($images_folder);

        return $images_folder.'/' . $images[rand(2, count($images) - 1)];
    }
}
