<?php namespace app\controllers;

use app\components\api\vkontakte\VkontakteOauth;
use yii\web\Controller;

/**
 * Class SiteController
 * @package app\controllers
 */
class VkontakteController extends Controller
{

    public function actionIndex()
    {
        $url = (new VkontakteOauth())->getUrl();
        return $this->render('index',[
            'url' => $url,
        ]);
    }
}