<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 13-12-19
 * Time: 上午11:02
 * To change this template use File | Settings | File Templates.
 */
// 编码
header("Content-type: text/html; charset=utf-8");
header('P3P: CP=CAO PSA OUR');



// 定义根目录
define('ROOT',		dirname(dirname(dirname(dirname(__FILE__)))));	// 根目录
define('APP_ROOT',	dirname(dirname(dirname(__FILE__))));			// 应用根目
define('WEB_ROOT',	dirname(dirname(__FILE__)));						// WEB根目
define('YII_ROOT',  APP_ROOT.'/protected');                 // YII框架目录
define('CDN_ROOT',  ROOT.'/project.cdn');                   //cdn图片目录

//定义分页每页显示的条数
define('GAME_PRE_PAGESIZE',8);                             //游戏列表每页显示条数
define('NEWS_PRE_PAGESIZE',4);                              //新闻列表每页显示条数
define('LETTER_PRE_PAGESIZE',5);                            //站内信每页显示条数

//定义网站名称
define('WEB_NAME','极聚网络');

//用户登入，session有效时间
define('LOGIN_SESSION_TIME',24);                        //用户登入        session有效时间（小时单位）
//设置时间
date_default_timezone_set('Asia/Shanghai');

//缓存开关
define("IS_CACHE",FALSE);