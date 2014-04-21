<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 13-12-19
 * Time: 上午10:22
 * To change this template use File | Settings | File Templates.
 */
class UserController extends MyPageController{

    public function actionTest(){
        die();
        require_once(Yii::getPathOfAlias('ext').'/com/tools/qrcode.class.php');
        QRcode::png('http://www.baidu.com',CDN_ROOT.'/11.png');
    }

    //actionIndex   首页（个人中心）
    public function actionIndex(){
        $data['pageTitle'] = '个人中心';
        $data['person_current'] = 'user';
        $data['current'] = 'person';
        $this->renderPartial('person',$data);
    }

    //login
    public function actionLogin(){
        $userForm = new UserForm('login');
        $userForm->account    = Yii::app()->request->getParam('username');
        $userForm->password   = Yii::app()->request->getParam('password');
        $userForm->rememberMe = (bool)Yii::app()->request->getParam('remember');
        if($userForm->validate() && $userForm->login()){
            echo json_encode(array('status'=>'ok',
                                   'remark'=>'password',
                                   'message'=>'登入成功'
                                   )
                             );
            die();
        }else{
            if($userForm->hasErrors()){
                $message=$userForm->getErrors();
                $message_str='';
                foreach($message as $val){
                    $message_str.=$val[0];
                }
            }else{
                $message_str='用户名和密码错误';
            }
            echo json_encode(   array('status'=>'error',
                                      'remark'=>'password',
                                      'message'=>$message_str,
                                      )
                             );
            die();
        }
    }

    //show login
    public function actionShowLogin(){
        $data['pageTitle'] = '用户登入';
        $data['current'] = 'person';
        $this->renderPartial('login',$data);
    }

    public function actionShowRegister(){
        $data['pageTitle'] = '用户注册';
        $data['current'] = 'person';
        $this->renderPartial('register',$data);
    }

    //register
    public function actionRegister(){
        $type_relation =array(1=>9,//手机注册
                              2=>2,//邮箱注册
                              3=>10,//个性注册
                              );
        $userForm = new UserForm('register');
        $userForm->account    = Yii::app()->request->getParam('username');
        $userForm->password   = Yii::app()->request->getParam('password');
        $userForm->rePassword = Yii::app()->request->getParam('repassword');
        $userForm->type       = isset($type_relation[(int)Yii::app()->request->getParam('reg_type')]) ? $type_relation[(int)Yii::app()->request->getParam('reg_type')] : 0;
        if($userForm->validate() && $userForm->register()){
            //自动登入
            //发送站内欢迎信
            $message_model = Pdw_message::model();
            $one = $message_model->find('type=2');
            $this->sendLetter(Yii::app()->user->id,$one['title'],$one['content'],$one['id']);
            MyFunction::funAlert('注册成功',Yii::app()->createUrl('/user/LoginInfo'));
        }else{
            if($userForm->hasErrors()){
                $message=$userForm->getErrors();
                $message_str='';
                foreach($message as $val){
                    $message_str.=$val[0];
                }
            }else{
                $message_str='系统繁忙';
            }
            MyFunction::funAlert($message_str,Yii::app()->createUrl('/site/'));
        }
    }

    public function sendLetter($user_id,$title,$content,$message_id){
        $letter_model = new Pdw_inner_letter();
        $letter_model->title = $title;
        $letter_model->to_user = $user_id;
        $letter_model->message_id = $message_id;
        $letter_model->content = $content;
        $letter_model->status = 0;
        $letter_model->send_time = date('Y-m-d H:i:s');
        $letter_model->save();
    }


    //person infomation
//       个人信息
    public function actionLoginInfo(){
        $request_url = base64_encode($_SERVER["REQUEST_URI"]);
        //check  is login ???
        if(Yii::app()->user->isGuest){
            //验证是否登入
            $this->redirect("/user/showlogin?request=$request_url");
        }
        $user = Pdw_user::model();
        $loginedUser = $user->findByPk(Yii::app()->user->id);
        $data['loginedInfo'] = $loginedUser;
        $data['pageTitle'] = '个人资料';
        $data['person_current'] = 'user_info';
        $data['current'] = 'person';
        $this->renderPartial('userinfo',$data);

    }

    //完善个人呢资料
     public function actionFilledInfo(){

         //check  is login ???
         if(Yii::app()->user->isGuest){
             //验证是否登入
             $this->redirect('/user/showlogin');
         }
         $user = Pdw_user::model();
         $loginedUser = $user->findByPk(Yii::app()->user->id);
         //修改资料
         if(isset($_POST['user_id'])){

             //验证身份证是否合法
             $iDCardPattern='/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/';
            if((!empty($_POST['identity']))&& ! preg_match($iDCardPattern,$_POST['identity'])){
                MyFunction::funAlert('身份证不合法','-1');
                exit;
            }

             //验证邮箱
             $emailPattern = '/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/';
             if((!empty($_POST['email']))&&  ! preg_match($emailPattern,$_POST['email'])){
                 MyFunction::funAlert('邮箱不合法','-1');
                 exit;
             }
             //验证手机号
             $phonePattern = '/^(13[0-9]{9})|(15[0-9][0-9]{8})$/';
             if((!empty($_POST['phone']))&&   ! preg_match($phonePattern,$_POST['phone'])){
                 MyFunction::funAlert('手机号不合法','-1');
                 exit;
             }

            $user->true_name = MyFunction::inNoInjection($_POST['truename']);
            $user->identity = MyFunction::inNoInjection($_POST['identity']);
            $user->phone = MyFunction::inNoInjection($_POST['phone']);
            $user->email = MyFunction::inNoInjection($_POST['email']);
            $info['true_name'] = $user->true_name;
            $info['identity'] = $user->identity;
            $info['phone'] = $user->phone;
            $info['email'] = $user->email;
             //头像处理
             if( ! empty($_FILES['user_head']['name'])){
                 $head = MyUploadFile::pageUploadCdnImg('user_head');
                 $info['head_img'] = $head;
             }
            $res = $user->updateByPk($_POST['user_id'],$info);
            if($res){
                MyFunction::funAlert('修改成功',Yii::app()->createUrl('/user/logininfo'));
            }else{
                MyFunction::funAlert('修改失败',Yii::app()->createUrl('/user/logininfo'));
            }
         }

         $data['loginedInfo'] = $loginedUser;
         $data['pageTitle'] = '完善个人资料';
         $data['person_current'] = 'user_info';
         $data['current'] = 'person';
         $this->renderPartial('filled_info',$data);
     }

    //修改密码
     public function actionChangePassword(){
         //check  is login ???
         if(Yii::app()->user->isGuest){
             //验证是否登入
             $this->redirect('/user/showlogin');
         }
         //修改密码
         $old_pwd = MyFunction::inNoInjection($_POST['originalPassword']);
         $new_pwd = MyFunction::inNoInjection($_POST['newPassword']);
         $re_new_pwd = MyFunction::inNoInjection($_POST['againNewPassword']);
         //验证两次密码是否一致
         if($new_pwd !== $re_new_pwd){
             MyFunction::funAlert('两次密码不一致','-1');
             exit;
         }
         //验证密码长度
         if(mb_strlen($new_pwd,'utf8') < 6 ){
             MyFunction::funAlert('密码不能少于六位','-1');
             exit;
         }
         $parama_array['c'] = 'home';
         $parama_array['m'] = 'update_pwd';
         $parama_array['user_id'] = Yii::app()->user->id;
         $parama_array['pwd_code'] = Yii::app()->user->pwd_code;
         $parama_array['old_pwd'] = $old_pwd;
         $parama_array['new_pwd'] = $new_pwd;
         $api_url = Yii::app()->params['patabom_api_url'].'?'.http_build_query($parama_array);
         $result = MyFunction::get_url($api_url);
         //var_dump($api_url);var_dump($result);die();
         if($result && $result['code']==200 && !empty($result['content'])){
            $content = json_decode($result['content'],true);
                if($content['flag']=='success'){
                    Yii::app()->user->logout();
                    MyFunction::alert_back('修改成功,请重新登入',Yii::app()->createUrl('/user/showlogin'));
                }else if($content['flag']==='error_pwd_code'){
                    Yii::app()->user->logout();
                    MyFunction::alert_back('登录已失效,请重新登录!',Yii::app()->createUrl('/user/showlogin'));
                }else if( isset($content['info']) ){
                    MyFunction::alert_back($content['info'],0);
                }
         }else{
                MyFunction::alert_back('修改失败',0);
         }
     }

    //logout
    public function actionLogout(){
//        Yii::app()->session->clear();
//        Yii::app()->session->destroy();
        Yii::app()->user->logout();
        $this->redirect('/');
    }

    //vip introduce vip体系
    public function actionVipIntroduce(){
        $data['pageTitle'] = 'VIP体系';
        $data['current'] = 'customer';
        $this->renderPartial('vipintroduce',$data);
    }


    //vip经验
     public function actionVipLevel(){
         $request_url = base64_encode($_SERVER["REQUEST_URI"]);
         //check  is login ???
         if(Yii::app()->user->isGuest){
             //验证是否登入
             $this->redirect("/user/showlogin?request=$request_url");
         }
         $data['pageTitle'] = 'vip经验';
         $this->renderPartial('vip_level',$data);
     }

    //vip积分
    public function actionVipScore(){
        $request_url = base64_encode($_SERVER["REQUEST_URI"]);
        //check  is login ???
        if(Yii::app()->user->isGuest){
            //验证是否登入
            $this->redirect("/user/showlogin?request=$request_url");
        }
        //已经登入
        $recharge = Pdw_recharge::model();
        $sql = 'select * from  pdw_score s join pdw_score_type t on s.type = t.id ';
        $data['all'] = Page::funGetIntroBySql($sql,false,Yii::app()->db_data_www);

        $data['pageTitle'] = 'vip积分';
        $this->renderPartial('vip_score',$data);
    }

    //我的背包
    public function actionBackPack(){
        $request_url = base64_encode($_SERVER["REQUEST_URI"]);
        //check  is login ???
        if(Yii::app()->user->isGuest){
            //验证是否登入
            $this->redirect("/user/showlogin?request=$request_url");
        }

        $data['pageTitle'] = '背包';
        $this->renderPartial('backpack',$data);
    }

    //充值信息
    public function actionRecharge(){
        $request_url = base64_encode($_SERVER["REQUEST_URI"]);
        //check  is login ???
        //check  is login ???
        if(Yii::app()->user->isGuest){
            //验证是否登入
            $this->redirect("/user/showlogin?request=$request_url");
        }

        //已经登入
        $recharge = Pdw_recharge::model();
        $sql = 'select * from  pdw_recharge r join pdw_recharge_type t on r.recharge_type = t.id ';
        $data['all'] = Page::funGetIntroBySql($sql,false,Yii::app()->db_data_www);

        $data['pageTitle'] = '充值信息';
        $this->renderPartial('recharge',$data);
    }
    
    //存档找回
    public function actionGameProgress(){
        $request_url = base64_encode($_SERVER["REQUEST_URI"]);
        if(Yii::app()->user->isGuest){
            //验证是否登入
            $this->redirect("/user/showlogin?request=$request_url");
        }
        $parama_array=array();
        if( isset($_REQUEST['app_key']) ){
            $parama_array['app_key'] = $_REQUEST['app_key'];
        }
        $parama_array['user_id']  = Yii::app()->user->id;
        $parama_array['pwd_code'] = Yii::app()->user->pwd_code;
        $parama_array['c'] = 'home';
        $parama_array['m'] = 'search_game_progress';
        $api_url = Yii::app()->params['patabom_api_url'].'?'.http_build_query($parama_array);
        $result = MyFunction::get_url($api_url);
        //var_dump($parama_array);var_dump($api_url);var_dump($result);die();
        if($result && $result['code']==200 && !empty($result['content'])){
            $content = json_decode($result['content'],true);
            if($content['flag']==='success'){
                $data['data']['flag'] = 'success';
                $data['data']['data'] = $content['data'];
            }else if($content['flag']==='error_pwd_code'){
                Yii::app()->user->logout();
                MyFunction::alert_back('登录已失效,请重新登录!',Yii::app()->createUrl('/user/showlogin'));
            }else{
                $data['data']['flag'] = 'error';
                $data['data']['info'] = $content['info'];
            }
        }else{
            $data['data']['flag'] = 'error';
            $data['data']['info'] = '系统繁忙,请稍后再试!';
        }
        //var_dump($data['data']);die();
        $data['pageTitle'] = '存档找回';
        $data['person_current'] = 'game_progress';
        $data['current'] = 'person';
        $data['html'] = $html;
        $this->renderPartial('game_progress',$data);
    }
    
    //存档切换
    public function actionChangeRole(){
        $reArr=array();
        if(Yii::app()->user->isGuest){
            $reArr['flag'] = 'error';
            $reArr['info'] = '你还没有登录!请登录再尝试!';
        }else{
            $parama_array=array();
            $parama_array['user_id'] = Yii::app()->user->id;
            $parama_array['c'] = 'home';
            $parama_array['m'] = 'change_role';
            $parama_array['app_key']       = $_REQUEST['app_key'];
            $parama_array['orignal_token'] = $_REQUEST['o_token'];
            $parama_array['operate_key']   = $_REQUEST['o_key'];
            $api_url = Yii::app()->params['patabom_api_url'].'?'.http_build_query($parama_array);
            $result = MyFunction::get_url($api_url);
            //var_dump($api_url);var_dump($result);die();
            if($result && $result['code']==200 && !empty($result['content'])){
                $content = json_decode($result['content'],true);
                if($content['flag']=='success'){
                    $reArr['flag'] = 'success';
                    $reArr['info'] = '切换存档成功!';
                }else if($content['flag']==='error_pwd_code'){
                    Yii::app()->user->logout();
                    $reArr['flag'] = 'error';
                    $reArr['info'] = '登录已失效,请重新登录!';
                }else if( isset($content['info']) ){
                    $reArr['flag'] = 'error';
                    $reArr['info'] = $content['info'];
                }
            }else{
                $reArr['flag'] = 'error';
                $reArr['info'] = '系统繁忙!请稍候再试!';
            }
        }
        echo json_encode($reArr);
    }
}