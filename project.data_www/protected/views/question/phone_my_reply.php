<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>客服页面</title>
    <link id="style" type="text/css" rel="stylesheet" />

    <link href="/css/phone/css.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="top">
    <div class="fh"><a href="/question/phoneQuestion?role_name=<?php echo $_GET['role_name']?>&game_area=<?php echo $_GET['game_area']?>"><img src="/images/phone/fh.png" width="60" height="94"></a></div>
    <div class="logo"><img src="/images/phone/logo.png" width="230" height="21"></div>
</div>

<div class="title">
    <div class="title01">在线问题表单答疑</div>
    <div class="title02">在线问题表单答疑是直接联系我们的一个快速通道，可以通过表单答疑系统提交您所遇到的问题详细描述，我们将通过最快捷的方式回复您。</div>
    <h1></h1>
    <span></span>
</div>


<div class="con01">

    <div class="jieguo">
        <?php
            if( ! $reply){
                echo '<li style="text-align: center;margin: 10px;">您没有提问或者您的提问正在处理，请耐心等待</li>';
                exit;
            }

            $typeName = Pdw_question_type::model()->find("id='{$reply['question_type']}'")->type_name;
        ?>
        <ul>
        <li><span>服务器：</span><?php echo $reply['game_area']?></li>

            <li><span>角色名：</span><?php echo $reply['role_name']?></li>
            <li><span>问题类型：</span><?php echo $typeName?>
            </li>
            <li><span>问题详情：</span>
                <b><?php echo $reply['question_description']?></b>
            </li>
            <li><span>客服回复：</span>
                <i><?php echo $reply['reply_content']?></i>
            </li>
            <li class="btn">
                <input type="button" value="关闭"  class="from_btn01" onclick="javascripts:window.location='/question/phoneQuestion?role_name=<?php echo $reply['role_name']?>&game_area=<?php echo $reply['game_area']?>'">
                <input type="button" id="id_reset" value="继续提交" onclick="javascripts:window.location='/question/phoneSubmit?role_name=<?php echo $reply['role_name']?>&game_area=<?php echo $reply['game_area']?>'"  class="from_btn02"></li>

        </ul>

    </div>
</div>


</body>
</html>
