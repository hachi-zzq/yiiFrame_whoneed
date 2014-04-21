<?php
// yii ext path
$strYiiExtentions = ROOT . '/yiiframework/extentions';

return array(
    'name' => '',
    'basePath' => APP_ROOT . '/protected',
    'ExtensionPath' => $strYiiExtentions,
	'runtimePath' => WEB_ROOT .'/runtime',
    'preload' => array('log'),	// 预加载日志模块
    'import' => include 'auto_import.php',	// 自动引入扩展的包
    'components' => array(
		//================ 总后台
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString'		=> 'mysql:host=192.168.0.210;dbname=project_data_admin',
            'emulatePrepare'		=> TRUE,
            'username'				=> 'root_dev',
            'password'				=> 'root_dev',
            'charset'				=> 'utf8',
            'tablePrefix'			=> '',
            'schemaCachingDuration'	=> 0, // 数据缓存时间
            'enableProfiling'		=> FALSE, // 是否开启数据缓存
        ),

        'db_data_centre' => array(
            'class' => 'CDbConnection',
            'connectionString'		=> 'mysql:host=192.168.0.210;dbname=project_data_centre',
            'emulatePrepare'		=> TRUE,
            'username'				=> 'root_dev',
            'password'				=> 'root_dev',
            'charset'				=> 'utf8',
            'tablePrefix'			=> '',
            'schemaCachingDuration'	=> 0, // 数据缓存时间
            'enableProfiling'		=> FALSE, // 是否开启数据缓存
        ),

        'db_data_statistics' => array(
            'class' => 'CDbConnection',
            'connectionString'		=> 'mysql:host=192.168.0.210;dbname=project_data_statistics',
            'emulatePrepare'		=> TRUE,
            'username'				=> 'root_dev',
            'password'				=> 'root_dev',
            'charset'				=> 'utf8',
            'tablePrefix'			=> '',
            'schemaCachingDuration'	=> 0, // 数据缓存时间
            'enableProfiling'		=> FALSE, // 是否开启数据缓存
        ),
        'db_data_www' => array(
            'class' => 'CDbConnection',
            'connectionString'		=> 'mysql:host=192.168.0.210;dbname=project_data_www',
            'emulatePrepare'		=> TRUE,
            'username'				=> 'root_dev',
            'password'				=> 'root_dev',
            'charset'				=> 'utf8',
            'tablePrefix'			=> '',
            'schemaCachingDuration'	=> 0, // 数据缓存时间
            'enableProfiling'		=> FALSE, // 是否开启数据缓存
        ),
        'db_data_log' => array(
            'class' => 'CDbConnection',
            'connectionString'		=> 'mysql:host=192.168.0.210;dbname=project_data_log',
            'emulatePrepare'		=> TRUE,
            'username'				=> 'root_dev',
            'password'				=> 'root_dev',
            'charset'				=> 'utf8',
            'tablePrefix'			=> '',
            'schemaCachingDuration'	=> 0, // 数据缓存时间
            'enableProfiling'		=> FALSE, // 是否开启数据缓存
        ),
        'db_data_finance' => array(
            'class' => 'CDbConnection',
            'connectionString'		=> 'mysql:host=192.168.0.210;dbname=project_data_finance',
            'emulatePrepare'		=> TRUE,
            'username'				=> 'root_dev',
            'password'				=> 'root_dev',
            'charset'				=> 'utf8',
            'tablePrefix'			=> '',
            'schemaCachingDuration'	=> 0, // 数据缓存时间
            'enableProfiling'		=> FALSE, // 是否开启数据缓存
        ),
        'project_data_channel' => array(
            'class' => 'CDbConnection',
            'connectionString'		=> 'mysql:host=192.168.0.210;dbname=project_data_channel',
            'emulatePrepare'		=> TRUE,
            'username'				=> 'root_dev',
            'password'				=> 'root_dev',
            'charset'				=> 'utf8',
            'tablePrefix'			=> '',
            'schemaCachingDuration'	=> 0, // 数据缓存时间
            'enableProfiling'		=> FALSE, // 是否开启数据缓存
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => FALSE,
            'rules' => include 'url.php',
        ),
        'cache' => array(
            'class' => 'CFileCache', //文件缓存
            //'cachePath' =>  ROOT.'/runtime/cache',// 缓存目录
            'directoryLevel' => '1', // 缓存文件的目录深度
        ),
        'session' => array(
            'class' => 'CDbHttpSession', // 基于数据库的session
            'connectionID' => 'db',
            'sessionTableName' => 'user_session',
            'autoCreateSessionTable' => TRUE,
        ),
        'user' => array(
            'allowAutoLogin' => TRUE, // enable cookie-based authentication
        ),
        'request' => array(
            'enableCookieValidation' => TRUE, // 防止Cookie攻击,要用CHttpCookie
        ),
        'assetManager' => array(
            'BasePath' => WEB_ROOT .'/runtime',
            'baseUrl' => '/runtime',
        ),
    ),
    // 加载全局变量
    // 调用方法 Yii::app()->params['paramName']
    'params' => array(
        'img_domain'     => 'http://test.cdn.patabom.com',
        'cdn_domain'     => 'http://test.cdn.patabom.com',
        'fore_domain'    => 'http://test.www.patabom.com',
        'SSDB'           => array('host' => '192.168.0.210', 'port' => 8888),
        'patabom_api_url'=> 'http://test.fdplat.haoyoudou.com:81/web.php',//测试地址
        //'patabom_api_url'=> 'http://fdplat.haoyoudou.com/web.php',      //正式地址
        'cache_timeout' => 3600,
        //动态规则,key为all匹配所有的域名,单独的域名仅匹配自己,value可以为字符串也可以为数组
        /*'dynamicRule'    => array('all'=>array('/^user/', '/^innerletter/', '/^money/', '/^activity/', '/^mall/',
                                                '/^forum/', '/^customer/', '/^faq/', '/^site\/getnovicePackage/'),
                                  'fapi.patabom.com'=>'/.+/',
                                 ),*/
        'dynamicRule'     => array('all'=>'/.*/'),//测试模式,不开启缓存

    ),
);
