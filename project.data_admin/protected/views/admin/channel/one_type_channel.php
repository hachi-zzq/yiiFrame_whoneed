<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
</form>

<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="/admin/channel/navSearch" method="post">
        <div class="searchBar">
            <ul class="searchContent">
<!--                <li>-->
<!--                    <label >查询方式：</label>-->
<!--                    <select class="combox" name="search_type" id="search_type" >-->
<!--                        <option value="0">--请选择--</option>-->
<!--                        <option value="name" >渠道名称</option>-->
<!--                        <option value="type">渠道类型</option>-->
<!--                        <option value="time">时间段</option>-->
<!--                        <option value="is_cooperation">是否合作</option>-->
<!--                    </select>-->
<!--                </li>-->

                <li id="search_channel_name" >
                    <label>渠道名称：</label>
                    <input type="text" name="search_channel_name" value=""/>
<!--                      隐藏字段      获取渠道分类-->
                    <input type="hidden" name="search_channel_from" value="<?php echo $channel_from?>">
                </li>

                <li id="search_channel_name" >
                    <label>游戏选择：</label>
                    <input class="required" name="district.game_name" type="text" onclick="$('#game_back').click()" readonly="readonly"/>
                    <input class="required" name="district.id" type="hidden" readonly="readonly"/>
                    <a class="btnLook" style="display: none" id="game_back" href="/admin/channel/gameBack" lookupGroup="district">查找带回</a>
                </li>

<!--                <li id="search_channel_type" style="display: none">-->
<!--                    <label>渠道类型：</label>-->
<!--                    <select class="combox" name="search_channel_type" >-->
<!--                        <option value="0">--请选择--</option>-->
<!--                        <option value="CPA" >CPA</option>-->
<!--                        <option value="CPC">CPC</option>-->
<!--                        <option value="CPT">CPT</option>-->
<!--                        <option value="CPL">CPL</option>-->
<!--                        <option value="CPM">CPM</option>-->
<!--                    </select>-->
<!--                </li>-->

<!--                <li id="search_channel_time" style="display: none">-->
<!--                    <label>时间段：</label>-->
<!--                    <select class="combox" name="search_channel_time" >-->
<!--                        <option value="0">--请选择--</option>-->
<!--                        <option value="CPA" >当天</option>-->
<!--                        <option value="CPC">本星期</option>-->
<!--                        <option value="CPT">本月</option>-->
<!--                    </select>-->
<!--                </li>-->
<!---->
<!--                <li id="search_channel_cooperation" style="display: none">-->
<!--                    <label>是否合作：</label>-->
<!--                    <select class="combox" name="search_channel_cooperation" >-->
<!--                        <option value="0">--请选择--</option>-->
<!--                        <option value="CPA" >是</option>-->
<!--                        <option value="CPC">否</option>-->
<!--                    </select>-->
<!--                </li>-->
            </ul>
            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                    <li><a class="button" href="/admin/channel/highSearch?channel_from=<?php echo $channel_from?>" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
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
    <th width="30" orderField="accountNo">渠道编号</th>
    <th orderField="accountName" width="50">渠道名称</th>
    <th width="40" orderField="accountType">渠道类型</th>
    <th width="50" orderField="accountCert">创建时间</th>
    <th width="30" align="center" orderField="accountLevel">是否合作</th>
    <th width="30" align="center" >是否跳转</th>
    <th width="370" >操作</th>
</tr>
</thead>
<tbody>
<?php
    if(isset($all) && !empty($all)){
        foreach($all as $v){
            $v['is_cooperation'] = $v['is_cooperation']==1?'是':'否';
            $v['is_redirect']    = $v['is_redirect']==1?'是':'否';
            $id_count = 'count_'.$v['id'];
?>

<tr target="sid_user" rel="<?php echo $v['id']?>">
    <td><input name="ids" value="<?php echo $v['id']?>" type="checkbox"></td>
    <td><?php echo $v['id']?></td>
    <td><a href="/admin/channel/channelLink?channel_id=<?php echo $v['id']?>&channel_name=<?php echo $v['channel_name']?>&sub_id=0" target="dialog" mask="true"><?php echo $v['channel_name']?></a></td>
    <td><?php echo $v['channel_type']?></td>
    <td><?php echo $v['create_time']?></td>
    <td><?php echo $v['is_cooperation']?></td>
    <td><?php echo $v['is_redirect']?></td>
    <td>
        <a  target="navTab" href="/admin/channel/showChlidAdd?fid=<?php echo $v['id']?>">添加子渠道  </a>/
        <a  target="navTab" href="/admin/channel/showChild?fid=<?php echo $v['id']?>" rel="<?php echo $v['id']?>">查看子渠道（<span style="color: green"><?php echo $$id_count?></span>）  </a>/
        <a title="此操作将删除该渠道下的所有子渠道！！谨慎操作" target="ajaxTodo" href="<?php echo Yii::app()->createUrl('admin/channel/deleteOne',array('id'=>$v['id']))?>" >删除 </a>/
        <a title="编辑" target="navTab" href="<?php echo Yii::app()->createUrl('admin/channel/showEdit',array('id'=>$v['id']))?>">编辑</a>
        <?php
            if($obj = MyFunction::checkDistribute($v['id'],0)){
                $style = 'style="color:blue;"';
                $packageTitle = '('.$obj['title'].')';
            }else{
                $style = '';
                $packageTitle = '';
            }
        ?>
        　<a <?php echo $style?> href="/admin/channel/channelDistribute?channel_name=<?php echo $v['channel_name']?>&channel_id=<?php echo $v['id']?>&sub_id=0" target="navTab">渠道游戏包分发<?php echo $packageTitle?></a>
        <a title="添加渠道用户" href="/admin/channel/addChannelUser/channel_id/<?php echo $v['id']?>" target="navTab">添加渠道用户</a>
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
<!--        <span>显示</span>-->
<!--        <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">-->
<!--            <option value="20">10</option>-->
<!--            <option value="50">50</option>-->
<!--            <option value="100">100</option>-->
<!--            <option value="200">200</option>-->
<!--        </select>-->
        <span>共<?php echo $pager->itemCount?>条</span>
    </div>

    <div class="pagination" targetType="navTab" totalCount="<?php echo $pager->itemCount?>" numPerPage="<?php echo $pager->pageSize?>" pageNumShown="10" currentPage="<?php echo $pager->currentPage+1?>"></div>

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

    $(function(){
        $('#search_type').change(function(){
            if($('#search_type').attr('value') == 'name'){
                $('#search_channel_name').show();
            }
            if($('#search_type').attr('value') == 'type'){
                $('#search_channel_type').show();
            }

            if($('#search_type').attr('value') == 'time'){
                $('#search_channel_time').show();
            }

            if($('#search_type').attr('value') == 'is_cooperation'){
                $('#search_channel_cooperation').show();
            }
        })


    })
</script>
