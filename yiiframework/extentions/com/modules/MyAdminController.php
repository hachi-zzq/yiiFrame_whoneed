<?php
/**
 * 总后台基类
 *
 * @author		黑冰(001.black.ice@gmail.com)
 * @copyright	(c) 2012
 * @version		$Id$
 * @package		com.modules
 * @since		v0.1
 */

	// 后台控制类
	class MyAdminController extends MyController{

		// 初始化
		public function init(){
            @session_start();
			parent::init();

			if((substr(Yii::app()->request->pathInfo, 0, 16) != 'admin/site/login' &&  substr(Yii::app()->request->pathInfo, 0, 18) != 'admin/site/captcha') && (!Yii::app()->user->getState('admin_is_login') || Yii::app()->user->isGuest))
			{
				Yii::app()->request->redirect('/admin_login.php');
			}

            if(Yii::app()->user->getState('weak_password')===true && substr(Yii::app()->request->pathInfo, 0, 25) != 'admin/site/weakPassChange'){
                Yii::app()->request->redirect('/admin/site/weakPassChange');
            }

			//后台管理布局
			Yii::app()->setLayoutPath(Yii::app()->basePath.'/views/admin/layouts');

            // 记录操作日记
		    Pdl_ope_log::model()->doLog();

            //暂时限定只能admin登录
//            if( ! Yii::app()->user->isGuest && Yii::app()->user->getState('admin_is_login')){
//                  if(Yii::app()->user->getState('user_name') != 'admin'){
//                      MyFunction::alert_back('系统正在升级，请稍后尝试','/admin_login.php');
//                  }
//            }


		}
	}
?>
