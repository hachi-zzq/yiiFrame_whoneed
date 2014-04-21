<?php
/**
 * 系统配制接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		config_api
 */

class Config_api{

	/**
	 * 取得配制数据
	 *
	 * <b>使用示例：</b> Config_api::get_data('icp');
	 *
	 * @author	黑冰 (001.black.ice@gmail.com)
	 * @param	string	$ope_type	配制名称(类型)
	 * @time	2013-02-28
	 * @return	string or int
	 */ 
	public static function get_data($ope_type = ''){
		$strR = '';
		
		if($ope_type){
			$objDB = Vchat_config::model()->find("ope_type = '{$ope_type}'");
			if($objDB){
				$strR = $objDB->ope_value; 
			}
		}

		return $strR;
	}
}
?>