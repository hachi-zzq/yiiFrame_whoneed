<style type="text/css">
    .pageFormContent label{
        width: 80px;
    }
</style>
<form action="/admin/channel/addEdit" method="post" class="pageForm required-validate"  onsubmit="return iframeCallback(this, navTabAjaxDone);">
    <div class="pageFormContent" layouth="10" >
        <div class="unit">
            <label>
                   父渠道名称;
            </label>
            <label>
                <?php echo $one['channel_name']?>
            </label>

        </div>

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
            <label><input type="radio" name="channel_type" value="CPA" <?php if($one['channel_type']=='CPA') echo 'checked'?>>CPA</label>
            <label><input type="radio" name="channel_type" value="CPC"<?php if($one['channel_type']=='CPC') echo 'checked'?>>CPC</label>
            <label><input type="radio" name="channel_type" value="CPT"<?php if($one['channel_type']=='CPT') echo 'checked'?>>CPT</label>
            <label><input type="radio" name="channel_type" value="CPL"<?php if($one['channel_type']=='CPL') echo 'checked'?>>CPL</label>
            <label><input type="radio" name="channel_type" value="CPM"<?php if($one['channel_type']=='CPM') echo 'checked'?>>CPM</label>

        </div>

        <div class="unit">
            <label>
                渠道归属;
            </label>
            <label><input type="radio" name="channel_from" value="1" <?php if($one['channel_from']=='1') echo 'checked'?>>外部流量</label>
            <label><input type="radio" name="channel_from" value="2" <?php if($one['channel_from']=='2') echo 'checked'?>>自由流量</label>
            <label><input type="radio" name="channel_from" value="3" <?php if($one['channel_from']=='3') echo 'checked'?>>SEM</label>

        </div>

        <div class="unit">
            <label>
                子渠道参数;
            </label>
            <label><input type="radio" name="channel_child_param" value="0" <?php if($one['channel_child_param']=='0') echo 'checked'?>>子渠道ID</label>
            <label><input type="radio" name="channel_child_param" value="1" <?php if($one['channel_child_param']=='1') echo 'checked'?>>子渠道名</label>

        </div>

        <div class="unit">
            <label>
                是否合作:
            </label>
            <label><input type="radio" name="is_cooperation" value="1"<?php if($one['is_cooperation']=='1') echo 'checked'?>>是</label>
            <label><input type="radio" name="is_cooperation" value="0" <?php if($one['is_cooperation']=='0') echo 'checked'?>>否</label>

        </div>
        <input type="hidden" name="fid" value="<?php echo $one['id']?>">
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