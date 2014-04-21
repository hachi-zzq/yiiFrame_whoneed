<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhu
 * Date: 14-2-7
 * Time: 下午4:21
 * To change this template use File | Settings | File Templates.
 *
 */
//微信公共平台开发
class WeixinController extends MyPageController{
    private $ptsId = 'gh_673f2bd71229';
    private $token = 'patabom';
    private $accessToken = '';
    private $accessTokenExpires = '';
    private $accessTokenTime = '';
    private $appId = 'wxe408d22203bdbf9c';
    private $appSecret = '2561a50a3bb84f02ab82e768789e3a54';
    private $openId = '';
    private $userList = array();

    public function actionIndex(){
        //获取用户列表
        //分页
        $page	= intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页
        $wx_user_model = Pdw_wx_user::model();
        $userCdb = new CDbCriteria();
        $count = $wx_user_model->count();
        $pager = new CPagination($count);
        $pager->pageSize=self::PAGE_SIZE;
        $pager->currentPage = $page;
        $pager->applyLimit($userCdb);
        $wxUsers = $wx_user_model->findAll($userCdb);
        //最近消息
        $wx_message_model = Pdw_wx_message::model();
        $arrMessage[] = array();
        foreach($wxUsers as $user){
            $cdb = new CDbCriteria();
            $cdb->condition = "from_user='$user->openid'";
            $cdb->order = 'id desc';
            $cdb->limit=1;
            $recent_message = $wx_message_model->find($cdb);
            $arrMessage[$user->openid] = array('msg_type'=>$recent_message->message_type,'content'=>$recent_message->content);
        }

        $data['all_user'] = $wxUsers;

        $data['recent_message'] = $arrMessage;
        $data['pager'] = $pager;
        $this->display('all_user',$data);
    }

    //发送消息
    public function actionSendText(){
        if(isset($_POST['action'])){
            $this->checkAccessToken();
            $content = Yii::app()->request->getParam('content');
            $openid = Yii::app()->request->getParam('openid');
            $message_type = Yii::app()->request->getParam('message_type');
            if($message_type=='text' && $this->actionResponseText($content,$openid)){
                $this->saveMessage($this->ptsId,$openid,$content,'text',time());
                $this->alert_ok();
            }elseif($message_type=='pic'){
                //上传服务器
                $media = $this->uploadImg('pic');
                if($this->sendImg($openid,$media['media_id'])){
                    $this->delete($media['localPath']);
                    $this->alert_ok();
                }else{
                    $this->alert_error();
                }
            }
        }
        $nick = Yii::app()->request->getParam('nick');
        $data['nick'] = $nick;
        $this->display('reply',$data);
    }

    //消息列表
    public function actionMessageList(){

        $openid = Yii::app()->request->getParam('openid');
        $nick = Yii::app()->request->getParam('nick');
        $wx_message_model = Pdw_wx_message::model();
        //分页
        $page	= intval(Yii::app()->request->getParam('pageNum')) - 1;	//	分页
        $cdb = new CDbCriteria();
        $cdb->condition = "from_user='$openid'";
        $count = $wx_message_model->count($cdb);
        $pager = new CPagination($count);
        $pager->pageSize=self::PAGE_SIZE;
        $pager->currentPage = $page;
        $pager->applyLimit($cdb);
        $user_message = $wx_message_model->findAll($cdb);
        $data['user_message'] = $user_message;
        $data['nick'] = $nick;
        $data['openid'] = $openid;
        $data['pager'] = $pager;
        $this->display('message_list',$data);
    }


    //消息保存到本地(发送的消息)
     public function saveMessage($from_user,$to_user,$content,$type,$create_time){
         $wx_message_model = new Pdw_wx_message();
         $wx_message_model->to_user = $to_user;
         $wx_message_model->from_user = $from_user;
         $wx_message_model->message_type = $type;
         $wx_message_model->content =$content;
         $wx_message_model->create_time = $create_time;
         $wx_message_model->save();
     }


    //回复(文本消息),手动回复，非自动回复
    public function actionResponseText($message,$openid){
        $txt = '{
                "touser":"'.$openid.'",
                "msgtype":"text",
                "text":
                {
                     "content":"'.$message.'"
                }
            }';
        return $this->send($txt);
    }

    public function send($data){
        $responseApi = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$this->accessToken;
        $res = MyFunction::get_url($responseApi,TRUE,$data);
        if($res['code'] == 200){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    //上传图片到服务器
    private function uploadImg($file){
        $this->checkAccessToken();
        $uploadImgApi = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$this->accessToken.'&type=image';
        if($_FILES){
            $realPath = $this->actionReturnRealPath($file);
        }
        $arrFile = array('media'=>'@'.$realPath);
        $res = MyFunction::get_url($uploadImgApi,TRUE,$arrFile);
        if($res['code'] == 200){
            $arrContent = json_decode($res['content'],TRUE);
            return array('media_id'=>$arrContent['media_id'],'localPath'=>$realPath);
        }else{
            return array();
        }
    }

    //发送图片消息
    public function sendImg($openId,$mediaId){
        $msg = '{
                "touser":"'.$openId.'",
                "msgtype":"image",
                "image":
                {
                  "media_id":"'.$mediaId.'"
                }
            }';
        return $this->send($msg);
    }

    //返回上传文件的绝对路径
      public function actionReturnRealPath($file){
        if($_FILES){
            $arrFile = $_FILES[$file];
            $tmp_name = $arrFile['tmp_name'];
            $ext = $this->getExt($arrFile['name']);
            $time = time();
            rename($tmp_name,WEB_ROOT.'/runtime/'.$time.'.'.$ext);
            return WEB_ROOT.'/runtime/'.$time.'.'.$ext;
        }else{
            return '';
        }
      }

    //删除本地暂存图片
     public function delete($filePath){
         @unlink($filePath);
     }

    //getExt文件扩展名
    public function getExt($fileName){
        return array_pop(explode('.',$fileName));
    }

    //关注微信
    public function subscribe($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "感谢您关注【极聚网络服务中心】"."\n"."微信号：ptb_cs";
                break;
            default :
                $contentStr = "Unknow Event: ".$object->Event;
                break;
        }
        $this->responseText($contentStr);
        //将用户添加到本地库中
        $this->inserUser($this->openId);
    }

    //获取所有关注用户
    public  function actionGetAllUser(){
        $this->checkAccessToken();
        $userListApi = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->accessToken;
        $res = MyFunction::get_url($userListApi);
        if($res['code'] == '200'){
            $content = json_decode($res['content']);
            foreach($content->data->openid as $user){
                array_push($this->userList,$user);
            }
            if($content->total > 10000 || $content->count > 10000){
                //第二次拉取
                $this->pullUserTwice($content->next_openid);
            }
        }
        return $this->userList;
    }

    //二次拉取
    private function pullUserTwice($nextOpendId){
        $this->checkAccessToken();
        $userListApi = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->accessToken.'&next_openid='.$nextOpendId;
        $res = MyFunction::get_url($userListApi);
        if($res['code'] == '200'){
            $content = json_decode($res['content']);
            foreach($content->data->openid as $user){
                array_push($this->userList,$user);
            }
            if($content->total > 10000 || $content->count > 10000){
                $this->pullUserTwice($content->next_openid);
            }

        }
    }

    //根据openid获取用户信息,拉取用户入库
    public  function actionGetUserInfoByOpenid(){
        $openList = $this->actionGetAllUser();
        foreach($openList as $openid){
            if( ! $this->inserUser($openid))
                continue;
        }
    }

    //单个用户入库
    private function inserUser($openid){
        $this->checkAccessToken();
        $wx_user_model = new Pdw_wx_user();
        $arrUserInfo = $this->getWxUserInfo($openid);
        if($arrUserInfo){
            $wx_user_model->subscribe = $arrUserInfo['subscribe'];
            $wx_user_model->openid = $arrUserInfo['openid'];
            $wx_user_model->nickname = $arrUserInfo['nickname'];
            $wx_user_model->sex = $arrUserInfo['sex'];
            $wx_user_model->city = $arrUserInfo['city'];
            $wx_user_model->country = $arrUserInfo['country'];
            $wx_user_model->province = $arrUserInfo['province'];
            $wx_user_model->language = $arrUserInfo['language'];
            $wx_user_model->headimgurl = $arrUserInfo['headimgurl'];
            $wx_user_model->subscribe_time = $arrUserInfo['subscribe_time'];
            return $wx_user_model->save()?TRUE:FALSE;
        }
    }

    //获取用户信息
    private function getWxUserInfo($openid){
        $this->checkAccessToken();
        $userInfoApi = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->accessToken.'&openid='.$openid.'&lang=zh_CN';
        $res = MyFunction::get_url($userInfoApi);
        if($res['code'] == 200 && !empty($res['content'])){
            return json_decode($res['content'],TRUE);
        }else{
            return '';
        }
    }

    //获取access_token
    private function getAccessToken(){
        $appid = $this->appId;
        $secret = $this->appSecret;
        $getAccessTokenApi = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
        $res = MyFunction::get_url($getAccessTokenApi);
        if($res['code'] == '200'){
            //请求成功
            $objContent = json_decode($res['content']);
            //保存access_token
            $this->accessToken = $objContent->access_token;
            //保存生成access_token的时间戳
            $this->accessTokenTime = time();
            //保存access_token有效时间
            $this->accessTokenExpires = $objContent->expires_in;
        }else{

        }

    }

    //验证access_token
    private function checkAccessToken(){
        if( empty($this->accessToken) || empty($this->accessTokenTime) || empty($this->accessTokenExpires)){
            $this->getAccessToken();
        }
    }


}