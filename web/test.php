<?php

require __DIR__ . '/../vendor/autoload.php';

define('YII_DEBUG', env('YII_DEBUG'));
define('YII_ENV', env('YII_ENV'));

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

$application = new yii\web\Application($config);

//c этой строки можете запускать код который нужно протестить
//echo 'hello world';