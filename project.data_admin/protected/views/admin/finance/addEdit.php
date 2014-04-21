<div class="pageContent">
	<form action="/admin/finance/save" method="post" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="10">
                    <div class="unit">
                        <label>游戏名：</label>
                        <select name='game_id'>
                            <?php foreach(PataBomProject::funGetGameList() as $key=>$val): ?>
                            <option value='<?php echo $key ?>' <?php if(isset($objDb->game_id) && $objDb->game_id==$key): echo 'selected'; endif; ?>><?php echo $val ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="unit">
                        <label>游戏运营类型:</label>
                        <?php foreach(Pdf_finance::$operate_cat as $key=>$val): ?>
                        <input type="radio" name="operate_cat_id" value='<?php echo $key ?>' <?php if(isset($objDb->operate_cat_id) && $objDb->operate_cat_id==$key): echo 'checked="checked"'; endif; ?> ><?php echo $val ?></input>
                        <?php endforeach; ?>
                    </div>
                    <div class="unit">
                        <label>游戏类型:</label>
                        <?php foreach(Pdf_finance::$game_cat_list as $key=>$val): ?>
                        <input type="radio" name="game_cat_id" value='<?php echo $key ?>' <?php if(isset($objDb->game_cat_id) && $objDb->game_cat_id==$key): echo 'checked="checked"'; endif; ?> ><?php echo $val ?></input>
                        <?php endforeach; ?>
                    </div>
                    <div class="unit">
                        <label>渠道名(公司名):</label>
                        <input type='text' size='30' name='channel_name' value='<?php if(isset($objDb->channel_name)): echo $objDb->channel_name; endif; ?>' />
                    </div>
                    <div class="unit">
                        <label>SDK接入:</label>
                            <?php foreach(Pdf_finance::$sdk as $key=>$val): ?>
                            <input type="radio" name="sdk" value='<?php echo $key ?>' <?php if(isset($objDb->sdk) && $objDb->sdk==$key): echo 'checked="checked"'; endif; ?> ><?php echo $val ?></input>
                            <?php endforeach; ?>
                    </div>
                    <div class="unit">
                        <label>分成比例:</label>
                        <select class="combox" name="income_type" ref="addeidt_income_type_radio" refUrl="/admin/finance/ajaxGetIncomeProportionByType/type_id/{value}">
                          <option value="0">请选择分成方式</option>
                          <?php foreach(Pdf_proportion::$proportion_type as $key=>$val): ?>
                                  <option value='<?php echo $key ?>' <?php if(isset($objDb->income_ratio_id) && 
                                  ($income_ratio_id = Pdf_proportion::getProportionById($objDb->income_ratio_id)) && $income_ratio_id['type']==$key): echo 'selected'; endif; ?> ><?php echo $val ?></option>
                          <?php endforeach; ?>
                        </select>
                        <select class="combox" name="income_ratio_id" id="addeidt_income_type_radio">
                              <option value="0">请选择费率</option>
                              <?php if( isset($objDb->income_ratio_id) && isset($income_ratio_id['type']) ):
                                        foreach(Pdf_proportion::getProportionList($income_ratio_id['type']) as $key=>$val): ?>
                                            <option value='<?php echo $key ?>' <?php if(isset($objDb->income_ratio_id) && $objDb->income_ratio_id==$key): echo 'selected'; endif; ?> ><?php echo $val ?></option>
                                  <?php endforeach;
                                    endif; ?>
                        </select>
                    </div>
                    <div class="unit">
                        <label>支付渠道/费率</label>
                        <div style="float:left">
                            <ul><?php if( isset($objDb->id) && $channel_ratio=Pdf_finance_channel::getChannelAndRatio($objDb->id) ): ?>
                                <?php foreach($channel_ratio as $k=>$val): ?>
                                    <li><input type="hidden" name="channel_ratio_id[]" value="<?php echo $k; ?>" />
                                    <select name="channel_id[]">
                                        <?php foreach(Pdf_channel::getChannelList() as $key=>$value): ?>
                                            <option value='<?php echo $key ?>' <?php if($val['channel_id']==$key): echo 'selected'; endif; ?> ><?php echo $value ?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <select name="ratio_id[]">
                                        <?php foreach(Pdf_ratio::getRatioList() as $value): ?>
                                            <?php foreach($value as $ratio_id=>$ratio_val): ?>
                                                <option value='<?php echo $ratio_id ?>' <?php if($val['ratio_id']==$ratio_id): echo 'selected'; endif; ?> ><?php echo $ratio_val ?></option>
                                            <?php endforeach;?>
                                        <?php endforeach;?>
                                    </select>
                                    <input class="channel_ratio_del" type="button" title="/admin/finance/channelRatioDel/cr_id/<?php echo $k; ?>" onclick="return channel_ratio_del(this);" value="删除" />
                                    </li>
                                <?php endforeach;?>
                            <?php endif;?>
                                <li class="channel_ratio_add"></li>
                            </ul>
                            <input type="button" onclick="return channel_ratio_add(this);" value="添加 支付渠道/费率" />
                        </div>
                    </div>
                    <div class="unit">
                        <label>发票类型:</label>
                            <?php foreach(Pdf_finance::$invoice_type_list as $key=>$val): ?>
                            <input type="radio" name="invoice_type" value='<?php echo $key ?>' <?php if(isset($objDb->invoice_type) && $objDb->invoice_type==$key): echo 'checked="checked"'; endif; ?> ><?php echo $val ?></input>
                            <?php endforeach; ?>
                    </div>
                    <div class="unit">
                        <label>发票费率:</label>
                        <select  name='invoice_ratio'>
                            <option value='0'>请选择发票费率</option>
                            <?php foreach(Pdf_ratio::getRatioList(1) as $key=>$val): ?>
                            <option value='<?php echo $key ?>' <?php if(isset($objDb->invoice_ratio) && $objDb->invoice_ratio==$key): echo 'selected'; endif; ?> ><?php echo $val ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="unit">
						<td colspan=2>
								<button type='submit'>保存</button>&nbsp;&nbsp;<button type='button' class='close'>取消</button>
						</td>
                    </div>
		    <input type='hidden' name='finance_id' value="<?php if( isset($objDb->id) ): echo $objDb->id; endif; ?>" />
        </div>
    </form>
</div>
<script type="text/javascript">
function channel_ratio_add(e){
	//增加一行数据,包括删除按钮
    var html='<li><input type="hidden" name="channel_ratio_id[]" value="" />'
            +   '<select name="channel_id[]">'
            +       '<?php foreach(Pdf_channel::getChannelList() as $key=>$value): ?>'
            +           '<option value="<?php echo $key ?>"><?php echo $value ?></option>'
            +       '<?php endforeach;?>'
            +   '</select>'
            +   '<select name="ratio_id[]">'
            +       '<?php foreach(Pdf_ratio::getRatioList() as $value): ?>'
            +           '<?php foreach($value as $ratio_id=>$ratio_val): ?>'
            +               '<option value="<?php echo $ratio_id ?>"><?php echo $ratio_val ?></option>'
            +           '<?php endforeach;?>'
            +       '<?php endforeach;?>'
            +   '</select>'
            +   '<input class="channel_ratio_del" type="button" title="/admin/finance/channelRatioDel/" onclick="return channel_ratio_del(this);" value="删除" />'
            +'</li>';
    $(e).prev().append(html);
}

function channel_ratio_del(e){
    if(confirm("此删除立即失效,确定要删除吗?")){
        var type=$(e).attr("type") ;
        var url=$(e).attr("title");
        $.get(url,function(msg){
            msg=eval("("+msg+")");
            if(msg.statusCode==200){
                $(e).parent().remove();
            }
        });
        return true;
    }else 
        return false;
}
</script>