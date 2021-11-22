<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $name string
 * @var $message string
 * @var $exception Exception
 */

$this->title = $name;
?>


<header id="gtco-header" class="gtco-cover" role="banner" style="height: 300px">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div>
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
                    <div class="site-error">
                        <h1 class="danger"><?= Html::encode($this->title) ?></h1>
                        <div class="f_alert alert-danger">
                            <?= nl2br(Html::encode($message)) ?>
                        </div>
                        <p>Вышеуказанная ошибка произошла, когда веб-сервер обрабатывал ваш запрос.</p>
                        <p>Пожалуйста, свяжитесь с нами, если считаете, что это ошибка сервера. Спасибо.</p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
