<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
</form>

<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/admin/finance/showlist/oid/<?php echo $oid; ?>" method="post">
        <div class="searchBar">
            <ul class="searchContent">
                <li id="search_channel_name" style="width: 280px;">
                    <label>游戏名称：</label>
                    <input class="required" name="game_name" type="text" value="<?php if(empty($game_name)): echo '请输入游戏名称'; else: echo $game_name; endif; ?>"/>
                </li>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">搜索</button></div></div></li>
            </ul>
        </div>
    </form>
</div>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add"  rel="finance_addEdit" href="/admin/finance/addedit/" target="navTab"><span>添加</span></a></li>
            <li><a class="edit" rel="finance_addEdit"href="/admin/finance/addedit/id/{finance_id}" target="navTab" warn="请选择一条数据再进行操作！"><span>修改</span></a></li>
            <li><a title="删除所选数据？" target="ajaxTodo" rel="ids" href="#"  class="delete" id="batchDel" onclick="return  batchDel();"><span>批量删除</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%" layoutH="140">
        <thead>
        <tr>
            <th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
            <th width="30" orderField="accountCert">编号</th>
            <th width="140">游戏名</th>
            <th width="100">游戏运营类型</th>
            <th width="50">游戏类型</th>
            <th width="150">渠道名</th>
            <th width="50">SDK接入</th>
            <!--
            <th width="100">分成比例</th>
            <th width="50">坏账承担比例</th>
            <th width="50">发票类型</th>
            <th width="50">发票费率</th>
            -->
            <th width="200">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($all)):
                foreach($all as $obj): ?>
      <tr target="finance_id" rel="<?php echo $obj->id ?>">
          <td><input name="ids" value="<?php echo $obj->id; ?>" type="checkbox"></td>
          <td ><?php echo $obj->id; ?></td><!--编号-->
          <td><?php echo $game_list[$obj->game_id]; ?></td><!--游戏名-->
          <td><?php echo $game_operate[$obj->operate_cat_id]; ?></td><!--游戏运营类型-->
          <td><?php echo $game_cat[$obj->game_cat_id]; ?></td><!--游戏类型-->
          <td><?php echo $obj->channel_name; ?></td><!--渠道名-->
          <td><?php echo $sdk[$obj->sdk]; ?></td><!--SDK接入-->
          <!--
          <td><?php $income_ratio_id=Pdf_proportion::getProportionById($obj->income_ratio_id);echo $income_ratio_id['proportion'];?></td>
          <td></td>
          <td><?php echo $invoice_type_list[$obj->invoice_type]; ?></td>
          <td><?php $invoice_ratio=Pdf_ratio::getRatioById($obj->invoice_ratio);echo $invoice_ratio['ratio']; ?></td>
          -->
          <td>
			  <a href='/admin/finance/addEditPay/finance_id/<?php echo $obj->id; ?>' target='navTab' rel='auto_edit'>添加充值记录</a>
              <a href='/admin/finance/showPayList/finance_id/<?php echo $obj->id; ?>' target='navTab' rel='auto_edit'>查看充值记录</a>
              <a href='/admin/finance/statementCreate/finance_id/<?php echo $obj->id; ?>' target='navTab'>创建财务报表</a>
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
	var strDUrl = '/admin/finance/delete/ids/';
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
