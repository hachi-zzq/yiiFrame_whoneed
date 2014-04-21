<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-14
 * Time: 下午3:44
 * To change this template use File | Settings | File Templates.
 */
class Pdl_user_log extends CActiveRecord{
    private $type = '';


    public function __construct($type){
        parent::__construct();
        $this->type = $type;
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->db_data_log;
    }

    public function tableName()
    {
        $acTName    = strtolower(get_class($this));
        $tablename  = strtolower($acTName.'_open');
        if(!Yii::app()->cache->get('table_exists_'.$tablename))
        {
            //create table
            Yii::app()->db_data_log->createCommand("create table if not exists {$tablename} like {$acTName}")->execute();
            //set cache
            Yii::app()->cache->set('table_exists_'.$tablename,1,864000);
        }

        return $tablename;
    }

//    public function returnType(){
//        $action = '';
//        switch($this->type){
//            case '1':
//                $action = 'open';break;
//            case '2':
//                $action = 'close';break;
//            case '3':
//                $action = 'login';break;
//            case '4':
//                $action = ''
//        }
//    }






}