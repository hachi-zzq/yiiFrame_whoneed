<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-20
 * Time: 下午1:47
 * To change this template use File | Settings | File Templates.
 */
class Pdl_user_log_3 extends CActiveRecord{

    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->db_data_log;
    }

    public function tableName(){
        return strtolower(get_class($this));
    }

}