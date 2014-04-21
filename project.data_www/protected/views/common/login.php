<script src="<?php echo Yii::app()->baseUrl.'/js/json2.js'?>"></script>
<div id="myModal"  class="reveal-modal" >
    <div class="news_back_btn"><a class="close-reveal-modal"><img alt="" border="0" src="<?php echo Yii::app()->baseUrl?>/images/back.gif" /></a></div>
    <div class="login_content">
        <form action="" method="post" name="Login" id="Login">
            <p class="login_top pngFix">登录</p>
            <div class="mar_top20">
            <input class="inputText"type="text" name="username" id="userName" placeholder="用户名" /><label id="remark_username" class="sty_ts"></label></div>
            <div class="mar_top20">
            <input class="inputText" type="password" name="password" id="userPassword" placeholder="密码" /><label class="sty_ts" id="remark_password" class="sty_ts"></label></div>
            <div class="pad10">
                <input type="checkbox" name="remember" id="remember" value="0" onclick="doCheckBox(this)" /><span class="white12 pad_left10">记住密码</span>
            </div>

            <div style="height:40px;padding-top:10px">
                <input class="btnLogin" type="button" onclick="loginSend()" name="login_in" id="login_in" value="登录" />

                <a class="white12 fgt_pass" href="#">忘记密码？</a> </div>
            <p class="pad_20"><a href="javascript:void(0);" data-reveal-id="myModalRegister" class="noNumber" onClick="closeLogin();">还没帐号？立即注册</a></p>
        </form>
    </div>
</div>
<script>
    function loginSend(){
        formData = 'username='+$('#userName').val()+'&'+'password='+$('#userPassword').val()+'&remember='+$('#remember').val();
        $.ajax({
            data:formData,
            type:'POST',
            url:"<?php echo '/user/login'?>",
            success:function(res){
                res = JSON.parse(res);
              if(res.status == 'empty'){
                  $('#remark_username').text('');
                  $('#remark_password').text('');
                  if(res.remark == 'username'){
                     $('#remark_username').append(res.message);
                  }else if(res.remark == 'password'){
                      $('#remark_password').append(res.message);
                  }
              }else if(res.status == 'error'){
                  $('#remark_username').text('');
                  $('#remark_password').text('');
                  $('#remark_password').append(res.message);
              }else if(res.status == 'ok'){
                  window.location.href = "<?php echo Yii::app()->createUrl('user/filledinfo')?>";
              }
            },
            error:function(){
//                console.log('ajax error');
            }
        })
    }
    //checkbox
    function doCheckBox(obj){
        if(obj.checked){
            obj.value = 1;
        }else{
            obj.value = 0;
        }
    }

    if (document.addEventListener) {
        //如果是Firefox
        document.addEventListener("keypress", enterEvent, true);
    } else {
        //如果是IE
        document.attachEvent("onkeypress", enterEvent);
    }
    function enterEvent(evt) {
        if (evt.keyCode == 13) {
            $('#login_in').click();
        }
    }
</script>
