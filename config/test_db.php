<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] =  env('DB') . ':host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME_TEST');

return $db;
