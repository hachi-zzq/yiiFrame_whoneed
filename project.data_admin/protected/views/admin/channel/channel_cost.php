<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
    <?php
    if(isset($arrCondition)){
        foreach($arrCondition as $key=>$condition){
            echo "<input type='hidden' name='$key' value='$condition'>";
        }
    }
    ?>
</form>

<div class="pageHeader">
    <form rel="pagerForm" id="myForm" onsubmit="return navTabSearch(this);" action="/admin/channel/channelPay" method="post">
        <div class="searchBar" >
            <ul class="searchContent">

                <li id="search_channel_name" style="width: 280px;">
                    <label>渠道名称：</label>
                    <input class="required" name="district.channel_name" type="text" readonly="readonly" onclick="$('#channel_look_up').click()" value="<?php echo $params['channel_name']?$params['channel_name']:'点击左侧查找'?>"/>
                    <input class="required" id="channel_id" name="district.channel_id" type="hidden" readonly="readonly" value="<?php echo $params['channel_id']?>"/>
                    <a id="channel_look_up" class="btnLook" href="/admin/channel/channelLookBack" lookupGroup="district">查找带回</a>
                </li>
                <li id="search_channel_name" style="width: 200px;">
                    <label>渠道归属：</label>
                    <!--                      隐藏字段      获取渠道分类-->
                    <select name="channel_from" id="channel_from">
                        <option value="0">全部</option>

                        <?php
                        if($params['channel_from'] == '1'){
                            $ggselect = 'selected="selected"';
                        }

                        if($params['channel_from'] == '2'){
                            $hzselect = 'selected="selected"';
                        }
                        ?>
                        <option value="1"  <?php echo $ggselect?>>广告</option>
                        <option value="2"  <?php echo $hzselect?>>合作渠道</option>

                    </select>
                </li>

                　　　

            </ul>
            <input type="hidden" name="action" value="search">
            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit" id="searchBut">查看</button></div></div></li>
                    <li><a  id="output" class="button" href="#" onclick="output()" title="查询框"><span>导出excel</span></a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div class="pageContent">
    <table class="table" width="1200" layoutH="138">
        <thead>
        <tr>
            <th width="22"><input type="checkbox" group="ids" class="checkboxCtrl"></th>

            <th width="50" orderField="accountNo">开始日期</th>
            <th width="50" orderField="accountNo">结束日期</th>
            <th width="80" orderField="accountType">渠道名称</th>
            <th width="50" orderField="accountCert">渠道花费</th>
            <th width="370" >操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($objcost) && !empty($objcost)){
            foreach($objcost as $cost){
//                $channel_id =$pay['channel_id'];
//                $channel_from =$pay['channel_from'];
//                $channel_name = Pdc_channel::getNameById($cost['channel_id']);
                $channel_name = Pdcc_channel::model()->find("id='{$cost['channel_id']}'")->channel_name;
//                $regCost = round($pay['reg_cost_sum'],4);
//                $activeCost = round($pay['active_cost_sum'],4);
//                //注册数
//                $arrRegActive = MyFunction::getTimeReg($time['start_time'],$time['end_time'],$channel_id);
//                $regNum = $arrRegActive['reg_sum'];
//                $activeNum = $arrRegActive['active_sum'];
//
//                //渠道花费
//                $cost =$regNum==0?round($regCost,2):round($regNum*$regCost,2)
                ?>
                <tr target="sid_user" rel="">
                    <td><input name="ids" value="<?php echo $cost['id']?>" type="checkbox"></td>
                    <td><?php echo  $cost['record_begin_date']?></td>
                    <td><?php echo $cost['record_end_date']?></td>
                    <td><?php echo $channel_name?></td>
                    <td><?php echo $cost['cost'];?></td>
                    <td>
                        <a title="编辑" target="navTab" href="/admin/channel/channelPayEdit?id=<?php echo $cost['id']?>" class="btnEdit">编辑</a>
                        <a title="删除" target="ajaxTodo" href="/admin/channel/channelPayDel?id=<?php echo $cost['id']?>" class="btnDel">删除</a>
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
        var strDUrl = '/admin/channel/payMultiDelete/ids/';
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


    function output(){
        var channel_id = $('#channel_id').attr('value');
        var channel_from = $('#channel_from').attr('value');
//        alert(channel_id+channel_from+start_time+end_time);
        $('#output').attr('href', '/admin/channel/outPutExcel?channel_id='+channel_id+'&channel_from='+channel_from);

    }
</script>
