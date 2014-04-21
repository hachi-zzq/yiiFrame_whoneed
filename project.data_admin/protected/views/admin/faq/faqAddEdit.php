<div class="pageContent">
	<form action="/admin/faq/faqSave" method="post" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="10">
            <div class="unit">
                <label>FAQ类型：</label>
                <select  id="addedit_fid_change" name='type_fid'>
                    <option value="0" >请选择类型</option>
                    <?php foreach($fid_list as $key=>$val): ?>
                    <option value='<?php echo $key ?>' <?php if(isset($objDb->type_id) && ($objDb->type_id==$key || $type_fid==$key)): echo 'selected'; endif; ?>><?php echo $val ?></option>
                    <?php endforeach; ?>
                </select>
                <div id="addedit_son_type">
                <?php if( !empty($type_fid) && !empty($son_list)): ?>
                    <select name="type_id">
                        <?php foreach($son_list as $key=>$val): ?>
                            <option value="<?php echo $key; ?>" <?php if( isset($objDb->type_id)&&$objDb->type_id==$key ): echo 'selected';endif; ?>><?php echo $val;?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif;?>
                </div>
            </div>
            <div class="unit">
                <label>问题:</label>
                <input type="text" size="100" maxlength="255" name="question" value="<?php if(isset($objDb->question)): echo $objDb->question; endif; ?>" />
            </div>
            <div class="unit">
                <label>问题描述</label>
                <textarea class="editor" name="answer" rows="10" cols="120"   upImgUrl="/uploadFile.php" upImgExt="jpg,jpeg,gif,png"><?php if( isset($objDb->answer) ): echo $objDb->answer; endif; ?></textarea>
            </div>
            <div class="unit">
                <label>视频：</label>
                <input type="file" name="video" class='textInput' />
                <?php if( !empty($objDb->video) ): ?><a href='<?php echo Yii::app()->params['img_domain'].'/'.$objDb->video; ?>' target='_blank'><font color=red>下载</font></a><?php echo Yii::app()->params['img_domain'].'/'.$objDb->video; endif;?>
            </div>
            <div class="unit">
                <td colspan=2>
                        <button type='submit'>保存</button>&nbsp;&nbsp;<button type='button' class='close'>取消</button>
                </td>
            </div>
		    <input type="hidden" name="faq_id" value="<?php if( isset($objDb->id) ): echo $objDb->id; endif; ?>" />
        </div>
    </form>
</div>
<script>
    $("#addedit_fid_change").on('change',function(){
        $("#addedit_son_type").html('');
        var type_fid = $("#addedit_fid_change").val();
        $.get("/admin/faq/ajaxGetSonList/type_fid/"+type_fid,function(msg){
            msg=eval('('+msg+')');
            if(msg.statusCode==200){
                if(msg.data){
                    var html = '<select name="type_id">';
                    for(i in msg.data){
                        html+='<option value="'+i+'">'+msg.data[i]+'</option>';
                    }
                    $("#addedit_son_type").html(html);
                }
            }
        })
    })
</script>