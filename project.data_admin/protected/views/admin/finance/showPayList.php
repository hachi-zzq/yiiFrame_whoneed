<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
</form>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="edit" href="/admin/finance/AddEditPay/id/{pay_recode_id}" target="navTab" warn="请选择一条数据再进行操作！"><span>修改</span></a></li>
            <li><a title="删除所选数据？" target="ajaxTodo" rel="ids" href="#"  class="delete" id="batchDel" onclick="return  batchDel();"><span>批量删除</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%" layoutH="140">
        <thead>
        <tr>
            <th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
            <th width="30" orderField="accountCert">编号</th>
            <th width="140">开始日期</th>
            <th width="100">结束日期</th>
            <th width="150">渠道名</th>
            <th width="50">充值金额</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($all)):
                foreach($all as $obj): ?>
          <tr target="pay_recode_id" rel="<?php echo $obj->id ?>">
              <td><input name="ids" value="<?php echo $obj->id; ?>" type="checkbox"></td>
              <td ><?php echo $obj->id; ?></td><!--编号-->
              <td><?php echo $obj->begin_time; ?></td><!--开始日期-->
              <td><?php echo $obj->end_time; ?></td><!--结束日期-->
              <td><?php $channel_list=Pdf_channel::getChannelList(); echo $channel_list[$obj->channel_id];?>
              </td><!--渠道名-->
              <td><?php echo $obj->amount; ?></td><!--充值金额-->
              <td>
                  <a href='/admin/finance/addEditPay/id/<?php echo $obj->id; ?>' target='navTab' rel='auto_edit'>查看</a>
              </td>
          </tr>
		<?php
                endforeach;
            endif;
        ?>
        </tbody>
    </table>

    <div class="panelBar">
		<div class="pages">
			<span>共<?php echo $pages->itemCount?>条</span>
		</div>		
		<div class="pagination" targetType="navTab" totalCount="<?php echo $pages->itemCount?>" numPerPage="<?php echo $pages->pageSize?>" pageNumShown="10" currentPage="<?php echo $pages->currentPage + 1?>"></div>
	</div>
</div>
<script>
function batchDel(){
	var strDUrl = '/admin/finance/delPay/ids/';
	var strIds = '';
	
	/*
	$("input[name='ids'][checked]", navTab.getCurrentPanel()).each(function(){
		strIds += strIds == '' ? $(this).val() : ',' + $(this).val() ;
		alert('');
	});
	*/
	var obj = document.getElementsByName("ids");
	for(var i = 0; i < obj.length; i++) 
	{ 
		if(obj[i].checked){ 
			strIds += strIds == '' ? obj[i].value : ',' + obj[i].value ;
		} 
	}

	strDUrl += strIds;
	$('#batchDel', navTab.getCurrentPanel()).attr("href", strDUrl);

	return true;
}
</script>
