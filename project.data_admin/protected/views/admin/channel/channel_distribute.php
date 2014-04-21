<h2 class="contentTitle">渠道分发--<?php echo $channel_name?> (<?php echo $sub_id==0?$channel_id:$sub_id?>)</h2>

<div class="pageContent">
    <form action="/admin/channel/channelDistribute" method="post" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone)">

        <div class="pageFormContent" layoutH="97">
            <dl class="nowrap">
                <dt>游戏ID：</dt>
                <dd>
                    <input style="margin-right: 20px;" class="required" name="district.id" type="text" readonly="readonly"/>
                    <input class="required" name="district.game_name" type="text" readonly="readonly"/>
                    <a class="btnLook" href="/admin/channel/gameBack" lookupGroup="district">查找带回</a>
                    <span style="line-height: 18px;color: #ff0000">点击左侧按钮，进行查找</span>
                </dd>

            </dl>

            <dl class="nowrap">
                <dt>游戏包ID：</dt>
                <dd>
                    <input name="district.id" value="" type="hidden"/>
                    <input  style="margin-right: 20px;" class="required" name="district.package_id" type="text" readonly="readonly"/>
                    <input class="required" name="district.package_title" type="text" readonly="readonly"/>
                    <input type="hidden" name="district.package_path"/>
                    <a class="btnLook" href="/admin/channel/packageBack" lookupGroup="district">查找带回</a>
                    <span style="line-height: 18px;color: #ff0000">点击左侧按钮，进行查找</span>

                </dd>
            </dl>
            <ul>
                <li ><div style="margin: 10px"class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
                <li ><div style="margin: 10px"class="button"><div class="buttonContent"><button class="close" type="button">关闭</button></div></div></li>
            </ul>
        </div>
        <input type="hidden" name="channel_id" value="<?php echo $channel_id?>">
        <input type="hidden" name="sub_id" value="<?php echo $sub_id?>">
        <input type="hidden" name="action" value="save">
    </form>
</div>