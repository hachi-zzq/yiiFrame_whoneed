<?php
/**
 * PataBom相关接口
 *
 * @author		黑冰 (001.black.ice@gmail.com)
 * @copyright	Copyright 2013
 * @package		patabom
 */
class PataBomProject
{
    // 获取游戏分类
    static function funGetGameType(){
        $arrR = array();

        $cdb = new CDbCriteria();
        $cdb->order = "id asc";

        $objDB = Pdw_games_cat::model()->findAll($cdb);
        if($objDB){
            foreach($objDB as $obj){
                $arrR[$obj->id] = $obj->name;
            }
        }

        return $arrR;
    }


    //获取用户注册方式
    static function funGetUserRegType(){
       return array(
           '1'=>'手机注册',
           '2'=>'邮箱注册',
           '3'=>'个性注册'

       );

    }


    //获取所有的用户
    static public function funGetUser(){
        $user =  Pdw_user::model();
        $allUser = $user->findAll(array(
            'select'=>'id,username'
        ));
        $retArr = array();
        foreach($allUser as $value){
            $retArr[$value['id']] = $value['username'];
        }
        return $retArr;
    }

    // 获取所有游戏
    static public function funGetGameList()
    {
        $arrR = array();
        $arrR['-100'] = '请选择游戏';

        $cdb = new CDbCriteria();
        $cdb->select    = 'id,title';
        $cdb->order     = "id asc";

        $objDB = Pdw_games::model()->findAll($cdb);
        if($objDB){
            foreach($objDB as $obj){
                $arrR[$obj->id] = $obj->title;
            }
        }

        return $arrR;        
    }
}
?>
