<style type="text/css">
    .pageFormContent label{
        width: 80px;
    }
</style>
<form action="/admin/channel/addEdit" method="post" class="pageForm required-validate"  onsubmit="return iframeCallback(this, navTabAjaxDone);">
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
        <label>游戏选择:</label>
        <input class="required" name="district.game_name" type="text" onclick="$('#game_back').click()" readonly="readonly"/>
        <input class="required" name="district.id" type="hidden" readonly="readonly"/>
        <a class="btnLook" id="game_back" href="/admin/channel/gameBack" lookupGroup="district">查找带回</a>
    </div>
    <div class="unit">
        <label>视图名称id:</label>
        <input type="text" name="view_name" maxlength="20" />
    </div>
    <input type="hidden" name="fid" value="0">
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