<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'pgsql:host=localhost;dbname=yii_test';
$db['username'] = 'fisak';
$db['password'] = '14789632qQ';

return $db;
