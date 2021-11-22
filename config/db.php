<?php

return [
    'class'    => 'yii\db\Connection',
    'dsn'      => env('DB') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME'),
    'username' => env('DB_USER'),
    'password' => env('DB_PASS'),
    'charset'  => 'utf8',

//    'enableSchemaCache' => true,

    // Продолжительность кеширования схемы.
//    'schemaCacheDuration' => 3600,

    // Название компонента кеша, используемого для хранения информации о схеме
//    'schemaCache' => 'cache',
];
