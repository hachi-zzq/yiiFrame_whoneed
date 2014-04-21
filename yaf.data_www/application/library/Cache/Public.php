<?php
/**
 * cache_file类
 *
 * @author      
 * @copyright   (c) 2014
 * @version     $Id$
 * @package     db.pdo
 * @since       v0.1
 */
abstract class Cache_Public
{
    public $keyPrefix     = APP_PATH;
    public $defaultExpire = 0;
    public function __construct(){
        $cacheConfig = Yaf_Registry::get("config")->cache->toArray();
        isset($cacheConfig['keyPrefix']) && $this->keyPrefix = $cacheConfig['keyPrefix'];
        isset($cacheConfig['defaultExpire']) && $this->defaultExpire = $cacheConfig['defaultExpire'];
        $this->init();
    }

    public function init(){
    }

    public function set($id,$value,$expire=0){
		$data = array($value);
		return $this->setValue($this->generateUniqueKey($id),serialize($data),$expire);
    }

    abstract protected function setValue($key,$value,$expire);

    public function get($id){
        if(($value=$this->getValue($this->generateUniqueKey($id)))!==false)
		{
			$data=unserialize($value);
			if(is_array($data))
                return $data[0];
		}
		return false;
    }

    abstract protected function getValue($id);

    public function delete($id){
        return $this->deleteValue($this->generateUniqueKey($id));
    }

    abstract public function deleteValue($id);

    public function flush(){
        return $this->flushValues();
    }

    abstract public function flushValues();

    protected function generateUniqueKey($key){
		return md5($this->keyPrefix.$key);
	}
}