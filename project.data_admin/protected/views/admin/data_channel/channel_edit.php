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
            <input type="text" name="channel_name" maxlength="20" class="required textInput valid" value="<?php echo !empty($one)?$one['channel_name']:''?>">

        </div>
        <div class="unit">
            <label>
                      所属产品:
            </label>
            <select  name="product_id">
                <?php
                    $objProduct = Pdcc_product::model()->findAll();
                    if($objProduct){
                        foreach($objProduct as $product){
                ?>
                <option value="<?php echo $product['id']?>" <?php if($one['product_id'] == $product['id']) echo "selected"?>><?php echo $product['appname']?></option>
                <?php
                        }
                    }
                ?>
            </select>

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
            <label><input type="radio" name="channel_type" value="CPS"<?php if($one['channel_type']=='CPS') echo 'checked'?>>CPS</label>

        </div>

        <div class="unit">
            <label>
                渠道归属;
            </label>
            <label><input type="radio" name="channel_from" value="1" <?php if($one['channel_from']=='1') echo 'checked'?>>广告</label>
            <label><input type="radio" name="channel_from" value="2" <?php if($one['channel_from']=='2') echo 'checked'?>>合作渠道</label>

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
        <div class="unit">
            <label>是否跳转:</label>
            <label><input type="radio" name="is_redirect" value="0" <?php if($one['is_redirect']=='0') echo 'checked'?>>否</label>
            <label><input type="radio" name="is_redirect" value="1" <?php if($one['is_redirect']=='1') echo 'checked'?>>是</label>
        </div>

        <div class="unit">
            <label>视图名称:</label>
            <input type="text" name="view_name" value="<?php echo $one['view_name']; ?>" maxlength="20" />
        </div>
        <input type="hidden" name="id" value="<?php echo $one['id']?>">
        <input type="hidden" name="action" value="edit_channel">
<!--        <input type="hidden" name="product_id" value="--><?php //echo $_GET['product_id']?><!--">-->

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