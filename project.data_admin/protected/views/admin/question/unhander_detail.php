<style>
    .pageFormContent p{
        float: none;
        height: auto;
        min-height: 21px;
    }
</style>
<div class="pageContent" xmlns="http://www.w3.org/1999/html">
    <form method="post" action="/admin/question/reply" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="56">
            <p>
                <label>问题编号：</label>
                <input name="question_id" id="question_id" type="text" size="30" value="<?php echo $questionDetail['id']?>" readonly="readonly"/>
            </p>
            <p>
                <label>问题提交时间：</label>
                <input name="create_time" type="text" size="30" value="<?php echo date('Y-m-d H:i:s',$questionDetail['create_time'])?>" readonly="readonly"/>
            </p>
            <p>
                <label>用户名：</label>
                <input name="user_name" type="text" size="30" value="<?php echo $questionDetail['user_name']?>" readonly="readonly"/>
            </p>
            <p>
                <label>用户手机：</label>
                <input name="user_phone" type="text" size="30" value="<?php echo $questionDetail['user_phone']?>" readonly="readonly"/>
            </p>
            <p>
                <label>所属平台：</label>
                <?php
                    $channelId = $questionDetail['platform_id'];
                    $plateform = Pdc_channel::model()->find("id='{$channelId}'")->channel_name;
                ?>
                <input name="platform_id" type="text" size="30" value="<?php echo $plateform?>" readonly="readonly"/>
            </p>
            <p>
                <label>所属游戏：</label>
                <?php
                    $gameId = $questionDetail['game_id'];
                    $gameName = Pdw_games::model()->find("id='{$gameId}'")->title;
                ?>
                <input name="game_id" type="text" size="30" value="<?php echo $gameName?>" readonly="readonly"/>
            </p>
            <p>
                <label>所属区服：</label>
                <input name="game_area" type="text" size="30" value="<?php echo $questionDetail['game_area']?>" readonly="readonly"/>
            </p>
            <p>
                <label>角色名称：</label>
                <input name="role_name" type="text" size="30" value="<?php echo $questionDetail['role_name']?>" readonly="readonly"/>
            </p>
            <p>
                <label>问题类型：</label>
                <?php
                    $typeId = $questionDetail['question_type'];
                    $typeName = Pdw_question_type::model()->find("id='{$typeId}'")->type_name;
                ?>
                <input name="type_name" type="text" size="30" value="<?php echo $typeName?>" readonly="readonly"/>
            </p>
            <p>
                <label>充值订单号：</label>
                <input name="recharge_order_number" type="text" size="30" value="<?php echo $questionDetail['recharge_order_number']?>" readonly="readonly"/>
            </p>

            <p>
                <label>充值卡号：</label>
                <input name="recharge_card_number" type="text" size="30" value="<?php echo $questionDetail['recharge_card_number']?>" readonly="readonly"/>
            </p>
            <br/>
            <p style="clear: both">
                <label>问题描述：</label>
                <?php
                    echo $questionDetail['question_description'];
                ?>
            </p>
            <br/>
            <?php
            //判断是否有上传截图
                if($questionDetail['question_thumb']){
            ?>
            <p style="clear: both">
                <label>问题截图：</label>
                <?php

                        echo '<img src="'.Yii::app()->params['img_domain'].$questionDetail['question_thumb'].'"/>';
                ?>
            </p>
            <?php
            }
            ?>


            <?php
            //判断是否有备注
            if($objRemark){
            ?>
            <p style="clear: both">
                <label>客服备注：</label>
            <ul style="margin-left: 50px;">
                 <?php

                        foreach($objRemark as $remark){
                ?>
                <li style="line-height: 150%">
                    <?php echo $remark['user_id']?>，备注内容：<?php echo $remark['remark_content']?>
                </li>
            <?php
                }
            ?>
            </ul>
            </p>
            <?php
              }
            ?>

            <?php
                $adminId = Yii::app()->user->getState('admin_id');
                $objflow = Pdw_question_flow::model()->find("question_id='{$questionDetail['id']}' and is_begin=1 and flow_reply = 1");
                if($objflow){
                    $flowFrom = Whoneed_admin::model()->find("id='{$objflow['flow_from']}'")->user_name;
                    $flowFromId = $objflow->flow_from;
            ?>

            <p style="clear: both">
                <label>流转客服：</label>
                <input name="flow_from" type="text" size="30" value="<?php echo $flowFrom;?>" readonly="readonly"/>
                <input name="flow_from_id" type="hidden" size="30" value="<?php echo $flowFromId;?>" readonly="readonly"/>
            </p>

            <p style="clear: both">
                <label>流转时间：</label>
                <input name="flow_time" type="text" size="30" value="<?php echo date('Y-m-d H:i:s',$objflow['flow_time'])?>" readonly="readonly"/>
            </p>

            <p style="clear: both">
                <label>流转备注：</label>
                <input name="flow_remark" type="text" size="30" value="<?php echo $objflow['flow_remark']?>" readonly="readonly"/>
            </p>
            <?php
                }
            ?>
            <p style="clear: both">
                <label>回复：</label>
                <textarea class="editor" name="reply_content" rows="18" cols="120" readonly="readonly" upImgUrl="/uploadFile.php" upImgExt="jpg,jpeg,gif,png"><?php echo $questionDetail['reply_content']?></textarea>

            </p>
            <?php
                if($questionDetail['status'] == 1){
            ?>

            <p>
                <label>流转给：</label>
                <?php
                $objAdmin = Whoneed_admin::model()->findAll();
                ?>
                <select name="flow_to" class="required combox" id="flow_to">
                    <?php
                    if($objAdmin){
                        foreach($objAdmin as $admin){
                            if($admin['id'] == Yii::app()->user->getState('admin_id') ) continue;
                            ?>
                            <option value="<?php echo $admin['id']?>"><?php echo $admin['user_name']?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </p>
            <p style="clear: both;">

                <a class="button" id="do_flow" href="" onclick="flow(<?php echo $question_start_flag?>)" target="ajaxTodo" rel="dlg_page2" ><span>流转</span></a>

                <!--                <a class="buttonDisabled" href="javascript:;"><span>按钮</span></a>-->
            </p>
            <?php
                }
            ?>
<!--            <p style="clear: both;">-->

<!--                <a class="button" id="do_flow" href="" onclick="flow(--><?php //echo $question_start_flag?><!--)" target="ajaxTodo" rel="dlg_page2" ><span>流转</span></a>-->

<!--                <a class="buttonDisabled" href="javascript:;"><span>按钮</span></a>-->
<!--            </p>-->
<!--            <p style="clear: both">-->
<!--                <label>备注：</label>-->
<!--                <textarea class="editor" name="remark_content" id="remark_content" rows="18" cols="120"   upImgUrl="/uploadFile.php" upImgExt="jpg,jpeg,gif,png"> </textarea>-->
<!---->
<!--            </p>-->
<!--            <p style="clear: both;">-->
<!--                <a class="button" id="do_remark" href="" onclick="remark(--><?php //echo $questionDetail['id']?><!--)" target="ajaxTodo" rel="dlg_page2" ><span>备注</span></a>-->
<!--            </p>-->


        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">回复</button></div></div></li>
                <li>
                    <div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
                </li>
            </ul>
        </div>
    </form>
</div>
<script>
    function flow(startFlag){
        var questionId = $('#question_id').attr('value');
        var flowTo = $('#flow_to').attr('value');
        if(flowTo == 0){
            alert('请选择流转人');
            event.preventDefault();
        }

        $('#do_flow').attr('href','/admin/question/flowTo?flow='+flowTo+'&question_id='+questionId+'&question_start_flag='+startFlag)
    }

    function remark(questionId){
        var content = $('#remark_content').val();
        var href = '/admin/question/remark?question_id='+questionId+'&remark_content='+content;
        $('#do_remark').attr('href',href);
    }
</script>
