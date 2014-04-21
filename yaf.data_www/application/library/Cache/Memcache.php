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
class Cache_Memcache extends Cache_Public
{
    private $_cache       = null;
	public  $useMemcached = false;
	private $_servers=array();

    public function init(){
        parent::init();
        $cache   = $this->getMemCache();
        $cacheConfig = Yaf_Registry::get("config")->cache->toArray();
        if( isset($cacheConfig['servers']) && is_array($cacheConfig['servers']) ){
			foreach($cacheConfig['servers'] as $server){
				if($this->useMemcached)
					$cache->addServer($server['host'],$server['port'],$server['weight']);
				else{
					!isset( $server['persistent'] ) && $server['persistent']=true;
					!isset( $server['timeout'] ) && $server['timeout']=15;
					!isset( $server['status'] ) && $server['status']=true;
					$cache->addServer($server['host'],$server['port'],$server['persistent'],$server['weight'],$server['timeout'],$server['status']);
				}
			}
		}else{
			$cache ->addServer('localhost',11211);
		}
    }

    public function getMemCache(){
		if($this->_cache!==null)
			return $this->_cache;
		else
			return $this->_cache=$this->useMemcached ? new Memcached : new Memcache;
	}

    protected function getValue($key){
		return $this->_cache->get($key);
	}

	protected function setValue($key,$value,$expire){
		if($expire<=0)
			$expire=$this->defaultExpire ? $this->defaultExpire : 31536000; // 1 year
        $expire+=time();
		return $this->useMemcached ? $this->_cache->set($key,$value,$expire) : $this->_cache->set($key,$value,0,$expire);
	}

	public function getValues($keys){
        return $this->useMemcached ? $this->_cache->getMulti($keys) : $this->_cache->get($keys);
    }

    public function deleteValue($key){
        return $this->_cache->delete($key, 0);
    }

    public function flushValues(){
        return $this->_cache->flush();
    }
}