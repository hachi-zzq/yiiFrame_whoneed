<?php
/**
 * pdo_mysql类
 *
 * @author      黑冰(001.black.ice@gmail.com)
 * @copyright   (c) 2014
 * @version     $Id$
 * @package     db.pdo
 * @since       v0.1
 */
class Db_Pdo_Mysql
{
    private static $_instance = null;
    private $_key               = null;
    private $_data              = null;

    public function __construct($key, $data) 
    {   
        $this->_key     = $key;
        $this->_data    = $data;
    }

    public function conn()
    {  
        if (!(self::$_instance[$this->_key])){  
            try{ 
                $db_dsn     = $this->_data['db_dsn'];
                $db_user    = $this->_data['db_user'];
                $db_pass    = $this->_data['db_pass'];
                $db_charset = isset($this->_data['db_charset']) ? isset($this->_data['db_charset']) : 'utf8';
                self::$_instance[$this->_key] = new PDO($db_dsn, $db_user, $db_pass, 
                                                        array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES '.$db_charset));  
                self::$_instance[$this->_key]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
            }catch (PDOException $e){  
                exit($e->getMessage());  
            }
        }  
        return self::$_instance[$this->_key];  
    }

    public function close()
    {
        self::$_instance[$this->_key] = null;
    }

    public function select($data)
    {
        $obj    = $this->doExecute($data);
        $arrR   = array();

        while($row = $obj->fetch(PDO::FETCH_ASSOC)){       
            $arrR[] = $row;   
        }
        
        return $arrR;
    }

    public function insert($data)
    {
        $this->doExecute($data);
        return self::$_instance[$this->_key]->lastinsertid();
    }

    public function delete($data)
    {
        return $this->doExecute($data)->rowCount();
    }

    public function update($data)
    {
        return $this->doExecute($data)->rowCount();
    }

    public function doExecute($data)
    {
        $this->conn();
        $obj = null;

        // prepare sql
        if($data['sql'])
            $obj = self::$_instance[$this->_key]->prepare($data['sql']);
        
        // do prepare param
        if($obj && isset($data['param']) && is_array($data['param']))
            $obj->execute($data['param']);
        else
            $obj->execute();
        
        if(APP_DEBUG && isset($_GET['debug']))
            print_r($data);

        return $obj;
    }

    public function showQuery($query, $params)
    {
        # build a regular expression for each parameter
        foreach ($params as $key=>$value)
        {
            $query = str_replace($key, $value, $query);
        }
        
        return $query;
    }
}
?>
