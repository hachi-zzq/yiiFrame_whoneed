<div class="main_fotter">
    <div class="main_fotter_a">
        <div id="nav" pngFix>
            <li id="index"><a id="nav1" class="nav1 pngFix" href="<?php echo Yii::app()->createUrl('/site/')?>"></a></li>
            <li id="game"><a id="nav2" class="nav2 pngFix" href="<?php echo Yii::app()->createUrl('/game/')?>"></a></li>
            <li id="news"><a id="nav3" class="nav3 pngFix" href="<?php echo Yii::app()->createUrl('/news/')?>"></a></li>
            <li id="person"><a id="nav4" class="nav4 pngFix" href="<?php echo Yii::app()->createUrl('/user/')?>"></a></li>
            <li id="money"><a id="nav5" class="nav5 pngFix" href="<?php echo Yii::app()->createUrl('/money/')?>"></a></li>
            <li id="active"><a id="nav6" class="nav6 pngFix" href="<?php echo Yii::app()->createUrl('/activity/')?>"></a></li>
            <li id="mall"><a id="nav7" class="nav7 pngFix" href="<?php echo Yii::app()->createUrl('/mall/')?>"></a></li>
            <li id="forum"><a id="nav8" class="nav8 pngFix" href="http://bbs.patabom.com/" target="_blank"></a></li>
            <li id="customer"><a id="nav9" class="nav9 pngFix" href="<?php echo Yii::app()->createUrl('/customer/')?>"></a></li>
        </div>
    </div>
    <div class="main_fotter_b">
        <p>Copyright (c) 2013 patabom.com.All Rights Reserved 闽网文[2012]0747-013号 闽ICP备12009280号-14</p>
    </div>
</div>
<!--<script src="--><?php //echo Yii::app()->baseUrl?><!--/js/DD_belatedPNG.js"></script>-->

<script type="text/javascript">
    //判断浏览器是否支持 placeholder属性
    function isPlaceholder(){
        var input = document.createElement('input');
        return 'placeholder' in input;
    }

    if (!isPlaceholder()) {//不支持placeholder 用jquery来完成
        $(document).ready(function() {
            if(!isPlaceholder()){
                $("input").not("input[type='password']").each(//把input绑定事件 排除password框
                    function(){
                        if($(this).val()=="" && $(this).attr("placeholder")!=""){
                            $(this).val($(this).attr("placeholder"));
                            $(this).focus(function(){
                                if($(this).val()==$(this).attr("placeholder")) $(this).val("");
                            });
                            $(this).blur(function(){
                                if($(this).val()=="") $(this).val($(this).attr("placeholder"));
                            });
                        }
                    });
                //对password框的特殊处理1.创建一个text框 2获取焦点和失去焦点的时候切换
                //--------------------------------------------------------------------
                //对Password框循环开始
                $("input[type='password']").each(
                    function(){
                        var pwdField= $(this);
                        var pwdVal= pwdField.attr('placeholder');
                        var pwdId=pwdField.attr('id')+'1';
                        pwdField.after('<input id="'+pwdId+'" class="inputText" type="text" value='+pwdVal+' autocomplete="off" />');
                        var pwdPlaceholder= $("#"+pwdId);
                        pwdPlaceholder.show();
                        pwdField.hide();
                        pwdPlaceholder.focus(function(){
                            pwdPlaceholder.hide();
                            pwdField.show();
                            pwdField.focus();
                        });
                        pwdField.blur(function(){
                            if(pwdField.val() == '') {
                                pwdPlaceholder.show();
                                pwdField.hide();
                            }
                        });
                    });

                //对Password框循环结束

            }
        });
    }
</script>
<?php
    if($current == 'index'){
        MyFunction::addClass('index','current');
    }
if($current == 'game'){
    MyFunction::addClass('game','current');
}
if($current == 'news'){
    MyFunction::addClass('news','current');
}
if($current == 'person'){
    MyFunction::addClass('person','current');
}
if($current == 'money'){
    MyFunction::addClass('money','current');
}
if($current == 'mall'){
    MyFunction::addClass('mall','current');
}
if($current == 'active'){
    MyFunction::addClass('active','current');
}
if($current == 'forum'){
    MyFunction::addClass('forum','current');
}
if($current == 'customer'){
    MyFunction::addClass('customer','current');
}

?>