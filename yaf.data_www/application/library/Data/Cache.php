<?php
/**
 * cache代理类
 *
 * @author      黑冰(001.black.ice@gmail.com)
 * @copyright   (c) 2014
 * @version     $Id$
 * @package     data
 * @since       v0.1
 */
class Data_Cache
{
    static $_instance   = null;

    public function __construct($type = null) 
    {
        return self::model($type);
    }

    public static function model($type=null)
    {
        if($type===null){
            $type = Yaf_Registry::get("config")->cache->defaultCache;
            $type = $type ? $type : 'file';
        }
        if(@!self::$_instance[$type]){
            self::$_instance[$type] = self::conn($type);
        }

        return self::$_instance[$type];
    }

    public static function conn($type)
    {
        if($type === 'file'){
            return new Cache_Filecache;
        }else if($type === 'memcache'){
            return new Cache_Memcache;
        }
    }
}