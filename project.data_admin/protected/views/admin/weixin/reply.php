

<div class="pageContent">
    <div class="tabs" currentIndex="0" eventType="click">
        <div class="tabsHeader">
            <div class="tabsHeaderContent">
                <ul>
                    <li><a href="javascript:;"><span>发送文本消息</span></a></li>
                    <li><a href="javascript:;"><span>发送图片消息</span></a></li>
<!--                    <li><a href="demo_page2.html" class="j-ajax"><span>标题3</span></a></li>-->
                </ul>
            </div>
        </div>

        <div class="tabsContent" >
<!--            //*text*/-->
            <div>
                <div class="pageContent">
                    <form action="/admin/weixin/sendText" method="post" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, navTabAjaxDone);">
                        <div class="pageFormContent" layouth="10" style="height: 669px; overflow: auto;">
                            <div class="unit"><label>收件人：</label><input type="text" size="30" name="table48[title]" value="<?php echo $nick?base64_decode($nick):''?>" disabled="disabled" class="textInput"><span class="inputInfo">&nbsp;收件人</span></div>
                            <div class="unit"><label>信件内容：</label><textarea cols="40" rows="3" name="content" class="textInput"></textarea><span class="inputInfo">&nbsp;信件内容</span></div>

                            <dl class="nowrap">
                                <dt>&nbsp;</dt>
                                <dd><button type="submit">发送</button>&nbsp;&nbsp;<button type="button" class="close">取消</button></dd>
                            </dl>
                        </div>

                        <input type="text" name="openid" value="<?php echo Yii::app()->request->getParam('openid')?>">
                        <input type="hidden" name="action" value="send">
                        <input type="hidden" name="message_type" value="text">


                    </form>
                </div>
            </div>
<!--            /*text*/-->

            <div>
<!--                /*pic*/-->
                <div>
                    <div class="pageContent">
                        <form action="/admin/weixin/sendText" method="post" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, navTabAjaxDone);">
                            <div class="pageFormContent" layouth="10" style="height: 669px; overflow: auto;">
                                <div class="unit"><label>收件人：</label><input type="text" size="30" name="table48[title]" value="<?php echo $nick?base64_decode($nick):''?>" disabled="disabled" class="textInput"><span class="inputInfo">&nbsp;收件人</span></div>
                                <div class="unit"><label>选择图片：</label>
                                    <input type="file" name="pic"/><span style="color: red">(支持jpg格式，大小限制128K)</span>

                                <dl class="nowrap">
                                    <dt>&nbsp;</dt>
                                    <dd><button type="submit">发送</button>&nbsp;&nbsp;<button type="button" class="close">取消</button></dd>
                                </dl>
                            </div>

                            <input type="hidden" name="openid" value="<?php echo Yii::app()->request->getParam('openid')?>">
                            <input type="hidden" name="action" value="send">
                            <input type="hidden" name="message_type" value="pic">

                        </form>
                    </div>
                </div>

<!--                /*pic*/-->
            </div>
        </div>



        <div class="tabsFooter">
            <div class="tabsFooterContent"></div>
        </div>
    </div>

    <p>&nbsp;</p>

</div>