<?php
class CacheModel extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		$class = parent::model($className);
		return $class->cache(Yii::app()->params['cache_timeout'], new CDbCacheDependency($class->getCacheSql()));
	}

	public function getDbConnection()
	{
		return Yii::app()->db;
	}

	public function tableName()
	{
		return strtolower(get_class($this));
	}
	
	public function afterSave()
	{
		$this->clearCache();
		return parent::afterSave();
	}
	
	public function afterDelete()
	{
		$this->clearCache();
		return parent::afterDelete();
	}
	
	public function getCacheSql()
	{
		$table_name = $this->tableName();
		return "SELECT value FROM `cache` WHERE `key` = '{$table_name}'";
	}
	
	public function clearCache()
	{
		$cache_value = md5($this->getCacheSql().MyFunction::rand());
		$table_name = $this->tableName();
		$sql = "REPLACE INTO `cache` (`key`,`value`) values ('{$table_name}','{$cache_value}')";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		return $command->execute();
	}
}
?>
