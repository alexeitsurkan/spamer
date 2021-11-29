<?php namespace app\modules\citaty\components\crons;

use app\commands\modules\cron_manager\models\AbstractTask;
use app\components\telegram\api\TelegramAPI;
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
        return "*/204 6-23 * * *";
    }

    //отправка поста
    public function execute(): void
    {
        $model = $this->getModel();
        if (mb_strlen($model->text) > 240) {
            $text = $this->textFormater($model->text)."\n\n".$model->info;
            (new TelegramAPI())->sendMessage(env('TELEGRAM_CITATI_CHAT'), $text);
        } else {
            $photo = $this->gePhoto($model);
            (new TelegramAPI())->sendPhoto(env('TELEGRAM_CITATI_CHAT'), $photo);
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

    private function gePhoto($model)
    {
        $text = $this->textFormater($model->text);

        array_map('unlink', glob(Yii::getAlias("@app/runtime/photo_post/*")));

        $row_count = substr_count($text, "\n");

        $im_width  = 700;
        $im_height = round(500 + $row_count * (500 / 100 * 7));

        $images_folder = Yii::getAlias('@app/modules/citaty/web/images');
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
        imagefttext($im, 28, 0, $x*1.3, 40, $orange, $font_file, 'Цитаты@smartchevskii');
        imagefttext($im, $size, 0, $x, $y, $white, $font_file, $text);
        imagefttext($im, 22, 0, $x / 3, $im_height - 55, $blue, $font_file, $this->textFormater($model->info));

        if (!is_dir(Yii::getAlias('@app/runtime/photo_post'))) {
            mkdir(Yii::getAlias('@app/runtime/photo_post'), 0700);
        }
        $path = Yii::getAlias('@app/runtime/photo_post/' . time() . '.png');

        imagepng($im, $path);
        imagedestroy($im);

        return $path;
    }
}
