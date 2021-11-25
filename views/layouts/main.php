<?php

use app\assets\AppAsset;

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $content string
 */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="HTML5 Website"/>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="gtco-loader"></div>

<div id="page">
    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
