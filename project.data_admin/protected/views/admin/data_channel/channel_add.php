<style type="text/css">
    .pageFormContent label{
        width: 80px;
    }
</style>
<form action="/admin/data_channel/addEdit" method="post" class="pageForm required-validate"  onsubmit="return iframeCallback(this, navTabAjaxDone);">
<div class="pageFormContent" layouth="10" >
<div class="unit">
    <label>
             渠道名称;
    </label>
    <input type="text" name="channel_name" maxlength="20" class="required textInput valid">

</div>

<div class="unit">
    <label>
        渠道类型;
    </label>
    <label><input type="radio" name="channel_type" value="CPA" checked="checked">CPA</label>
    <label><input type="radio" name="channel_type" value="CPC">CPC</label>
    <label><input type="radio" name="channel_type" value="CPT">CPT</label>
    <label><input type="radio" name="channel_type" value="CPL">CPL</label>
    <label><input type="radio" name="channel_type" value="CPM">CPM</label>
    <label><input type="radio" name="channel_type" value="CPS">CPS</label>

</div>

<div class="unit">
    <label>
        渠道归属;
    </label>
    <label><input type="radio" name="channel_from" value="1" checked="checked">广告</label>
    <label><input type="radio" name="channel_from" value="2">合作渠道</label>

</div>

<div class="unit">
    <label>
          子渠道参数;
    </label>
    <label><input type="radio" name="channel_child_param" value="0" checked="checked">子渠道ID</label>
    <label><input type="radio" name="channel_child_param" value="1">子渠道名</label>

</div>

    <div class="unit">
        <label>
                 是否合作:
        </label>
        <label><input type="radio" name="is_cooperation" value="1" checked="checked">是</label>
        <label><input type="radio" name="is_cooperation" value="0">否</label>

    </div>
    <div class="unit">
        <label>
                 是否跳转:
        </label>
        <label><input type="radio" name="is_redirect" value="0" checked="checked">否</label>
        <label><input type="radio" name="is_redirect" value="1">是</label>
    </div>
    <div class="unit">
        <label>视图名称id:</label>
        <input type="text" name="view_name" maxlength="20" />
    </div>
    <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']?>">
    <input type="hidden" name="action" value="add_channel">
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