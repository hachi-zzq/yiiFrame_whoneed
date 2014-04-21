<?php
class CachePlugin extends Yaf_Plugin_Abstract
{
    private $isNeedCache = false;
    private $url         = null;
    //路由结束之后触发
    public function routerShutdown( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){
        //$this->url = strtolower($request->module.'/'.$request->controller.'/'.$request->action.'/'.http_build_query($_GET));
        $this->url = strtolower( trim($_SERVER['REQUEST_URI'],'/') );
        //post跳过,ajax跳过
        if($request->method==='POST'){
            header('cache:break');
            $this->isNeedCache = false;
            return;
        }
        if( !$this->isNeedCache($this->url) ){
            header('cache:no');
            $this->isNeedCache = false;
        }else{
            if( $request->getParam('flush') === 'true' ){
                if( preg_match('#(.*?)/flush/true#i',$this->url,$result) ){
                    $url = $result[1];
                    Data_Cache::model()->delete($url);
                    header('Content-Type:text/html; charset=utf-8');
                    echo '<script language="javascript" type="text/javascript">
                            alert("清除缓存成功!");
                            window.location.href="http://'.$_SERVER['HTTP_HOST'].'/'.$url.'"; 
                          </script>';
                    die();
                }
            }
            $html = Data_Cache::model()->get($this->url);
            //有缓存则直接输出
            if( $html!==false ){
                header('cache:yes');
                echo $html;
                die();
            }else{
                header('cache:create');
                $this->isNeedCache = true;
                ob_start();
            }
        }
    }

    //分发循环结束之后触发
    public function dispatchLoopShutdown ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){
        if($this->isNeedCache){
            //设置缓存
            $value = ob_get_contents();
            $value.= $response->getBody();
            ob_end_flush();
            $defaultExpire = Yaf_Registry::get("config")->cache->defaultExpire;
            Data_Cache::model()->set($this->url,$value,$defaultExpire);
        }
    }

    //判断是否是动态url
    public function isNeedCache($url){
        $rule_file = Yaf_Registry::get("config")->html_not_cache_rule;
        $rule = include($rule_file);
        foreach((array)$rule as $pattern){
            if( preg_match(strtolower($pattern),$url) )
                return false;
        }
        return true;
    }
}