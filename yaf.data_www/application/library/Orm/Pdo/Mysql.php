<?php
/**
 * orm_pdo_mysql
 *
 * @author      黑冰(001.black.ice@gmail.com)
 * @copyright   (c) 2014
 * @version     $Id$
 * @package     orm.pdo
 * @since       v0.1
 */
class Orm_Pdo_Mysql
{
    public function find($config = null)
    {
        $arrR = array();
        $data = array();

        if($config){
            $sql = "select * from {$this->_table_name}";
            if($config) $sql .= " where {$config}";
            $sql .= " limit 1";
            $data['sql'] = $sql;
        }

        $arrR = Data_Proxy::model('project_data_www')->select($data);

        return current($arrR);
    }
}
