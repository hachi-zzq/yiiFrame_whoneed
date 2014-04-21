<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
</form>

<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <!--        <li><a class="add" href="demo_page4.html" target="navTab"><span>添加</span></a></li>-->
            <li><a title="此操作将删除该渠道下的所有子渠道！！谨慎操作" target="ajaxTodo" rel="ids" href="#"  class="delete" id="batchDel" onclick="return  batchDel();"><span>批量删除</span></a></li>
            <!--        <li><a title="确实要删除这些记录吗?" target="selectedTodo" rel="ids" postType="string" href="demo/common/ajaxDone.html" class="delete"><span>批量删除逗号分隔</span></a></li>-->
            <li><a class="edit" href="/admin/channel/showEdit?id={sid_user}" target="navTab" warn="请选择一个用户"><span>修改</span></a></li>
            <li class="line">line</li>
            <!--        <li><a class="icon" href="demo/common/dwz-team.xls" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>-->
        </ul>
    </div>
    <table class="table" width="1200" layoutH="138">
        <thead>
        <tr >
            <th width="22"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
            <th width="120" orderField="accountNo">编号</th>
            <th orderField="accountName">收件人</th>
            <th width="280" orderField="accountType">标题</th>
            <th width="430" orderField="accountCert">内容</th>
            <th width="100" align="center" orderField="accountLevel">发送时间</th>
            <th width="70" >操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($all) && !empty($all)){
            foreach($all as $v){
                ?>

                <tr target="sid_user" rel="<?php echo $v['id']?>">
                    <td><input name="ids" value="<?php echo $v['id']?>" type="checkbox"></td>
                    <td><?php echo $v['id']?></td>
                    <td><?php echo $v['user_name']?></td>
                    <td><?php echo $v['title']?></td>
                    <td><?php echo $v['content']?></td>
                    <td><?php echo $v['send_time']?></td>
                    <td>
                        <div>
                            <a title="删除" target="ajaxTodo" href="/admin/inner_letter/delete?id=<?php echo $v['id']?>" class="btnDel">删除</a>
                            <a title="编辑" target="navTab" href="/admin/inner_letter/showEdit?id=<?php echo $v['id']?>" class="btnEdit">编辑</a>
                        </div>
                    </td>
                </tr>
            <?php
            }
        }
        ?>
        </tbody>
    </table>

    <div class="panelBar">
        <div class="pages">
            <span>显示</span>
            <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
                <option value="20">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
            </select>
            <span>条，共<?php echo $page->itemCount?>条</span>
        </div>

        <div class="pagination" targetType="navTab" totalCount="<?php echo $page->itemCount?>" numPerPage="<?php echo $page->itemCount ?>" pageNumShown="10" currentPage="<?php echo $pages->currentPage+1?>"></div>

    </div>
</div>
<script>
    function batchDel(){
        var strDUrl = '/admin/channel/multiDelete/ids/';
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
//        $('#batchDel', navTab.getCurrentPanel()).attr("href", strDUrl);
        $('#batchDel').attr('href',strDUrl);

        return true;
    }
</script>
<script type="text/javascript">
    function ConfirmMsg(url, data){
        alertMsg.confirm("您修改的资料未保存，请选择保存或取消！", {
            okCall: function(){
                $.post(url, data, DWZ.ajaxDone, "json");
            }
        });
    }

</script>
