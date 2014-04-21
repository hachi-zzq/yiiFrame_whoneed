
<div class="pageContent">
    <form method="post" action="/admin/question/flowMeHighSearch" class="pageForm" onsubmit="return navTabSearch(this);">
        <div class="pageFormContent" layoutH="58">
            <div class="unit">
                <label>问题编号：</label>
                <input name="question_id" type="text" size="30" value=""/>
            </div>
            <div class="divider">divider</div>
            <div class="unit">
                <label>用户名：</label>
                <input name="user_name"  type="text" size="30" value="" />
            </div>
            <div class="unit">
                <label>游戏：</label>
                <?php
                $objGame = Pdw_games::model()->findAll();
                ?>
                <select name="game_id" class=" combox">
                    <option value="">全部</option>
                    <?php
                    if($objGame){
                        foreach($objGame as $game){
                            ?>
                            <option value="<?php echo $game['id']?>"><?php echo $game['title']?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="unit">
                <label>区服：</label>
                <input type="text" size="30" value="" name="game_area" class="textInput">
            </div>
            <div class="unit">
                <label>问题类型：</label>
                <?php
                $objQuestionType = Pdw_question_type::model()->findAll();
                ?>
                <select name="question_type" class="combox">
                    <option value="">全部</option>
                    <?php
                    if($objQuestionType){
                        foreach($objQuestionType as $questionType){
                            ?>
                            <option value="<?php echo $questionType['id']?>" ><?php echo $questionType['type_name']?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="unit">
                <label>用户手机：</label>
                <input type="text"  value="" name="user_phone" class="textInput">
            </div>
            <div class="unit">
                <label>所属平台：</label>
                <?php
                $objChannel = Pdc_channel::model()->findAll();
                ?>
                <select name="question_type" class="combox">
                    <option value="">全部</option>
                    <?php
                    if($objChannel){
                        foreach($objChannel as $channel){
                            ?>
                            <option value="<?php echo $channel['id']?>" ><?php echo $channel['channel_name']?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
<!--                <input type="text" size="30" onfocus="$('#channel_look_up').click()" name="district.channel_name" />-->
<!--                <input name="district.channel_id" type="hidden" class="textInput" onclick="$('#channel_look_up').click()">-->
<!---->
<!--                <a style="display: none;" id="channel_look_up" class="btnLook" href="/admin/channel/channelLookBack" lookupGroup="district">查找带回</a>-->
            </div>
            <div class="unit">
                <label>开始时间：</label>
                <input type="text" name="start_time" class="date" size="30" /><a class="inputDateButton" href="javascript:;">选择</a>
            </div>
            <div class="unit">
                <label>结束时间：</label>
                <input type="text" name="end_time" class="date" size="30" /><a class="inputDateButton" href="javascript:;">选择</a>
            </div>

        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">开始检索</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="reset">清空重输</button></div></div></li>
            </ul>
        </div>
    </form>
</div>
