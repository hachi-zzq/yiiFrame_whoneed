<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
</form>
<div class="pageContent">
    <table class="table" width='100%' layoutH="75">
        <thead>
        <tr align='center'>
            <th width="50" >id</th>
            <th width="200">用户昵称</th>
            <th width="500">最近消息</th>
            <th >发送时间</th>
        </tr>
        </thead>
        <tbody>
            <?php

                if(isset($all_user) && !empty($all_user)){
                    foreach($all_user as $a){
                        $recent = $recent_message[$a->openid]['content'];
                        $msg_type = $recent_message[$a->openid]['msg_type'];
            ?>
                <tr>

                    <td><?php echo $a['id']?></td>
                    <td><a href="/admin/weixin/messageList?openid=<?php echo $a['openid']?>&nick=<?php echo base64_encode($a['nickname'])?>" target="navTab"><?php echo $a['nickname']?></a></td>
<!--                    --><?php
                    if($msg_type == 'text'){
                        echo '<td>'.$recent.'</td>';
                    }elseif($msg_type == 'image'){
                        echo '<td><a style="color:blue;" href="'.$recent.'" target="navTab" rel="pic_msg">图片消息,点击查看</a></td>';
                    }else{
                        echo '<td></td>';
                    }
//                    ?>
<!--                                        <td>--><?php //echo $recent?><!--</td>-->
                    <td style="text-align: center"><?php echo date('Y-m-d H:i:s',$a['subscribe_time'])?></td>
                </tr>
            <?php
                    }
                }
            ?>


            </tbody>
        </table>
        <div class="panelBar">
                <div class="pages">
<!--                    <span>显示</span>-->
<!--                    <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">-->
<!--                        <option value="20">20</option>-->
<!--                        <option value="50">50</option>-->
<!--                        <option value="100">100</option>-->
<!--                        <option value="200">200</option>-->
<!--                    </select>-->
                    <span>共<?php echo $pager->itemCount;?>条</span>
                </div>

                <div class="pagination" targetType="navTab" totalCount="<?php echo $pager->itemCount;?>" numPerPage="<?php echo $pager->pageSize;?>" pageNumShown="10" currentPage="<?php echo $pager->currentPage + 1?>"></div>

        </div>
    </div>
<script>
    function batchDel(){
        var strDUrl = '/admin/news/test';
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
