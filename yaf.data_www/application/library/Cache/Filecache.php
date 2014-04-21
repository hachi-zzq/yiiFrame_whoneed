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
class Cache_Filecache extends Cache_Public
{
    public $directoryLevel= 0;
    public $cachePath     = null;
    public function init(){
        parent::init();
        $cacheConfig = Yaf_Registry::get("config")->cache->toArray();
        if( isset($cacheConfig['cachePath']) )
            $this->cachePath = $cacheConfig['cachePath'];
        else
            $this->cachePath = APP_PUBLIC."/runtime/cache/";
        isset($cacheConfig['directoryLevel']) && $this->directoryLevel = $cacheConfig['directoryLevel'];
        !is_dir($this->cachePath) && mkdir($this->cachePath,0777,true);
    }

    public function getValue($key){
        $cacheFile=$this->getCacheFile($key);
		if(($time=@filemtime($cacheFile))>time())
			return file_get_contents($cacheFile);
		else if($time>0)
			@unlink($cacheFile);
		return false;
    }

    public function setValue($key,$value,$expire){
		if($expire<=0)
			$expire=$this->defaultExpire ? $this->defaultExpire : 31536000; // 1 year
		$expire+=time();

		$cacheFile=$this->getCacheFile($key);

		if($this->directoryLevel>0)
			@mkdir(dirname($cacheFile),0777,true);
		if(@file_put_contents($cacheFile,$value,LOCK_EX)!==false)
		{
			@chmod($cacheFile,0777);
			return @touch($cacheFile,$expire);
		}
		else
			return false;
    }

    public function deleteValue($key){
        $cacheFile=$this->getCacheFile($key);
		return @unlink($cacheFile);
    }

    public function flushValues(){
        $this->gc(false);
		return true;
    }

    protected function getCacheFile($key){
		if($this->directoryLevel>0)
		{
			$base=$this->cachePath;
			for($i=0;$i<$this->directoryLevel;++$i)
			{
				if(($prefix=substr($key,$i+$i,2))!==false)
					$base.='/'.$prefix;
			}
			return $base.DIRECTORY_SEPARATOR.$key;
		}
		else
			return $this->cachePath.DIRECTORY_SEPARATOR.$key;
	}

    public function gc($expiredOnly=true,$path=null)
	{
		if($path===null)
			$path=$this->cachePath;
		if(($handle=opendir($path))===false)
			return;
		while(($file=readdir($handle))!==false)
		{
			if($file[0]==='.')
				continue;
			$fullPath=$path.DIRECTORY_SEPARATOR.$file;
			if(is_dir($fullPath))
				$this->gc($expiredOnly,$fullPath);
			else if($expiredOnly && @filemtime($fullPath)<time() || !$expiredOnly)
				@unlink($fullPath);
		}
		closedir($handle);
	}
}