<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var $model
 * @var $action
 */
?>

<header id="gtco-header" class="gtco-cover" role="banner" style="height: 300px">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="text-center">
                <div class="display-t" style="height: 350px">
                    <div class="display-tc animate-box" data-animate-effect="fadeInUp" style="height: 350px">
                        <h1 class="mb30"><a href="#"><?= $this->title ?></a></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div id="gtco-maine">
    <div class="container">
        <div class="row row-pb-md">
            <div class="col-md-12">
                <article class="mt-negative container">
                    <?php $form = ActiveForm::begin([
                        'enableClientScript' => false,
                        'action' => Url::toRoute(['news/' . $action]),
                        'options' => [
                            'enctype' => 'multipart/form-data'
                        ]
                    ]) ?>
                    <?= Html::activeHiddenInput($model, 'id') ?>
                    <div class="row">

                        <div class="col-sm-12 form-group">
                            <label class="col-sm-12 text-left">выберите основное изображение:</label>
                            <div class="col-sm-12">
                                <?= HTML::activeFileInput($model, 'files', [
                                    'id' => 'input_add_file',
                                ]) ?>
                            </div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label class="col-sm-12 text-left">Название статьи:</label>
                            <div class="col-sm-12">
                                <?= Html::activeTextInput($model, 'title', [
                                    'class' => 'form-control input-sm',
                                    'id' => 'title',
                                    'type' => 'text',
                                ]) ?>
                            </div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label class="col-sm-12 text-left">Описание:</label>
                            <div class="col-sm-12">
                                <?= Html::activeTextInput($model, 'description', [
                                    'class' => 'form-control input-sm',
                                    'id' => 'description',
                                    'type' => 'text',
                                ]) ?>
                            </div>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label class="col-sm-12 text-left">Текст:</label>
                            <div class="col-sm-12">
                                <?= Html::activeTextarea($model, 'body', [
                                    'class' => 'form-control input-sm',
                                    'id' => 'body',
                                    'type' => 'text',
                                    'rows' => '10',
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </article>
            </div>
        </div>
    </div>
</div>

