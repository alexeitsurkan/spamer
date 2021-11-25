<?php namespace app\controllers;

use yii\web\Controller;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}