<style type="text/css">
    .pageFormContent label{
        width: 80px;
    }
</style>
<form action="/admin/data_channel/subSaveEditAdd" method="post" class="pageForm required-validate"  onsubmit="return iframeCallback(this, navTabAjaxDone);">
<div class="pageFormContent" layouth="10" >
<div class="unit">
    <label>
             父渠道名称;
    </label>
    <input type="text" name="channel_name" maxlength="20" readonly="readonly" value="<?php echo $fname;?>">

</div>
    <div class="unit">
        <label>
            子渠道名称;
        </label>
        <input type="text" name="sub_channel_name" maxlength="20" class="required textInput valid">
    </div>

    <div class="unit">
        <label>
            子渠道编号;
        </label>
        <input type="text" name="sub_id"> <span style="color: red;margin-left: 15px;line-height: 21px;">*如果不填写，自动递增</span>
    </div>
<input type="hidden" name="action" value="add_sub_channel">
<input type="hidden" name="fid" value="<?php echo $_GET['fid']?>">
<dl class="nowrap">
    <dt>
        &nbsp;
    </dt>
    <dd>
        <button type="submit">
            保存
        </button>
        &nbsp;&nbsp;
        <button type="button" class="close">
            取消
        </button>
    </dd>
</dl>
</div>

</form>