<div class="pageContent">
	<form action="/admin/finance/savePay" method="post" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="10">
            <input type='hidden' name='pay_recode_id' value="<?php if(isset($obj->id)):echo $obj->id; endif; ?>" />
            <input type='hidden' name='finance_id' value="<?php if(isset($finance_id)): echo $finance_id;endif;?>" />
            <div class="unit">
                <label>开始日期</label>
                <input type='text' format='yyyy-MM-dd' name='begin_time' class='date' size="10" value='<?php if(isset($obj->begin_time)): echo $obj->begin_time; else: echo date('Y-m-d'); endif;?>'  />
            </div>
            <div class="unit">
                <label>结束日期</label>
                <input type='text' format='yyyy-MM-dd' name='end_time' class='date' size="10" value='<?php if(isset($obj->end_time)): echo $obj->end_time; else: echo date('Y-m-d'); endif;?>'  />
            </div>
            <div class="unit">
                <label>充值渠道</label>
                <select name="channel_id">
                    <?php foreach($channel as $val): ?>
                        <option value='<?php echo $val['id']; ?>' <?php if($obj->channel_id==$val['id']): echo 'selected'; endif; ?> ><?php echo $val['name']; ?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="unit">
                <label>充值金额</label>
                <input type="text" name="amount" value="<?php if(isset($obj->amount)): echo $obj->amount; endif; ?>">
            </div>
            <!--<div class="unit">
                <label>坏账金额</label>
                <input type="text" name="bad_debt" value="<?php if(isset($obj->bad_debt)): echo $obj->bad_debt; endif; ?>">
            </div>-->
            <div class="unit">
                <button type='submit'>保存</button>&nbsp;&nbsp;<button type='button' class='close'>取消</button>
            </div>
        </div>
    </form>
</div>