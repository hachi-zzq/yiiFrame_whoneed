<form id="pagerForm" method="post" action="<?php echo Yii::app()->request->requestUri?>">
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <input type="hidden" name="orderDirection" value="${param.orderDirection}" />
</form>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a title="消息发送" target="navTab" rel='replay' href="<?php echo Yii::app()->createUrl('admin/weixin/sendText',array('nick'=>$nick,'openid'=>$openid))?>"  class="add"><span>发送消息</span></a></li>
            <!--        <li><a title="确实要删除这些记录吗?" target="selectedTodo" rel="ids" href="javascript:;" onclick="$('#news_form').submit()" class="delete"><span>批量删除</span></a></li>-->
            <!--        <li><a class="edit" href="demo_page4.html?uid={sid_user}" target="navTab" warn="请选择一个用户"><span>修改</span></a></li>-->
            <li class="line">line</li>
        </ul>
    </div>
    <table class="table" width='100%' layoutH="75">
        <thead>
        <tr align='center'>
            <th width="50" >id</th>
            <th width="500">消息内容</th>
            <th width="200">发送时间</th>
            <th >回复</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(isset($user_message) && !empty($user_message)){
            $nick = Yii::app()->request->getParam('nick');
            foreach($user_message as $message){
                ?>
                <tr>
                    <td style="text-align: center"><?php echo $message['id']?></td>
                    <?php
                        if($message['message_type'] == 'image'){
                            echo '<td><a style="color:blue;" href="'.$message['content'].'" target="navTab" rel="pic_msg">图片消息</a></td>';
                        }elseif($message['message_type'] == 'text'){
                            echo '<td>'.$message['content'].'</td>';
                        }else{
                            echo '<td></td>';
                        }
                    ?>
                    <td style="text-align: center;"><?php echo date('Y-m-d H:i:s',$message['create_time'])?></td>
                    <td ><a title="消息发送" target="navTab" rel='replay' href="<?php echo Yii::app()->createUrl('admin/weixin/sendText',array('nick'=>$nick,'openid'=>$openid))?>" class="btnEdit">消息发送</a></td>

                </tr>
            <?php
            }
        }
        ?>


        </tbody>
    </table>
    <div class="panelBar">
            <div class="pages">
<!--                <span>显示</span>-->
<!--                <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">-->
<!--                    <option value="20">20</option>-->
<!--                    <option value="50">50</option>-->
<!--                    <option value="100">100</option>-->
<!--                    <option value="200">200</option>-->
<!--                </select>-->
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
