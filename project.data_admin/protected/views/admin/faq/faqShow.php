<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
</form>

<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/admin/faq/faqshow/" method="post">
        <div class="searchBar">
            <ul class="searchContent">
                <li id="search_channel_name" style="width: 280px;">
                    <label>问题名称:</label><input class="required" name="faq_question" type="text" value="<?php if(!empty($search['faq_question'])): echo $search['faq_question']; endif; ?>"/>
                </li>
                <li><select id="show_fid_change" name="type_fid">
                      <option value="0">请选择类型</option>
                      <?php foreach($fid_list as $key=>$val): ?>
                              <option value='<?php echo $key ?>' <?php if(isset($search['type_fid']) && $search['type_fid']==$key ): echo 'selected'; endif; ?> ><?php echo $val ?></option>
                      <?php endforeach; ?>
                    </select>
                    <span id="show_son_type">
                    <?php if( !empty($search['type_id']) && !empty($son_list)): ?>
                        <select name="type_id">
                            <?php foreach($son_list as $key=>$val): ?>
                                <option value="<?php echo $key; ?>" <?php if( isset($search['type_id'])&&$search['type_id']==$key ): echo 'selected';endif; ?>><?php echo $val;?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif;?>
                    </span>
                </li>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
            </ul>
        </div>
    </form>
</div>
<script>
    $("#show_fid_change").on('change',function(){
        $("#show_son_type").html('');
        var type_fid = $("#show_fid_change").val();
        $.get("/admin/faq/ajaxGetSonList/type_fid/"+type_fid,function(msg){
            msg=eval('('+msg+')');
            if(msg.statusCode==200){
                if(msg.data){
                    var html = '<select name="type_id">';
                    for(i in msg.data){
                        html+='<option value="'+i+'">'+msg.data[i]+'</option>';
                    }
                    $("#show_son_type").html(html);
                }
            }
        })
    })
</script>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" href="/admin/faq/faqAddEdit/" target="navTab"><span>添加</span></a></li>
            <li><a class="edit" href="/admin/faq/faqAddEdit/faq_id/{faq_id}" target="navTab" warn="请选择一条数据再进行操作！"><span>修改</span></a></li>
            <li><a title="删除所选数据？" target="ajaxTodo" rel="ids" href="#"  class="delete" id="batchDel" onclick="return  batchDel();"><span>批量删除</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%" layoutH="140">
        <thead>
        <tr>
            <th width="30"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
            <th width="30" orderField="accountCert">编号</th>
            <th width="50">问题类型</th>
            <th width="200">问题标题</th>
            <th width="50">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($all)):
                foreach($all as $obj): ?>
      <tr target="faq_id" rel="<?php echo $obj->id ?>">
          <td><input name="ids" value="<?php echo $obj->id; ?>" type="checkbox"></td>
          <td ><?php echo $obj->id; ?></td><!--编号-->
          <td><?php echo $id_list[$obj->type_id] ?></td><!--问题类型-->
          <td><?php echo $obj->question; ?></td><!--问题标题-->
          <td>
			  <a href='/admin/faq/faqAddEdit/faq_id/<?php echo $obj->id; ?>' target='navTab' rel='auto_edit'>查看</a>
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
	var strDUrl = '/admin/faq/FaqDelete/ids/';
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
