<?php
//引入配置文件
require_once(dirname(__FILE__).'/config/config.php');

include ROOT.'/yiiframework/yii.php';
Yii::createWebApplication(ROOT.'/yiiframework/config/main.php')->run();


