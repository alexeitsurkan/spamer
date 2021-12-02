<?php namespace app\components;

use Yii;

/**
 * Class ImageConstructor
 * @package app\components
 */
class ImageConstructor
{
    private $text;
    private $text_color;

    private $title;
    private $title_color;

    private $watermark;
    private $watermark_color;

    private $font;
    private $background_image_path;

    public function __construct()
    {
        $this->title       = '';
        $this->title_color = '';

        $this->text       = '';
        $this->text_color = '';

        $this->watermark       = '';
        $this->watermark_color = '';

        $this->font                  = Yii::getAlias('@app/web/fonts/AlegreyaSC-Bold.ttf');
        $this->background_image_path = Yii::getAlias('@app/web/images/default.jpg');
    }

    public function setTitle($name, $color = null)
    {
        $this->title       = $name;
        $this->title_color = $color;
        return $this;
    }

    public function setText($name, $color = null)
    {
        $this->text       = $name;
        $this->text_color = $color;
        return $this;
    }

    public function setWatermark($name, $color = null)
    {
        $this->watermark       = $name;
        $this->watermark_color = $color;
        return $this;
    }

    public function setFont($path)
    {
        $this->font = Yii::getAlias($path);
        return $this;
    }

    public function setBackgroundImage($path)
    {
        $this->background_image_path = Yii::getAlias($path);
        return $this;
    }

    public function create()
    {
        //удаляем предыдущие фото
        array_map('unlink', glob(Yii::getAlias("@app/runtime/photo_post/*")));

        $row_count = substr_count($this->text, "\n");

        $im_width  = 700;
        $im_height = round(500 + $row_count * (500 / 100 * 7));

        if (preg_match('/^.*(.png)$/', $this->background_image_path)) {
            $im0 = imagecreatefrompng($this->background_image_path);
        } else {
            $im0 = imagecreatefromjpeg($this->background_image_path);
        }
        $im = imagecrop($im0, ['x' => 0, 'y' => 0, 'width' => $im_width, 'height' => $im_height]);

        $size = 28;
        $x    = round($im_width * 0.15 - $row_count * ($im_width * 0.15 / 100 * 2.7));
        $y    = round($im_height * 0.4 - $row_count * ($im_height * 0.4 / 100 * 7));

        // Рисуем текст
        $color = $this->colorAllocate($im, $this->text_color);
        imagefttext($im, $size, 0, $x, $y, $color, $this->font, $this->text);

        if ($this->title) {
            $color = $this->colorAllocate($im, $this->title_color);
            imagefttext($im, 28, 0, $x * 2.2, 40, $color, $this->font, $this->title);
        }
        if ($this->watermark) {
            $color = $this->colorAllocate($im, $this->watermark_color);
            imagefttext($im, 22, 0, $x / 3, $im_height - 20, $color, $this->font, $this->watermark);
        }

        if (!is_dir(Yii::getAlias('@app/runtime/photo_post'))) {
            mkdir(Yii::getAlias('@app/runtime/photo_post'), 0700);
        }
        $path = Yii::getAlias('@app/runtime/photo_post/' . time() . '.png');

        imagepng($im, $path);
        imagedestroy($im);

        return $path;
    }

    /**
     * @param $im
     * @param string $color
     * @return false|int
     */
    private function colorAllocate($im, $color)
    {
        $color = $color ?? '#ffffff';
        $rgb = sscanf($color, "#%02x%02x%02x");

        return imagecolorallocate($im, $rgb[0], $rgb[1], $rgb[2]);
    }
}