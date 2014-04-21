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

    <div class="logo"><img src="/images/phone/logo.png" width="230" height="21"></div>
</div>

<div class="title">
    <div class="title01">在线问题表单答疑</div>
    <div class="title02">在线问题表单答疑是直接联系我们的一个快速通道，可以通过表单答疑系统提交您所遇到的问题详细描述，我们将通过最快捷的方式回复您。</div>
    <h1></h1>
    <span></span>
</div>

<div class="con">
    <div class="btn01"><a href="/question/phoneSubmit?role_name=<?php echo $params['role_name']?>&game_area=<?php echo $params['game_area']?>"><b>提交您的问题</b><span><img src="/images/phone/ico01.png"></span></a></div>
    <div class="btn01"><a href="/question/myPhoneQuestion?role_name=<?php echo $params['role_name']?>&game_area=<?php echo $params['game_area']?>"><b>查询处理结果</b><span><img src="/images/phone/ico01.png"></span></a></div>
    <div class="btn01"><a href="http://www.patabom.com/faq"><b>FAQ自助查询</b><span><img src="/images/phone/ico01.png"></span></a></div>

</div>

</body>
</html>
