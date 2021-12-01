<?php namespace app\modules\anecdote\components\crons;

use app\commands\modules\cron_manager\models\AbstractTask;
use app\components\api\telegram\TelegramAPI;
use app\modules\anecdote\models\Entity\PlohiePesni;
use Yii;

/**
 * Class AnecdoteParseCronTask
 * @package app\components\crons
 */
class PlohiePesniPostCronTask extends AbstractTask
{
    //таймер
    public function getSchedulerTime(): string
    {
        return "*/175 6-23 * * *";
    }

    //отправка поста
    public function execute(): void
    {
        $text = $this->getText();
        if (mb_strlen($text) > 240) {
            (new TelegramAPI())->sendMessage(env('TELEGRAM_ANECDOTE_CHAT'), $text);
        } else {
            $photo = $this->gePhoto($text);
            (new TelegramAPI())->sendPhoto(env('TELEGRAM_ANECDOTE_CHAT'), $photo);
        }
    }


    private function gePhoto($text)
    {
        array_map('unlink', glob(Yii::getAlias("@app/runtime/photo_post/*")));

        $row_count = substr_count($text, "\n");

        $im_width  = 700;
        $im_height = round(500 + $row_count * (500 / 100 * 7));

        $images_folder = Yii::getAlias('@app/modules/anecdote/web/images');
        $images = scandir($images_folder);

        $im_path = Yii::getAlias($images_folder.'/' . $images[rand(2, count($images) - 1)]);
        if (preg_match('/^.*(.png)$/', $im_path)) {
            $im0 = imagecreatefrompng($im_path);
        } else {
            $im0 = imagecreatefromjpeg($im_path);
        }
        $im = imagecrop($im0, ['x' => 0, 'y' => 0, 'width' => $im_width, 'height' => $im_height]);

        $white  = imagecolorallocate($im, 255, 255, 255);
        $blue   = imagecolorallocate($im, 75, 215, 195);
        $orange = imagecolorallocate($im, 255, 140, 0);

        // Путь к ttf файлу шрифта
        $font_file = Yii::getAlias('@app/web/fonts/AlegreyaSC-Bold.ttf');


        $size = 28;
        $x    = round($im_width * 0.15 - $row_count * ($im_width * 0.15 / 100 * 2.7));
        $y    = round($im_height * 0.4 - $row_count * ($im_height * 0.4 / 100 * 7));

        // Рисуем текст
        imagefttext($im, 28, 0, $x * 2.2, 40, $orange, $font_file, '"Плохие песни"');
        imagefttext($im, $size, 0, $x, $y, $white, $font_file, $text);
        imagefttext($im, 22, 0, $x / 3, $im_height - 20, $blue, $font_file, 'СмеXлыст@smehlist');

        if (!is_dir(Yii::getAlias('@app/runtime/photo_post'))) {
            mkdir(Yii::getAlias('@app/runtime/photo_post'), 0700);
        }
        $path = Yii::getAlias('@app/runtime/photo_post/' . time() . '.png');

        imagepng($im, $path);
        imagedestroy($im);

        return $path;
    }

    private function getText()
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
}
