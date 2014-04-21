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
    private $token = 'patabom';
    private $accessToken = '';
    private $accessTokenExpires = '';
    private $accessTokenTime = '';
    private $appId = 'wxe408d22203bdbf9c';
    private $appSecret = '2561a50a3bb84f02ab82e768789e3a54';
    private $openId = '';
    private $userList = array();

    public function actionIndex(){
        if(isset($_GET['echostr'])){
            $this->valid();
        }else{
            $this->messageHandle();
        }
    }

    //消息处理
    public function messageHandle(){
        //验证消息真实性
        if($this->checkSignature()){
            //验证access_token
            $this->checkAccessToken();
            //获取到消息实体
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

            if( ! empty($postStr)){
                //将xml文件解释成对象
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                //消息类型
                $RX_TYPE = trim($postObj->MsgType);
                //openId
                $this->openId = trim($postObj->FromUserName);
                switch ($RX_TYPE)
                {
                    case "text":
                        $this->receiveText($postObj);
                        break;
                    case "image":
                        $this->receiveImage($postObj);
                        break;
                    case "location":
                        $resultStr = $this->receiveLocation($postObj);
                        break;
                    case "voice":
                        $resultStr = $this->receiveVoice($postObj);
                        break;
                    case "video":
                        $resultStr = $this->receiveVideo($postObj);
                        break;
                    case "link":
                        $resultStr = $this->receiveLink($postObj);
                        break;
                    case "event":
                        $this->receiveEvent($postObj);
                        break;
                    default:
                        $resultStr = "unknow msg type: ".$RX_TYPE;
                        break;
                }
//                echo $resultStr;
            }
        }else{
            echo '';
            exit;
        }
    }

    //首次验证
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    //验证消息合法性
    public function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = $this->token;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    //各种消息类型函数实现
    //文本消息
    private function receiveText($obj){
        //保存到库中
        Yii::app()->db_data_www->createCommand("insert into pdw_wx_message(to_user,from_user,message_type,content,create_time) values ('$obj->ToUserName','$obj->FromUserName','$obj->MsgType','$obj->Content','$obj->CreateTime')")->execute();
    }

    //图片消息
    private function receiveImage($obj){
        //保存到库中
//        $imgUrl = $obj->PicUrl;
//        $mediaId = $obj->MediaId;
//        $this->savePic($mediaId);

        $wx_message_model = new Pdw_wx_message();
        $wx_message_model->to_user = $obj->ToUserName;
        $wx_message_model->from_user = $obj->FromUserName;
        $wx_message_model->content = $obj->PicUrl;
        $wx_message_model->message_type = $obj->MsgType;
        $wx_message_model->create_time = $obj->CreateTime;
        $wx_message_model->save();
    }

    //地理位置
    private function receiveLocation($obj){

    }

    //声音
    private function receiveVoice($obj){

    }

    //视频
    private function receiveVideo($obj){

    }

    //链接
    private function receiveLink($obj){

    }

    //事件
    private function receiveEvent($obj){
        if($obj->Event == 'subscribe'){
            //关注
            $this->subscribe($obj);
        }elseif($obj->Event == 'unsubscribe'){
            //取消关注
            $this->unsubscribe();
        }
    }

    //回复实体（文本消息）被动自动回复
    private function transmitText($object, $content, $flag = 0)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>%d</FuncFlag>
</xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
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
        $responseApi = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$this->accessToken;
        MyFunction::get_url($responseApi,TRUE,$txt);
    }

    //上传图片到服务器
    private function uploadImg(){
        $uploadImgApi = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$this->accessToken.'&type=image';


    }

    //下载图片保存到本地
    public function savePic($media_id){
        $saveApi = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->accessToken.'&media_id='.$media_id;
        $res = MyFunction::get_url($saveApi);
        if($res['code'] == 200){
            return $res['content'];
        }else{
            return '';
        }
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
        $this->actionResponseText($contentStr,$this->openId);
        //将用户添加到本地库中
        $this->inserUser($this->openId);
    }


    //取消关注
    private function unsubscribe(){
        $this->deleteUser($this->openId);
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
                print_r($this->getWxUserInfo($user));

            }
            if($content->total > 10000 || $content->count > 10000){
                //第二次拉取
                $this->pullUserTwice($content->next_openid);
            }
        }
//         $this->actionGetUserInfoByOpenid();
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

    //删除本地用户
    private function deleteUser($openid){
//        Yii::app()->db_data_www->createCommand("delete from pdw_wx_user where openid='$openid'")->execute();
        $wx_user_model = Pdw_wx_user::model();
        return $wx_user_model->deleteAll("openid='$openid'")?TRUE:FALSE;
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