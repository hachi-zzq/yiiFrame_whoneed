<!--修改密码-->
<div id="con_zzjs_1" >
    <form action="<?php echo Yii::app()->createUrl('/user/changepassword')?>" method="post" name="changePassword" id="changePassword" onsubmit="return changeCheck()">                   <label> 原&nbsp;密&nbsp;码:</label>
        <input class="inputText_pe" type="password" name="originalPassword" id="originalPassword" />
        <label>请输入原来的密码</label>
        <br />
        <br />
        <label> 新&nbsp;密&nbsp;码:</label>
        <input class="inputText_pe" type="password" name="newPassword" id="newPassword" />
        <label>请输入6~16位任意字符的密码</label>
        <br />
        <br />
        <label> 确认密码:</label>
        <input class="inputText_pe" type="password" name="againNewPassword" id="againNewPassword" oninput="checkRePass(this.value,$('#newPassword').val())"/><span id="re_span"></span>
        <label id="re_lab">请再次输入新设定的密码</label>
        <br />
        <br />
        <input class="btnLogin_person mag_left83" type="submit" value="确认修改" name="changePwd" id="changePwd" />
    </form>
</div>
<script>
    function checkRePass(rePass,pass){
        if(rePass != pass){
            var no = '<span style="color: red;font-size: 15px;">×不一致</span>';
            $('#re_lab').hide();
            $('#re_span').text('');
            $('#re_span').append(no);
        }else{
            var yes = '<span style="color: #ffffff;font-size: 15px;">√</span>';
            $('#re_lab').hide();
            $('#re_span').text('');
            $('#re_span').append(yes);
        }
    }

</script>