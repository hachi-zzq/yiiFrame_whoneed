<?php
/**
 * Bootstrap类
 *
 * @author      黑冰(001.black.ice@gmail.com)
 * @copyright   (c) 2014
 * @version     $Id$
 * @since       v0.1
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{
    public function _initConfig()
    {
        $config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set("config", $config);
    }
    
    public function _initLayout(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->disableView();
        Yaf_Registry::set('dispatcher', $dispatcher);
    }

    public function _initSession()
    {
        Yaf_Session::getInstance()->start();
    }

    public function _initPlugin(Yaf_Dispatcher $dispatcher)
    { 
        $cache = new CachePlugin(); 
        $dispatcher->registerPlugin($cache);
    }
}