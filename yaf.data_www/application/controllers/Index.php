<?php
class IndexController extends Ctrl_Page 
{
    public $_layout = 'common/main.php';
    
    public function indexAction() 
    {
        //cache
        /*
        $objCache = Data_Cache::model();            //默认return filecache
        $objCache = Data_Cache::model('file');      //return object filecache
        $objCache = Data_Cache::model('memcache');  //return object memcache

        $objCache ->set($key,$data,$expire); //设置缓存
        $objCache ->get($key);               //获取缓存
        $objCache ->delete($key);            //删除缓存
        $objCache ->flush();                 //删除所有缓存

        */
        $objCache = Data_Cache::model('file');
        $val_hello = $objCache->get('hello');
        $val_world = $objCache->get('world');
        echo '测试缓存是否失效:<br />';
        $flag = true;
        if(!$val_hello){
            $flag = false;
            echo 'hello,缓存已失效!<br />';
            $objCache->set('hello',array('我asfds','你去死safdsa'),10);
        }
        if(!$val_world){
            $flag = false;
            echo 'world,缓存已失效!<br />';
            $objCache->set('world','你去死safdsa',20);
        }
        if($flag){
            echo '缓存没有失效';
            $val_hello = $objCache->get('hello');
            $val_world = $objCache->get('world');
            var_dump($val_hello);var_dump($val_world);
        }
        /*echo '<br />测试set,get:';
        $val_hello = $objCache->get('hello');
        $val_world = $objCache->get('world');
        var_dump($val_hello);var_dump($val_world);
        echo '<br />测试delete:';
        $objCache->delete('hello');
        $val_hello = $objCache->get('hello');
        $val_world = $objCache->get('world');
        var_dump($val_hello);var_dump($val_world);
        echo '<br />测试flush:';
        $objCache->flush();
        $val_hello = $objCache->get('hello');
        $val_world = $objCache->get('world');
        var_dump($val_hello);var_dump($val_world);*/
        
        $data = array();
        $data['sql']    = "select id from pdw_faq where id = :id";
        $data['param']  = array(':id' => "49");
        $arrData = Data_Proxy::model('project_data_www')->select($data);

        //print_r($arrData);

/*
        $data = array();
        $data['sql']    = "delete from pdw_faq where id = :id";
        $data['param']  = array(":id" => 52);
        $arrR = Data_Proxy::model('project_data_www')->delete($data);
        print_r($arrR);
*/
/*        
        $data = array();
        $data['sql']    = "update pdw_faq set type_id = 101 where id = :id";
        $data['param']  = array(":id" => 51);
        $arrR = Data_Proxy::model('project_data_www')->update($data);         
        print_r($arrR);
*/
/*
        $data = array();
        $data['sql']    = "insert into pdw_faq (type_id) values (:type_id)";
        $data['param']  = array(":type_id" => 102);
        $arrR = Data_Proxy::model('project_data_www')->insert($data);
        print_r($arrR);
*/

        $objModel = new PdwFaqModel();
        //print_r($objModel->find("id = 49"));

        $data = array();
        $data['t1'] = 't11';
        $data['t2'] = 't12';
        $this->display('index', $data);
    }
}
?>
