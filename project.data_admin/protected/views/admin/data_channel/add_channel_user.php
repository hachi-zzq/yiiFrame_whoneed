<style type="text/css">
    .pageFormContent label{
        width: 80px;
    }
</style>
<form action="" method="post" class="pageForm required-validate"  onsubmit="return iframeCallback(this, navTabAjaxDone);">
<div class="pageFormContent" layouth="10" >
<div class="unit">
    <label>用户名:</label>
    <input type="text" name="username" maxlength="20" class="required textInput valid">

</div>

<div class="unit">
    <label>密码:</label>
    <input type="text" name="password" maxlength="20">
</div>
    <input type="hidden" name="channel_id" id="channel_id" value="<?php echo $channel_id;?>" />
<dl class="nowrap">
    <dt>
        &nbsp;
    </dt>
    <dd>
        <input type="button" id="add_channel_user" value="保存" />
        &nbsp;&nbsp;
        <button type="button" class="close">
            取消
        </button>
    </dd>
</dl>
</div>
</form>
<script>
$(function(){
    $("#add_channel_user").on("click",function(){
        var username = $("input[name=username]").val();
        $.get("/admin/data_channel/ajaxCheckUserExists/username/"+username,function(data){
            data = eval('('+data+')');
            if(data.statusCode==200 && data.message==true){
                //如果是存在用户名,则提示用户
                alertMsg.confirm("用户已经存在,确认给其增加渠道权限?", {
                    okCall: function(){
                        form_submit();
                    }
                });
            }else{
                //否则,直接提交;
                form_submit();
            }

        })
    })
})

function form_submit(){
    var url = '/admin/data_channel/channelUserSave';
    $.ajax({
        "type":"GET",
        "url" :url,
        "data":$("form", navTab.getCurrentPanel()).serialize(),
        success:function(msg){
            msg=eval('('+msg+')');
            if(msg.statusCode==200){
                alertMsg.correct('操作成功');
                navTab.reload('/admin/data_channel/addChannelUser/channel_id/<?php echo $channel_id;?>');
            }else{
                alertMsg.error(msg.message);
            }
        }
    })
}
</script>