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
                <input name="sn" type="text" size="30" value="<?php echo date('Y-m-d H:i:s',$questionDetail['create_time'])?>" readonly="readonly"/>
            </p>
            <p>
                <label>用户名：</label>
                <input name="sn" type="text" size="30" value="<?php echo $questionDetail['user_name']?>" readonly="readonly"/>
            </p>
            <p>
                <label>用户手机：</label>
                <input name="sn" type="text" size="30" value="<?php echo $questionDetail['user_phone']?>" readonly="readonly"/>
            </p>
            <p>
                <label>所属平台：</label>
                <?php
                    $channelId = $questionDetail['platform_id'];
                    $plateform = Pdc_channel::model()->find("id='{$channelId}'")->channel_name;
                ?>
                <input name="sn" type="text" size="30" value="<?php echo $plateform?>" readonly="readonly"/>
            </p>
            <p>
                <label>所属游戏：</label>
                <?php
                    $gameId = $questionDetail['game_id'];
                    $gameName = Pdw_games::model()->find("id='{$gameId}'")->title;
                ?>
                <input name="sn" type="text" size="30" value="<?php echo $gameName?>" readonly="readonly"/>
            </p>
            <p>
                <label>所属区服：</label>
                <input name="sn" type="text" size="30" value="<?php echo $questionDetail['game_area']?>" readonly="readonly"/>
            </p>
            <p>
                <label>角色名称：</label>
                <input name="sn" type="text" size="30" value="<?php echo $questionDetail['role_name']?>" readonly="readonly"/>
            </p>
            <p>
                <label>问题类型：</label>
                <?php
                    $typeId = $questionDetail['question_type'];
                    $typeName = Pdw_question_type::model()->find("id='{$typeId}'")->type_name;
                ?>
                <input name="sn" type="text" size="30" value="<?php echo $typeName?>" readonly="readonly"/>
            </p>
            <?php
            //判断当前问题类型，充值问题才显示充值卡号和订单号`
                if($typeId == 1){
            ?>
            <p>
                <label>充值订单号：</label>
                <input name="sn" type="text" size="30" value="<?php echo $questionDetail['recharge_order_number']?>" readonly="readonly"/>
            </p>

            <p>
                <label>充值卡号：</label>
                <input name="sn" type="text" size="30" value="<?php echo $questionDetail['recharge_card_number']?>" readonly="readonly"/>
            </p>

            <?php
                }
            ?>
            <br/>
            <p style="clear: both">
                <label>问题描述：</label>
                <?php
                    echo $questionDetail['question_description'];
                ?>
            </p>

            <?php
            //判断是否上传问题截图
            if($questionDetail['question_thumb']){
            ?>
            <br/>
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
            //接入信息
                if($questionDetail->accept_servicer_id){
                    $accept_username = Whoneed_admin::model()->find("id = '{$questionDetail->accept_servicer_id}'")->user_name;
            ?>
                    <p style="clear: both">
                        <label>接入客服：</label>
                        <input name="sn" type="text" size="30" value="<?php echo $accept_username;?>" readonly="readonly"/>
                    </p>

                    <p style="clear: both">
                        <label>接入时间：</label>
                        <input name="sn" type="text" size="30" value="<?php echo date('Y-m-d H:i:s',$questionDetail->accept_time)?>" readonly="readonly"/>
                    </p>
            <?php
                }
            ?>

            <?php
            if($objRemark){
            //备注信息
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
                }
            ?>
            </ul>
            </p>

            <?php
                $adminId = Yii::app()->user->getState('admin_id');
                $objflow = Pdw_question_flow::model()->find("question_id='{$questionDetail['id']}' and is_begin = 1 and flow_reply='1'");
                if($objflow){
                    $flowFrom = Whoneed_admin::model()->find("id='{$objflow['flow_from']}'")->user_name;
            ?>
            <p style="clear: both">
                <label>流转客服：</label>
                <input name="sn" type="text" size="30" value="<?php echo $flowFrom?>" readonly="readonly"/>
            </p>

            <p style="clear: both">
                <label>流转时间：</label>
                <input name="sn" type="text" size="30" value="<?php echo date('Y-m-d H:i:s',$objflow['flow_time'])?>" readonly="readonly"/>
            </p>
            <?php
                }
            ?>

            <?php
            //判断是否可回复状态，如果不可以回复则readonly
                 if($questionDetail['status']==1){
            ?>
            <p style="clear: both">
                <label>客服回复：</label>
                <textarea class="editor" name="reply_content" rows="18" cols="120" readonly="readonly" upImgUrl="/uploadFile.php" upImgExt="jpg,jpeg,gif,png"><?php echo $questionDetail['reply_content']?></textarea>

            </p>
            <?php
            }else{
                     if($questionDetail['status']==4){
                         ?>
                         <p style="clear: both">
                             <label>回复时间：</label>
                             <input name="sn" type="text" size="30" value="<?php echo date('Y-m-d H:i:s',$questionDetail['reply_time'])?>" readonly="readonly"/>
                         </p>

             <?php
                     }

                ?>
                <p style="clear: both">
                    <label>客服回复：</label>
                    <textarea readonly="readonly" rows="10" cols="120"><?php echo $questionDetail['reply_content']?></textarea>
                </p>

            <?php
            }
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
                <?php
                    if($questionDetail['status']==1){
                ?>
                        <a class="button" id="do_flow" href="" onclick="flow()" target="ajaxTodo" rel="dlg_page2" ><span>流转</span></a>
                <?php
                    }else{
                ?>
                        <a class="buttonDisabled" href="javascript:;"><span>不可流转</span></a>

            </p>
            <?php
            }
            ?>

            <?php
            //除了未接入的，其他都可以添加备注
                if($questionDetail['status'] !=0){
            ?>

            <p style="clear: both">
                <label>备注：</label>
                <textarea class="editor" name="remark_content" id="remark_content" rows="18" cols="120"   upImgUrl="/uploadFile.php" upImgExt="jpg,jpeg,gif,png"> </textarea>

            </p>
            <p style="clear: both;">
                <a class="button" id="do_remark" href="" onclick="remark(<?php echo $questionDetail['id']?>)" target="ajaxTodo" rel="dlg_page2" ><span>备注</span></a>
            </p>
            <?php
                }
            ?>

        </div>
        <div class="formBar">
            <ul>
                <!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
                <?php
                if($questionDetail['status']==1){
                    ?>
                    <li><div class="buttonActive"><div class="buttonContent"><button type="submit">回复</button></div></div></li>
                <?php
                }else{
                    ?>
                    <li><a class="buttonDisabled" href="javascript:;"><span>不可回复</span></a></li>
                <?php
                }
                ?>
<!--                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">回复</button></div></div></li>-->
                <li>
                    <div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
                </li>
            </ul>
        </div>
    </form>
</div>
<script>
    function flow(){
        var questionId = $('#question_id').attr('value');
        var flowTo = $('#flow_to').attr('value');
        if(flowTo == 0){
            alert('请选择流转人');
            event.preventDefault();
        }

        $('#do_flow').attr('href','/admin/question/flowTo?flow='+flowTo+'&question_id='+questionId);
    }

    function remark(questionId){
        var content = $('#remark_content').val();
        var href = '/admin/question/remark?question_id='+questionId+'&remark_content='+content;
        $('#do_remark').attr('href',href);
    }
</script>
