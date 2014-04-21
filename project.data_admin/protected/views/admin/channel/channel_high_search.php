<div class="pageContent">
    <form method="post" action="/admin/channel/highSearch" class="pageForm" onsubmit="return navTabSearch(this);">
        <input type="hidden" name="channel_from" value="<?php echo Yii::app()->request->getParam('channel_from')?>">
        <div class="pageFormContent" layoutH="58">
            <div class="unit">
                <label>请输入渠道名称：</label>
                <input type="text"   name="channel_name" value=""/>
            </div>
<!--            <div class="divider">divider</div>-->
            <div class="unit">
                <label>渠道类型：</label>
                <label class="radioButton"><input name="channel_type" type="radio" value="not" checked="checked"/>无</label>
                <label class="radioButton"><input name="channel_type" type="radio" value="CPA"/>CPA</label>
                <label class="radioButton"><input name="channel_type" type="radio" value="CPC"/>CPC</label>
                <label class="radioButton"><input name="channel_type" type="radio" value="CPT"/>CPT</label>
                <label class="radioButton"><input name="channel_type" type="radio" value="CPL"/>CPL</label>
                <label class="radioButton"><input name="channel_type" type="radio" value="CPM"/>CPM</label>
            </div>

<!--            <div class="unit">-->
<!--                <label>是否有子渠道：</label>-->
<!--                <label class="radioButton"><input name="is_has_chlid" type="radio" value="not" checked="checked"/>无</label>-->
<!--                <label class="radioButton"><input name="is_has_chlid" type="radio" value="1"/>是</label>-->
<!--                <label class="radioButton"><input name="is_has_chlid" type="radio" value="0"/>否</label>-->
<!--            </div>-->

            <div class="unit">
                <label>是否合作：</label>
                <label class="radioButton"><input name="is_cooperation" type="radio" value="not" checked="checked"/>无</label>
                <label class="radioButton"><input name="is_cooperation" type="radio" value="1"/>是</label>
                <label class="radioButton"><input name="is_cooperation" type="radio" value="0"/>否</label>
            </div>


            <div class="unit">
                <label>建档日期：</label>
                <input type="text" size="25" name="time_start" class="date"  style="float: none;"/>
                <span>到</span>
                <input type="text" size="25" name="time_end" class="date" style="float: none;" />
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
