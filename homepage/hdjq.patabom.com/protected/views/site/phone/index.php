<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>皇帝崛起-首页</title>
    <link id="style" type="text/css" rel="stylesheet" />

    <link href="/phone_css/css.css" rel="stylesheet" type="text/css">
    <link href="/phone_css/index.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="/phone_js/slideshow.js"></script>
    <!--demo展示所用css end-->
    <!--组件依赖css begin-->
    <link rel="stylesheet" type="text/css" href="/phone_css/slider.css">
    <link rel="stylesheet" type="text/css" href="/phone_css/slider.default.css"> <!--皮肤文件，若不使用该皮肤，可以不加载-->
    <!--组件依赖css end-->
    <!--组件依赖js begin-->
    <script type="text/javascript" src="/phone_js/zepto.js"></script>
    <script type="text/javascript" src="/phone_js/touch.js"></script>
    <script type="text/javascript" src="/phone_js/matchMedia.js"></script><style>.gmu-media-detect{-webkit-transition: width 0.001ms; width: 0; position: absolute; clip: rect(1px, 1px, 1px, 1px);}
        @media screen and (width: 617px) { #gmu-media-detect0 { width: 1px; } }
    </style>
    <script type="text/javascript" src="/phone_js/event.ortchange.js"></script>
    <script type="text/javascript" src="/phone_js/parseTpl.js"></script>
    <script type="text/javascript" src="/phone_js/gmu.js"></script>
    <script type="text/javascript" src="/phone_js/event.js"></script>
    <script type="text/javascript" src="/phone_js/widget.js"></script>
    <script type="text/javascript" src="/phone_js/slider.js"></script>
    <script type="text/javascript" src="/phone_js/arrow.js"></script>
    <script type="text/javascript" src="/phone_js/dots.js"></script>
    <script type="text/javascript" src="/phone_js/$touch.js"></script>
    <!--组件依赖js end-->
</head>
<body>
<div class="top">
    <img src="/phone_images/top.png" alt="" usemap="#Map" class="image image-full">
    <map name="Map">
        <area shape="rect" coords="-7,18,273,165" href="/">
    </map>
</div>
<?php include 'download.php'?>

<div class="con">
    <div class="news_t m_t12">
        <ul id="t_list" class="t_list clearfix">
            <li><a href="javascript:void(0)" id="list1" class="current" tip="0"><span>新闻</span></a></li>
            <li><a href="javascript:void(0)" id="list2" tip="1"><span>公告</span></a></li>
            <li><a href="javascript:void(0)" id="list3" tip="2"><span>活动</span></a></li>

        </ul>
    </div>
    <div class="news_c p_t10">
        <div class="news" style="display:block">
            <?php
                //more news
                $objNews = Pdw_homepage_article::model()->findAll(array(
                    'condition'=> 'type = 1',
                    'limit'    =>  6,
                    'order'    => 'recommendflag desc, id DESC'
                ));
            ?>
            <ul class="news_list">
                <?php
                    if($objNews){
                        foreach($objNews as $news){
                 ?>

                <li><a href="/site/new_detail?id=<?php echo $news['id']?>" title="<?php echo $news['title']?>"><?php echo $news['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($news['submit_date']))?></span></li>
                <?php
                        }
                    }
                ?>
            </ul>
            <div class="more"><a href="/site/new_index">更多>></a></div>
        </div>
        <div class="news" style="display:none">
            <ul class="news_list">
                <?php
                //more news
                $objNews = Pdw_homepage_article::model()->findAll(array(
                    'condition'=> 'type = 2',
                    'limit'    =>  6,
                    'order'    => 'recommendflag desc, id DESC'
                ));
                ?>
                <?php
                if($objNews){
                    foreach($objNews as $news){
                        ?>

                        <li><a href="/site/new_detail?id=<?php echo $news['id']?>" title="<?php echo $news['title']?>"><?php echo $news['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($news['submit_date']))?></span></li>
                    <?php
                    }
                }
                ?>
            </ul>
            <div class="more"><a href="/site/new_index">更多>></a></div>
        </div>
        <div class="news" style="display:none">
            <ul class="news_list">
                <?php
                //more news
                $objNews = Pdw_homepage_article::model()->findAll(array(
                    'condition'=> 'type = 15',
                    'limit'    =>  6,
                    'order'    => 'recommendflag desc, id DESC'
                ));
                ?>
                <?php
                if($objNews){
                    foreach($objNews as $news){
                        ?>

                        <li><a href="/site/new_detail?id=<?php echo $news['id']?>" title="<?php echo $news['title']?>"><?php echo $news['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($news['submit_date']))?></span></li>
                    <?php
                    }
                }
                ?>
            </ul>
            <div class="more"><a href="/site/new_index">更多>></a></div>
        </div>

    </div>


</div>
<div class="clear"></div>
<div class="con02">
    <ul>
        <li><img src="/phone_images/tu01.png" class="image image-full"></li>
        <li><img src="/phone_images/tu02.png" class="image image-full"></li>
    </ul>
</div>

<div class="con03">
    <div class="title01">
        游戏特色
    </div>
    <div class="tese">
        <!--<div id="demo">
            <div id="con_center_ny">
            <div id="content_qyzs">
            <div class="content_qyzs">
                        <ul>
                           <li><img src="images/tu03.png" alt="" class="image image-full"></li>
                           <li><img src="images/tu04.png" alt="" class="image image-full"></li>
                           <li><img src="images/tu03.png" alt="" class="image image-full"></li>
                           <li><img src="images/tu04.png" alt="" class="image image-full"></li>
                           <li><img src="images/tu03.png" alt="" class="image image-full"></li>
                           <li><img src="images/tu04.png" alt="" class="image image-full"></li>
                           <li><img src="images/tu03.png" alt="" class="image image-full"></li>
                           <li><img src="images/tu04.png" alt="" class="image image-full"></li>
                          </ul>
                      </div>
            </div>
            <div id="demo2"></div>
            </div>
            </div>-->
        <div id="slider" class="ui-slider">

            <div class="ui-slider-group" style="">
                <div class="ui-slider-item" data-index="0" style=" left: 0px; -webkit-transition: 0ms; transition: 0ms; -webkit-transform: translate(0px, 0px) translateZ(0px);">
                    <a href="http://www.baidu.com/"><img src="/phone_images/tu03.png" alt="" ></a>

                </div>
                <div class="ui-slider-item" data-index="1" style=" left: -617px; -webkit-transition: 0ms; transition: 0ms; -webkit-transform: translate(617px, 0px) translateZ(0px);">
                    <a href="http://www.baidu.com/"><img src="/phone_images/tu04.png" alt=""></a>

                </div>
                <div class="ui-slider-item" data-index="2" style=" left: -1234px; -webkit-transition: 0ms; transition: 0ms; -webkit-transform: translate(617px, 0px) translateZ(0px);">
                    <a href="http://www.baidu.com/"><img src="/phone_images/tu03.png" alt=""></a>

                </div>
                <div class="ui-slider-item" data-index="3" style=" left: -1851px; -webkit-transition: 0ms; transition: 0ms; -webkit-transform: translate(617px, 0px) translateZ(0px);">
                    <a href="http://www.baidu.com/"><img src="/phone_images/tu04.png" alt=""></a>

                </div>
                <div class="ui-slider-item" data-index="4" style=" left: -1851px; -webkit-transition: 0ms; transition: 0ms; -webkit-transform: translate(617px, 0px) translateZ(0px);">
                    <a href="http://www.baidu.com/"><img src="/phone_images/tu03.png" alt=""></a>

                </div>
                <div class="ui-slider-item" data-index="5" style=" left: -1851px; -webkit-transition: 0ms; transition: 0ms; -webkit-transform: translate(617px, 0px) translateZ(0px);">
                    <a href="http://www.baidu.com/"><img src="/phone_images/tu04.png" alt=""></a>

                </div></div></div>
        <script>
            //创建slider组件
            $('#slider').slider({loop:true});
        </script>
        <!--淡淡的-->

    </div>
</div>

<div class="con04">
    <div class="title01">
        游戏介绍
    </div>
    <div class="jieshao">
        《皇帝崛起》online安卓版将于2014年1月14日闪亮测试。
        《皇帝崛起》online真实重现中国古代各种经典战役，挑战历史名将，收集名将武魂。吕布”、“关羽”、“李广”等丰富的武魂等你来发掘！同时各式各样的副本系统和AI设定让你在副本中酣畅淋漓，所向披靡！
        爱江山也爱美人。创新特色的美女系统，让玩家能直接和古代美女亲密接触，抚慰恩宠获得亲密度。西施，貂蝉，李师师...让美女来帮你一起成就帝王之路！
    </div>
</div>
<div class="copyright">Copyright  2014  Patabom. All Rights Reserved.  版权所有  闽ICP备12009280号-14</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#t_list li a").bind('click',function(){
            var n=$(this).attr("tip");
            $("#t_list li a").removeClass("current");
            $(this).addClass("current");
            $(".news").hide();
            $(".news").eq(n).show();
        });
    })

</script>

<!--
<script>
<!--
var speed=10;
var tab=document.getElementById("demo");
var tab1=document.getElementById("content_qyzs");
var tab2=document.getElementById("demo2");
tab2.innerHTML=tab1.innerHTML;
function Marquee(){
if(tab2.offsetWidth-tab.scrollLeft<=0)
tab.scrollLeft-=tab1.offsetWidth
else{
tab.scrollLeft++;
}
}
var MyMar=setInterval(Marquee,speed);
tab.onmouseover=function() {clearInterval(MyMar)};
tab.onmouseout=function() {MyMar=setInterval(Marquee,speed)};
-->
<!--</script>-->
</body>

</html>
