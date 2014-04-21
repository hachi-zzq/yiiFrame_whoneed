<form action="/admin/channel/channelPayEdit" method="post" class="pageForm required-validate"  onsubmit="return iframeCallback(this, navTabAjaxDone);">
    <div class="pageFormContent" layouth="10" >
        <div class="unit">
            <label>
                开始日期：
            </label>

            <input style="margin-right: 10px;margin-left: 5px;" type="text" size="25" name="record_begin_date"  value="<?php echo $objCost->record_begin_date?>" readonly="readonly"/>
            　　　

        </div>
        <div class="unit">
            <label>
                结束日期：
            </label>

            <input style="margin-right: 10px;margin-left: 5px;" type="text" size="25" name="record_end_date"  value="<?php echo $objCost->record_end_date?>" readonly="readonly"/>
            　　　

        </div>
        <div class="unit">
            <label>
                渠道名称：
            </label>
            <?php
                $channelName = Pdc_channel::getNameById($objCost->channel_id);
            ?>
            <label><input  type="text" size="25" name="channel_name"   value="<?php echo $channelName?>" readonly="readonly"/></label>

        </div>

        <div class="unit">
            <label>
                付费金额:
            </label>
            <label><input  type="text" size="25" name="channel_cost"   value="<?php echo $objCost->cost?>" /></label>

        </div>

        <input type="hidden" name="action" value="channel_pay_edit">
        <input type="hidden" name="id" value="<?php echo $objCost->id?>">
        <input type="hidden" name="channel_from" value="<?php echo $_GET['channel_from']?>">
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