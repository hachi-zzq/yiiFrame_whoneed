<form id="pagerForm" method="post" action="/admin/question/flowMeList">
    <input type="hidden" name="status" value="${param.status}">
    <input type="hidden" name="keywords" value="${param.keywords}" />
    <input type="hidden" name="pageNum" value="1" />
    <input type="hidden" name="numPerPage" value="${model.numPerPage}" />
    <input type="hidden" name="orderField" value="${param.orderField}" />
    <?php
        if($arrCondition){
            foreach($arrCondition as $key=>$condition){
                echo '<input type="hidden" name="'.$key.'" value="'.$condition.'" />';
            }
        }
    ?>
</form>


<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="/admin/question/unhander" method="post">
        <div class="searchBar">
            <!--<ul class="searchContent">
                <li>
                    <label>我的客户：</label>
                    <input type="text"/>
                </li>
                <li>
                <select class="combox" name="province">
                    <option value="">所有省市</option>
                    <option value="北京">北京</option>
                    <option value="上海">上海</option>
                    <option value="天津">天津</option>
                    <option value="重庆">重庆</option>
                    <option value="广东">广东</option>
                </select>
                </li>
            </ul>
            -->
            <table class="searchContent">
                <tr>
                    <td>
                        用户名：<input type="text" name="user_name" value="<?php echo $user_name?$user_name:''?>"/>
                    </td>
                    <td>
                        所属平台：<input type="text" name="district.channel_name" value="<?php echo $channel_name?$channel_name:''?>" onfocus="$('#channel_look_up').click()"/>
                        <input style="display: none" type="text" name="district.channel_id" value="<?php echo $channel_id?$channel_id:''?>"/>
                        <a id="channel_look_up" style="display: none" class="btnLook" href="/admin/channel/channelLookBack" lookupGroup="district">查找带回</a>

                    </td>
                    <td>
                        <select name="question_type" class="combox">
                            <option value="0">所有类型</option>
                            <?php
                            $questionType = Pdw_question_type::model()->findAll();
                                foreach($questionType as $question){
                                    if($question['id']==$question_type) $select = 'selected="selected"';else $select='';
                                    ?>
                                    <option value="<?php echo $question['id']?>" <?php echo $select?>><?php echo $question['type_name']?></option>
                                <?php

                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="question_status" class="combox">
                            <option value="-100">所有状态</option>
                            <option value="0" <?php if($question_status == '0') echo 'selected=selected'?>>未接入</option>
                            <option value="1" <?php if($question_status == '1') echo 'selected=selected'?>>已接入</option>
                            <option value="2" <?php if($question_status == '2') echo 'selected=selected'?>>正在流转</option>
                            <option value="3" <?php if($question_status == '3') echo 'selected=selected'?>>流转已回复</option>
                            <option value="4" <?php if($question_status == '4') echo 'selected=selected'?>>已回复客户</option>


                        </select>
                    </td>
                    <td>
                        开始时间：<input type="text" class="date" name="start_time" value="<?php echo $time?$time['start_time']:date('Y-m-d')?>"/>
                    </td>
                    <td>
                        结束时间：<input type="text" class="date" name="end_time" value="<?php echo $time?$time['end_time']:date('Y-m-d')?>" />
                        <input type="hidden" name="myform" value="<?php echo $myform?>">
                    </td>
                </tr>

            </table>
            <div class="subBar">
                <ul>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">快速检索</button></div></div></li>
                    <li><a class="button" href="/admin/question/unhanderHighSearch" target="dialog" mask="true" title="查询框"><span>高级检索</span></a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<div class="pageContent">
<table class="table" width="100%" layoutH="138">
<thead>
<tr>
    <th width="30">问题编号</th>
    <th width="80">用户名</th>
    <th width="80">手机号</th>
    <th width="80">游戏名</th>
    <th width="50">问题类型</th>
    <th width="80" align="center">提问时间</th>
    <th width="80" align="center">接入时间</th>
    <th width="50">当前状态</th>
    <th width="50">查看明细</th>
</tr>
</thead>
<tbody>
<?php
    if(isset($questions) && !empty($questions)){
        foreach($questions as $question){
?>

<tr target="sid_user" rel="1">
    <td><?php echo $question['id']?></td>
    <td><?php echo $question['user_name']?></td>
    <td><?php echo $question['user_phone']?></td>
    <td><?php echo $question['game_id']?></td>
    <td><?php echo $question['question_type']?></td>
    <td><?php echo date('Y-m-d H:i:s',$question['create_time'])?></td>
    <td><?php echo date('Y-m-d H:i:s',$question['accept_time'])?></td>
    <?php
    $style = '';
        switch($question['status']){
            case '0':
                $status = '未接入';
                $style = 'style="color:red"';
                break;
            case '1':
                $status = '已接入';
                $style = '';
                break;
            case '2':
                $status = '正在流转处理';
                $style = 'style="color:green"';
                break;
            case '3':
                $status = '流转已回复';
                $style = 'style="color:blue"';
                break;
            case '4':
                $status = '已回复客户';
                $style = 'style="color:blue"';
                break;
            default:
                $status = '未知';break;
        }
    ?>

    <td <?php echo $style?>><?php echo $status;?></td>
    <td>
        <a title="问题详情" target="navTab" href="/admin/question/unhanderDetail?id=<?php echo $question['id']?>" class="btnEdit">查看明细</a>
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

        <span>共<?php echo $pager->itemCount?>条</span>
    </div>

    <div class="pagination" targetType="navTab" totalCount="<?php echo $pager->itemCount?>" numPerPage="<?php echo $pager->pageSize?>" pageNumShown="10" currentPage="<?php echo $pager->currentPage+1?>"></div>

</div>
</div>