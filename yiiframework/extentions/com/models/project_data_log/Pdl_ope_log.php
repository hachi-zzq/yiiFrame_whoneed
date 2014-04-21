<?php
class Pdl_ope_log extends CActiveRecord
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

    public function doLog()
    {
		$user_id   = Yii::app()->user->getState('admin_id');
		$path_info = "/".Yii::app()->request->pathInfo."/";
		$access_id = 0;
		
		$url = Yii::app()->request->getRequestUri();
		$post_data = var_export($_POST, true);
		
		// 保存数据
		$log = new Pdl_ope_log();
		$log->user_id = $user_id;
		$log->access_id = $access_id;
		$log->url = $url;
		$log->post_data = $post_data;
		$log->time = date('Y-m-d H:i:s', time());
		$log->ip = MyAdminController::getUserHostAddress();
		$log->save();	
	}    
}
?>
