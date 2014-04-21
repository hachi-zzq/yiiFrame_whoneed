<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
</form>

<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="" method="post">
        <div class="searchBar">
            <ul class="searchContent">
<!--                <li>-->
<!--                    <label>我的客户：</label>-->
<!--                    <input type="text" name="keywords" value=""/>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <select class="combox" name="province">-->
<!--                        <option value="">所有省市</option>-->
<!--                        <option value="北京">北京</option>-->
<!--                        <option value="上海">上海</option>-->
<!--                        <option value="天津">天津</option>-->
<!--                        <option value="重庆">重庆</option>-->
<!--                        <option value="广东">广东</option>-->
<!--                    </select>-->
<!--                </li>-->
            </ul>
            <!--
            <table class="searchContent">
                <tr>
                    <td>
                        我的客户：<input type="text"/>
                    </td>
                    <td>
                        <select class="combox" name="province">
                            <option value="">所有省市</option>
                            <option value="北京">北京</option>
                            <option value="上海">上海</option>
                            <option value="天津">天津</option>
                            <option value="重庆">重庆</option>
                            <option value="广东">广东</option>
                        </select>
                    </td>
                </tr>
            </table>
            -->
<!--            <div class="subBar">-->
<!--                <ul>-->
<!--                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>-->
<!--                    <li><a class="button" href="demo_page6.html" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>-->
<!--                </ul>-->
<!--            </div>-->
        </div>
<!--    </form>-->
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
            <th width="30" >渠道编号</th>
            <th orderField="accountName" width="50">渠道名称</th>
            <th orderField="accountName" width="50">父渠道名称</th>
            <th width="40" orderField="accountType">渠道类型</th>
            <th width="50" orderField="accountCert">创建时间</th>
            <th width="30" align="center" orderField="accountLevel">是否合作</th>
            <th width="320">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($all_child) && !empty($all_child)){
            foreach($all_child as $v){
                $v['is_cooperation'] = $v['is_cooperation']==1?'是':'否';
                $id_count = 'count_'.$v['id'];
                ?>

                <tr target="sid_user" rel="<?php echo $v['id']?>">
                    <td><input name="ids" value="<?php echo $v['id']?>" type="checkbox"></td>
                    <td><?php echo $v['id']?></td>
                    <td><a href="/admin/channel/channelLink?channel_id=<?php echo $fid?>&channel_name=<?php echo $v['channel_name']?>&sub_id=<?php echo $v['id']?>" target="dialog" mask="true"><?php echo $v['channel_name']?></a></td>
                    <td><?php echo $father_name?></td>
                    <td><?php echo $v['channel_type']?></td>
                    <td><?php echo $v['create_time']?></td>
                    <td><?php echo $v['is_cooperation']?></td>
                    <td>
                        <a  target="navTab" href="/admin/channel/showChlidAdd?fid=<?php echo $v['id']?>">添加子渠道  </a>/
                        <a  target="navTab" href="/admin/channel/showChild?fid=<?php echo $v['id']?>" rel="<?php echo $v['id']?>">查看子渠道（<span style="color: green"><?php echo $$id_count?></span>）  </a>/
                        <a title="此操作将删除该渠道下的所有子渠道！！谨慎操作" target="ajaxTodo" href="<?php echo Yii::app()->createUrl('admin/channel/deleteOne',array('id'=>$v['id']))?>" >删除 </a>/
                        <a title="编辑" target="navTab" href="<?php echo Yii::app()->createUrl('admin/channel/showEdit',array('id'=>$v['id']))?>" >编辑</a>
                        <?php
                        if($obj = MyFunction::checkDistribute($fid,$v['id'])){
                            $style = 'style="color:blue;"';
                            $packageTitle = '('.$obj['title'].')';
                        }else{
                            $style = '';
                            $packageTitle = '';
                        }
                        ?>
                        <a <?php echo $style?$style:''?> href="/admin/channel/channelDistribute?channel_name=<?php echo $v['channel_name']?>&channel_id=<?php echo $fid?>&sub_id=<?php echo $v['id']?>" target="navTab">渠道游戏包分发<?php echo $packageTitle?$packageTitle:''?></a>

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
<!--            <span>显示</span>-->
<!--            <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">-->
<!--                <option value="20">10</option>-->
<!--                <option value="50">50</option>-->
<!--                <option value="100">100</option>-->
<!--                <option value="200">200</option>-->
<!--            </select>-->
            <span>共<?php echo $page->itemCount?>条</span>
        </div>

        <div class="pagination" targetType="navTab" totalCount="<?php echo $page->itemCount?>" numPerPage="<?php echo $page->pageSize?>" pageNumShown="10" currentPage="<?php echo $page->currentPage+1?>"></div>

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
        $('#batchDel', navTab.getCurrentPanel()).attr("href", strDUrl);
//        $('#batchDel').attr('href',strDUrl);

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
