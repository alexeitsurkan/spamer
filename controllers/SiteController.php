<?php namespace app\controllers;

use app\models\Entity\Chat;
use app\models\SendMessageModel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        $model = new SendMessageModel();
        $post = Yii::$app->request->post();
        if(Yii::$app->request->isPost && !empty($post)){
            $model->load($post);
            if($model->send()){
                return $this->redirect(['index']);
            }
        }
        $chat_list = ArrayHelper::map(Chat::find()->all(),'id','sid');

        return $this->render(
            'index',
            [
                'chat_list' => $chat_list,
                'model' => $model
            ]
        );
    }
}