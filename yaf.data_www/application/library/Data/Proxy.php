<?php
/**
 * DB代理类
 *
 * @author      黑冰(001.black.ice@gmail.com)
 * @copyright   (c) 2014
 * @version     $Id$
 * @package     data
 * @since       v0.1
 */
class Data_Proxy
{
    public static $_instance    = null;
    public $_param              = null;

    public function __construct($param) 
    {
        $this->_param = $param;
        return self::conn($param);
    } 

    public static function model($param)
    {
        return self::conn($param); 
    }

    public static function conn($param)
    {
        if (!(self::$_instance[$param])) {
            $arrDB = Yaf_Registry::get("config")->db->toArray();
//            print_r($arrDB);
            if($arrDB && $arrDB[$param]){
                // pdo_mysql
                if(!isset($arrDB[$param]['type']) || empty($arrDB[$param]['type'])
                                        || $arrDB[$param]['type'] == 'pdo_mysql'){
                    self::$_instance[$param] = new Db_Pdo_Mysql($param, $arrDB[$param]);
                }
            }
        }
//        print_r(self::$_instance[$param]);
        return self::$_instance[$param];

    }

    public function getObject()
    {
        return self::$_instance[$this->_param]->conn();
    }
}
?>
