<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>微信中间页</title>
    <link id="style" type="text/css" rel="stylesheet" />
    <style>
        body {
            background:url(/wx_img/main_bj.png) no-repeat left top;width:100%;height:100%;
            margin:0;
            padding:0;
        }
        .btn2 {
            width: 70%;min-width:320px;
        }
        body .con {
            width: 100%;
            /*min-height: 420px;*/
        }

            /*body.fullscreen>* {
                min-height: 460px !important;
            }

            body.fullscreen.black-translucent>* {
                min-height: 480px !important;
            }

            body.landscape>.content {
                min-height: 320px;
            }*/

        .con {
            min-width: 315px;
            overflow: hidden;
            overflow-x: hidden;
        }


        body.landscape .bd .bread li.ellips {
            width: auto;
        }

        .commonBtn {
            height: 60px;
            line-height: 60px;
            color: #333;
            letter-spacing: 2px;
            text-align: center;
            text-shadow: 1px 1px 1px #fff;
            font-size: 14px;
            font-weight: 700;
            border: 1px #fff solid;
            background-color: #fff;
            -webkit-border-radius: 3px;
            background: -webkit-gradient(linear, left top, left bottom, from(#fff),
            to(#afaac2) );
            -webkit-box-shadow: 1px 2px 2px #c5c5c5;
            -webkit-box-shadow: inset 1px 1px 1px #fff;filter:alpha(opacity=60);
            -moz-opacity:0.6;
            opacity:0.6; font-family:"黑体";font-size:22px; font-weight:bold;
        }
        .content{ text-align:center;margin-top:5%;}
        .content a:hover{
            color: #333;
            letter-spacing: 2px;
            text-align: center;
            text-shadow: 1px 1px 1px #fff;
            font-size: 14px;
            font-weight: 700;
            border: 1px #fff solid;
            background-color: #fff;

            background: -webkit-gradient(linear, left top, left bottom, from(#fff),
            to(#afaac2) );
            -webkit-box-shadow: 1px 2px 2px #c5c5c5;
            -webkit-box-shadow: inset 1px 1px 1px #fff;filter:alpha(opacity=70);
            -moz-opacity:0.7;
            opacity:0.7; font-family:"黑体";font-size:22px; font-weight:bold;}

        .content a:active{
            color: #333;
            letter-spacing: 2px;
            text-align: center;
            text-shadow: 1px 1px 1px #fff;
            font-size: 14px;
            font-weight: 700;
            border: 1px #fff solid;
            background-color: #fff;

            background: -webkit-gradient(linear, left top, left bottom, from(#fff),
            to(#afaac2) );
            -webkit-box-shadow: 1px 2px 2px #c5c5c5;
            -webkit-box-shadow: inset 1px 1px 1px #fff;filter:alpha(opacity=70);
            -moz-opacity:0.7;
            opacity:0.7; font-family:"黑体";font-size:22px; font-weight:bold;}

        .content a{display:block;width:70%; text-align:center;
            height: 54px;
            line-height: 54px;
            color: #333;
            letter-spacing: 2px;
            text-align: center;
            text-shadow: 1px 1px 1px #fff;
            font-size: 14px;
            font-weight: 700;
            border: 1px #fff solid;
            background-color: #f99022;
            -webkit-border-radius: 8px;
            background: -webkit-gradient(linear, left top, left bottom, from(#fff),
            to(#afaac2) );
            -webkit-box-shadow: 1px 2px 2px #c5c5c5;
            -webkit-box-shadow: inset 1px 1px 1px #fff;filter:alpha(opacity=50);
            -moz-opacity:0.5;
            opacity:0.5; font-family:"黑体";font-size:22px; font-weight:bold; text-decoration:none;
        }

        .content p{display:block;width: 70%; text-align:left;margin:0 auto;padding:10px 0 0 0;

            line-height:40px;
            color: #fff;
            letter-spacing: 2px;

            text-shadow: 1px 1px 1px #463949;
            font-size:1.2em;


            -webkit-border-radius: 3px;
            font-family:"黑体";
        }
        .box
        {width:80%;float:right;margin:10px 15px 3% 0;}
        .image
        {
            display: inline-block;
            outline: 0;
        }

        .image img
        {
            display: block;
            width: 100%;
            border-radius: 8px;
        }

        .image-full
        {
            display: block;
            width: 100%;
            margin: 0 0 2.5em 0;
        }

        .box2{width:70%; text-align:center;margin:0 auto;}

        .box2 a:hover{
            filter:alpha(opacity=80);
            -moz-opacity:0.8;
            opacity:0.8;}


    </style>
</head>
<body>
<div class="con">
    <section class="box"> <img src="/wx_img/tu01.png" alt="" class="image image-full">

    </section>


    <section class="box2"> <a href="<?php echo $apk_url?>" class="image image-full"><img src="/wx_img/btn01.png" alt=""></a>

    </section>
    <div class="content">
        <!--<a><input value="点击立即下载" class="commonBtn btn2 fr" id="companySearch" type="submit"></a>

     <a href="#">立即下载</a>-->
        <p>平台订阅号：patabom<Br />
            平台服务号：ptb_cs
        </p>
    </div>
</div>
</body>
</html>
