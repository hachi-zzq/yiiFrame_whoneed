<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-1-14
 * Time: 下午3:44
 * To change this template use File | Settings | File Templates.
 */
class Pdl_machine extends CActiveRecord{

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
        return  strtolower(get_class($this));
    }







}