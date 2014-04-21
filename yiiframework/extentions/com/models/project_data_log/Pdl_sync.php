<?php
class Pdl_sync extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
	    return strtolower(get_class($this));
    }

    public function getDbConnection()
    {
        return Yii::app()->db_data_log;
    } 
}
?>
