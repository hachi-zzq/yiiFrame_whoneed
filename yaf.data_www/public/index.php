<?php
define("APP_PATH",  realpath(dirname(__FILE__) . '/../')); /* 指向public的上一级 */
define("APP_PUBLIC", APP_PATH.'/public/');
define("APP_DEBUG", true);
$app  = new Yaf_Application(APP_PATH."/conf/application.ini", 'develop');
$app->bootstrap()->run();