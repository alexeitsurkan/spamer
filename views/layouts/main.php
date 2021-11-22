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

    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <meta property="og:description" content=""/>
    <meta name="twitter:title" content=""/>
    <meta name="twitter:image" content=""/>
    <meta name="twitter:url" content=""/>
    <meta name="twitter:card" content=""/>

    <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i|Roboto+Mono" rel="stylesheet">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="gtco-loader"></div>

<div id="page">
    <?= $this->render('nav.php') ?>
    <?= $content ?>
    <?= $this->render('footer.php') ?>
</div>

<div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
