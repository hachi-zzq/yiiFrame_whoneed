<?php
/**
 * 广告相关接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		ads_api
 */
class AdsProject
{
    // 渠道名称
	static function funDealChannelName($objData = null){
		$strR = '极聚';

        if($objData && $objData->channel_id){
            $objDB = Pdc_channel::model()->find("id = {$objData->channel_id}");
            if($objDB){
                $strR = $objDB->channel_name;
            }

            // make sure is have sub_id
            $channel_id = intval($_GET['channel_id']);
            $is_sub     = intval($_GET['is_sub']);
            $objDB      = null;

            if($channel_id && $is_sub){
                print_r($objData);exit;
            }else{
                $isCount = 0;
                $isCount = Pdc_channel::model()->count("fid = {$objData->channel_id}");
                if($isCount)
                    $strR = "<a rel='column_list_47_sub' target='navTab' href='/admin/auto_form/auto_list/tid/47/channel_id/{$objData->channel_id}/is_sub/1'>{$strR}</a>";
            }
        }

		return $strR;
	}
    
    // 合作数据 cdb 查询条件
    static function fun_set_cdb_pa_st_channel_daily($arrWhere)
    {
        $arrR = array();
        $arrR['select'] = 'record_date, channel_id, channel_name, sum(install_nums) as install_nums, sum(new_users) as new_users, sum(active_nums) as active_nums, sum(reg_users) as reg_users, sum(login_users) as login_users, sum(pay_users) as pay_users, sum(pay_amount) as pay_amount';
        $arrR['group']  = 'channel_id';

        // show sub channel
        if(intval($_GET['is_sub'])){
            $arrR['group'] .= ', sub_id';    
        }

        // is_user_filter
        $arrAFOQuery = array();
        $arrAFOQuery = CF::getAutoFormOpe(intval($_GET['tid']), 'is_user_filter');
        if($arrAFOQuery)
        {
            $intAid = Yii::app()->user->getState('admin_id');
            $arrUser= array();
            if($arrAFOQuery['user_ids']){
                $arrUser = explode(',', $arrAFOQuery['user_ids']);
            }

            if($arrUser && in_array($intAid, $arrUser)){
                $strChannelIds = '';
                $objDB = Pdc_user_channel::model()->findAll("user_id = {$intAid}");
                if($objDB){
                    foreach($objDB as $obj){
                        $strChannelIds .= $strChannelIds == '' ? $obj->channel_id : ','.$obj->channel_id ;    
                    }
                }

                if($strChannelIds){
                    if($arrAFOQuery['user_exist']){
                        $channel_id = intval($_GET['channel_id']);
                        if($channel_id){
                            $arrR['conditions'][] = "channel_id = {$channel_id}";
                        }else{
                            $arrR['conditions'][] = "channel_id in ({$strChannelIds})";
                        }
                    }
                }
            }
        }
        // end is_user_filter

        // init query condition
        if($arrWhere) $arrWhere = CF::funGetTheWhereKey($arrWhere);
        if(!$arrWhere || !isset($arrWhere['record_date'])){
            $date = date('Y-m-d');
            $arrR['conditions'][] = "record_date = '{$date}'";
        }

        // conditions
        if($arrR['conditions']){
            $arrR['condition'] = implode(' AND ', $arrR['conditions']);
            unset($arrR['conditions']);
        }

        return $arrR;
    }
    
    // 获取应用名称
    static function funGetAppInfo()
    {
        $arrR = array();
        $arrR[''] = '请选择应用';

        $objDB = Pdc_app::model()->findAll();
        if($objDB){
            foreach($objDB as $obj){
                $arrR[$obj->appid] = $obj->appname."[{$obj->appid}]";
            }
        }

        return $arrR;
    }

    //================= test
    // 测试汇总数据特殊处理
    static function funDealRateTest($arrData)
    {
        $strR = '100%';
        $strR = $arrData['install_nums'] + $arrData['new_users'];
        return $strR;
    }

    // 列表页设置cdb查询条件
    static function funSetCdbTest($arrWhere)
    {
        $arrR = array();
        $arrR['select'] = 'id, record_date';
        $arrR['group']  = 'channel_id';

        return $arrR;
    }
    //================= test end
}
?>
