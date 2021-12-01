<?php namespace app\components\soc;

use app\components\soc\platforms\TelegramService;
use app\components\soc\platforms\VkontakteService;
use yii\base\Component;

/**
 * Class SocService
 * @package app\components
 */
class SocService extends Component
{
    private $param;

    public static $platform = [
//        TelegramService::class,
        VkontakteService::class,
    ];

    public function for($param_name)
    {
        $this->param = \Yii::$app->params[$param_name];

        return $this;
    }

    /**
     * @param string $text
     * @return bool
     */
    public function sendMessage(string $text): bool
    {
        foreach (self::$platform as $platform) {
            /** @var VkontakteService|TelegramService $service */
            $service = new $platform();
            $service->sendMessage($this->param, $text);
        }
    }

    /**
     * @param string $photo_path
     * @return bool
     */
    public function sendPhoto(string $photo_path): bool
    {
        foreach (self::$platform as $platform) {
            /** @var VkontakteService|TelegramService $service */
            $service = new $platform();
            $service->sendPhoto($this->param, $photo_path);
        }
    }

}