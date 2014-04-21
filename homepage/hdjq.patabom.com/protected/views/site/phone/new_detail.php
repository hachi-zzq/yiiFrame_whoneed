<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>皇帝崛起-新闻详情</title>
    <link id="style" type="text/css" rel="stylesheet" />

    <link href="/phone_css/css.css" rel="stylesheet" type="text/css">
    <link href="/phone_css/newsdetail.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/phone_js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/phone_js/slideshow.js"></script>

</head>
<body>
<div class="top">
    <img src="/phone_images/top.png" alt="" usemap="#Map" class="image image-full">
    <map name="Map">
        <area shape="rect" coords="5,20,285,167" href="/">
    </map>
</div>
<div class="download">
    <ul>
        <li class="left"><a href="#"><img src="/phone_images/download01.png" alt="" class="image image-full"></a></li>
        <li class="right"><a href="#"><img src="/phone_images/download02.png" alt="" class="image image-full"></a></li>
    </ul>
</div>

<div class="con">
    <div class="news_t">
        <p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="/site/new_index">新闻</a> >> <a href="#" class="current">详情</a></p>
    </div>
    <?php
        $objData = HP::get_hp_article_content_obj($_GET['id']);
    ?>
    <div class="box">
        <div class="content_t">
            <h1><?php echo $objData['title']?></h1>
            <p>作者：<span><?php echo $objData['author']?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $objData['submit_date']?></span></p>
        </div>
        <div class="content_c">
            <?php
                $content = Pdw_homepage_article_content::model()->find("id = '{$_GET['id']}'")->intro;
                $content = preg_replace('/<img.+src=\"(.+\.(jpg|gif|bmp|bnp|png))\".+>/iU','<img src=\1 width=100% />',$content);
                echo $content;
            ?>
        </div>
    </div>
</div>
<div class="copyright">Copyright  2014  Patabom. All Rights Reserved.  版权所有  闽ICP备12009280号-14</div>

</body>

</html>
