<div id="myModalRegister" class="reveal-modal-register" >
    <div class="news_back_btn"><a class="close-reveal-modal"><img alt="" border="0" src="<?php echo Yii::app()->baseUrl?>/images/back.gif" /></a></div>
    <div class="login_content">
        <p class="register_top pngFix">注册</p>
        <ul class="choosebank clearfix pad10">
            <li id="ban1" class="cur">
                <input type="radio" name="1" id="bank1" value="" class="radiobtn" checked="checked" />
                <label class="lab_top white12" for="bank1">手机注册</label>
            </li>
            <li id="ban2">
                <input type="radio" name="1" id="bank2" value="" class="radiobtn" />
                <label class="lab_top white12" for="bank2">邮箱注册</label>
            </li>
            <li id="ban3">
                <input type="radio" name="1" id="bank3" value="" class="radiobtn" />
                <label class="lab_top white12" for="bank3">个性注册</label>
            </li>
        </ul>
        <div class="bankbox">
            <div class="bankcon">
                <form action="<?php echo Yii::app()->createUrl('/user/register')?>" method="post" name="Register_phone" id="Register_phone">
                    <div class="mar_top20">
                    <input class="inputText" type="text" name="username" id="userPhone" placeholder="手机号" /><span class="sty_ts" id="phone_remark"></span></div>
                    <div class="mar_top20"><input class="inputText" type="password" name="password" id="phonePassword" placeholder="密码" /><span id="phone_password_remark" class="sty_ts"></span></div>
                        <div class="mar_top20"><input class="inputText" type="password" name="repassword" id="phonePasswordAgain" placeholder="确认密码" /><span id="phone_repassword_remark" class="sty_ts" ></span></div>
                           <input type="hidden" name="reg_type" id="phone_reg" value="1"/>
                               <input class="btnLogin mag_20" type="submit" onclick="return phoneCheck()" name="register_phone" id="register_phone" value="注册" />
                </form>
            </div>
            <div class="bankcon noneDisplay">
                <form action="<?php echo Yii::app()->createUrl('/user/register')?>" method="post" name="Register_email" id="Register_email">
                    <div class="mar_top20">
                    <input class="inputText margin_24" type="text" name="username" id="userEmail" placeholder="邮箱" /><span id="email_remark" class="sty_ts"></span></div>
                        <div class="mar_top20"><input class="inputText" type="password" name="password" id="emailPassword" placeholder="密码" /><span id="email_password_remark"  class="sty_ts"></span></div>
                            <div class="mar_top20"><input class="inputText" type="password" name="repassword" id="eamilPasswordAgain" placeholder="确认密码" /><span id="email_repassword_remark" class="sty_ts"></span></div>
                    <input type="hidden" name="reg_type" value="2"/>
                    <input class="btnLogin mag_20" type="submit" onclick="return emailCheck()"  name="register_email" id="register_email" value="注册" />
                </form>
            </div>
            <div class="bankcon noneDisplay">
                <form action="<?php echo Yii::app()->createUrl('/user/register')?>" method="post" name="Register_personality" id="Register_personality">
                    <div class="mar_top20"><input class="inputText margin_24" type="text" name="username" id="personalityName" placeholder="用户名" /><span id="username_remark" class="sty_ts" ></span></div>
                        <div class="mar_top20"><input class="inputText" type="password" name="password" id="personalityPassword" placeholder="密码" /><span id="username_password_remark" class="sty_ts"></span></div>
                            <div class="mar_top20"><input class="inputText" type="password" name="repassword" id="personalityPasswordAgain" placeholder="确认密码" /><span id="username_repassword_remark" class="sty_ts" ></span></div>
                    <input type="hidden" name="reg_type" value="3"/>
                    <input class="btnLogin mag_20" type="submit" name="login_in" id="login_in" value="注册" onclick="return usernameCheck()" />
                </form>
            </div>
        </div>

        <p class="pad_20"><a onClick="closeRegister();" href="javascript:void(0);" data-reveal-id="myModal" class="noNumber">已有帐号？立即登录</a></p>
    </div>
</div>
<script>
function phoneCheck(){
     var  reg= /^(13[0-9]{9})|(15[0-9][0-9]{8})$/;
    if( ! reg.test($('#userPhone').val())){
        $('#phone_remark').text('');
        $('#phone_remark').append('手机号码不合法');
        return false;
    }
    if($('#userPhone').val().length < 6){
        $('#phone_remark').text('');
        $('#phone_remark').append('不能少于六位');
        return false;
    }else{
        $('#phone_remark').text('');
    }

    if($('#phonePassword').val().length < 6){
        $('#phone_password_remark').text('');
        $('#phone_password_remark').append('不能少于六位');
        return false;
    }else{
        $('#phone_password_remark').text('');
    }

    if($('#phonePasswordAgain').val() != $('#phonePassword').val()){
        $('#phone_repassword_remark').text('');
        $('#phone_repassword_remark').append('密码不一致');
        return false;
    }else{
        $('#phone_repassword_remark').text('');
    }
}


function emailCheck(){
    var reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
    if( ! reg.test($('#userEmail').val())){
        $('#email_remark').text('');
        $('#email_remark').append('邮箱不合法');
        return false;
    }

    if($('#userEmail').val() == ''){
        $('#email_remark').text('');
        $('#email_remark').append('不能为空');
        return false;
    }else{
        $('#email_remark').text('');
    }


    if($('#emailPassword').val() == ''){
        $('#email_password_remark').text('');
        $('#email_password_remark').append('不能为空');
        return false;
    }else{
        $('#email_password_remark').text('');
    }

    if($('#eamilPasswordAgain').val() != $('#emailPassword').val()){
        $('#email_repassword_remark').text('');
        $('#email_repassword_remark').append('密码不一致');
        return false;
    }else{
        $('#email_repassword_remark').text('');
    }

}


function usernameCheck(){
    if($('#personalityName').val() == ''){
        $('#username_remark').text('');
        $('#username_remark').append('不能为空');
        return false;
    }else{
        $('#username_remark').text('');
    }

    if($('#personalityPassword').val() == ''){
        $('#username_password_remark').text('');
        $('#username_password_remark').append('不能为空');
        return false;
    }else{
        $('#username_password_remark').text('');
    }

    if($('#personalityPasswordAgain').val() != $('#personalityPassword').val()){
        $('#username_repassword_remark').text('');
        $('#username_repassword_remark').append('密码不一致');
        return false;
    }else{
        $('#username_repassword_remark').text('');
    }

}
</script>

