<style>
    .pageFormContent dl{
        float: none;
    }
</style>
<div class="pageContent">
        <form method="post" id="hander_form" action="/admin/question/handerAdd" enctype="multipart/form-data" class="pageForm required-validate" onsubmit="return iframeCallback(this);">
        <div class="pageFormContent" layoutH="56">

            <fieldset>
                <legend>问题详情</legend>
                <dl>
                    <dt>问题类型：</dt>
                    <dd>
                        <select name="question_type" class="required combox" id="question_type" onchange="changeDisplay()">
                            <option value="0">请选择</option>
                            <?php
                                if($questionType){
                                    foreach($questionType as $question){
                            ?>
                            <option value="<?php echo $question['id']?>" ><?php echo $question['type_name']?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select></dd>
                </dl>
                <dl>
                    <dt>账号：</dt>
                    <dd><input name="user_name" type="text" class="textInput" ></dd>
                </dl>
                <dl>
                    <dt>游戏名称：</dt>
                    <dd>
                        <select name="game_id" class="required combox">
                            <option value="0">请选择</option>
                            <?php
                            if(isset($games) && !empty($games)){
                                foreach($games as $game){
                                    ?>
                                    <option value="<?php echo $game['id']?>"><?php echo $game['title']?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </dd>
                </dl>

                <dl>
                    <dt>所属平台：</dt>
                    <dd><input name="channel_district.name" type="text" class="textInput" onfocus="$('#channel_look_up_question').click()"></dd>
                    <dd style="display: none"><input name="channel_district.id" type="text" class="textInput"></dd>
                    <dd style="display: none"><a id="channel_look_up_question" class="btnLook" href="/admin/question/channelLookBack" lookupGroup="channel_district">查找带回</a></dd>
                </dl>

                <dl>
                    <dt>角色名：</dt>
                    <dd><input name="role_name" type="text"  class="textInput" id="field2_9075"><label class="alt" for="field2_9075" style="width: 127px; top: 5px; left: 130px; opacity: 1;"></label></dd>
                </dl>
                <dl>
                    <dt>服务器：</dt>
                    <dd><input name="game_area" type="text"  class="textInput" id="field2_9075"><label class="alt" for="field2_9075" style="width: 127px; top: 5px; left: 130px; opacity: 1;"></label></dd>

                </dl>
                <dl style="display: none" id="recharge_type">
                    <dt>充值方式：</dt>
                    <?php
                        $objRecharge = Pdw_recharge_type::model()->findAll();
                    ?>
                    <dd>
                        <select name="recharge_type" class="required combox" >
                            <option value="0">请选择</option>
                            <?php
                                if($objRecharge){
                                    foreach($objRecharge as $chargeType){
                            ?>
                            <option value="<?php echo $chargeType['id']?>"><?php echo $chargeType['name']?></option>
                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </dd>
                </dl>
                <dl style="display: none" id="recharge_order_number">
                    <dt>充值订单号：</dt>
                    <dd><input name="recharge_order_number" type="text" class="textInput" id="field2_9075"><label class="alt" for="field2_9075" style="width: 127px; top: 5px; left: 130px; opacity: 1;"></label></dd>
                </dl>
                <dl style="display: none" id="recharge_card_number">
                    <dt>充值卡卡号：</dt>
                    <dd><input name="recharge_card_number" type="text"  class="textInput" id="field2_9075"><label class="alt" for="field2_9075" style="width: 127px; top: 5px; left: 130px; opacity: 1;"></label></dd>
                </dl>
            </fieldset>

            <fieldset>
                <legend>问题描述</legend>
                <textarea class="editor" name="description" rows="18" cols="120"   upImgUrl="/uploadFile.php" upImgExt="jpg,jpeg,gif,png"> </textarea>

            </fieldset>
            <dl>
                <dt>上传截图：</dt>
                <dd>
                    <input type="file" name="question_thumb"/><span style="color: red;margin: 10px;clear: both;padding: 10px;">*图片格式：jpg,jpeg,png,gif</span>
                </dd>

            </dl>

            <dl>
                <dt>流转给：</dt>
                <dd>
                    <select name="flow_to" class="required combox">
                        <?php
                            if(isset($admins) && !empty($admins)){
                                foreach($admins as $admin){
                                    if($admin['id'] == Yii::app()->user->getState('admin_id') ) continue;
                        ?>

                        <option value="<?php echo $admin['id']?>"><?php echo $admin['user_name']?></option>
                         <?php
                                }
                            }
                        ?>
                    </select>
                </dd>

            </dl>


            <dl>
                <dd>
                   <button type="button" onclick="flow()">流转</button>
                </dd>

            </dl>
        <input type="hidden" name="action" value="save_hander_question">

        </div>
        <div class="formBar">
            <ul>
                <!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
                <li>
                    <div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
                </li>
            </ul>
        </div>
    </form>
</div>
<script>
function flow(){
   var action = $('#hander_form').attr('action');
    var str = '<input type="hidden" name="is_flow" value="1">';
    $('#hander_form').append(str).submit();

}

    function changeDisplay(){
        var opt = $('#question_type').val();
        if(opt == '1'){
            $('#recharge_type').show();
            $('#recharge_order_number').show();
            $('#recharge_card_number').show();
        }else{
            $('#recharge_type').hide();
            $('#recharge_order_number').hide();
            $('#recharge_card_number').hide();
        }
    }
</script>