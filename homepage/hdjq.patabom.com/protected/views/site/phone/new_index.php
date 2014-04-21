<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>皇帝崛起-新闻</title>
    <link id="style" type="text/css" rel="stylesheet" />

    <link href="/phone_css/css.css" rel="stylesheet" type="text/css">
    <link href="/phone_css/news.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/phone_js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/phone_js/slideshow.js"></script>

</head>
<body>
<div class="top">
    <img src="/phone_images/top.png" alt="" usemap="#Map" class="image image-full">
    <map name="Map">
        <area shape="rect" coords="-7,12,273,159" href="/">
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
    <div class="news_c p_t10" id="more">
        <div class="news" style="display:block">
            <?php
            //more news
            $objNews = Pdw_homepage_article::model()->findAll(array(
                'condition'=> 'type = 1',
                'limit'    =>  6,
                'order'    => 'recommendflag desc, id DESC'
            ));
            ?>
            <ul class="news_list" id="news">
                <?php
                    if($objNews){
                        foreach($objNews as $news){
                ?>

                <li rel="<?php echo $news['id']?>"><a href="/site/new_detail?id=<?php echo $news['id']?>" title="<?php echo $news['title']?>"><?php echo $news['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($news['submit_date']))?></span></li>
                <?php
                        }
                    }
                ?>

            </ul>
            <div class="more" id="news_more"><a onclick="ajaxMore(1,6,'news')">加载更多</a></div>
        </div>
        <div class="news" style="display:none">
            <?php
            //more news
            $objNews = Pdw_homepage_article::model()->findAll(array(
                'condition'=> 'type = 2',
                'limit'    =>  6,
                'order'    => 'recommendflag desc, id DESC'
            ));
            ?>
            <ul class="news_list" id="notice">
                <?php
                if($objNews){
                    foreach($objNews as $news){
                        ?>

                        <li rel="<?php echo $news['id']?>"><a href="/site/new_detail?id=<?php echo $news['id']?>" title="<?php echo $news['title']?>"><?php echo $news['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($news['submit_date']))?></span></li>
                    <?php
                    }
                }
                ?>

            </ul>
            <div class="more" id="notice_more"><a onclick="ajaxMore(2,6,'notice')">加载更多</a></div>
        </div>
        <div class="news" style="display:none">
            <?php
            //more news
            $objNews = Pdw_homepage_article::model()->findAll(array(
                'condition'=> 'type = 15',
                'limit'    =>  6,
                'order'    => 'recommendflag desc, id DESC'
            ));
            ?>
            <ul class="news_list" id="active">
                <?php
                if($objNews){
                    foreach($objNews as $news){
                ?>
                        <li rel="<?php echo $news['id']?>"><a href="/site/new_detail?id=<?php echo $news['id']?>" title="<?php echo $news['title']?>"><?php echo $news['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($news['submit_date']))?></span></li>
                    <?php
                    }
                }
                ?>

            </ul>
            <div class="more" id="active_more"><a  onclick="ajaxMore(15,6,'active')">加载更多</a></div>
        </div>

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

    function ajaxMore(type,limit,id){
        var lastId = $("#"+id+' li:last-child').attr('rel');
        $.ajax({
            url:"/site/MoreList?type="+type+'&lastId='+lastId+'&limit='+limit,
            success:function(res){
//                res = JSON.parse(res);
                res = eval('('+res+')');
                console.log(typeof res);
                var appendStr = '';
                if(res.length>0){
                    for(var i=0;i<res.length;i++){
                        appendStr += '<li rel="'+res[i].id+'">'+
                                     '<a href="/site/new_detail?id='+res[i].id+'" title="'+res[i].title+'">'+res[i].title+'</a>'+
                                     '<span class="time">'+res[i].date+'</span>'+
                                     '</li>';
                    }
                    $('#'+id).append(appendStr);
                }else{
                    $('#'+id+'_more a').remove();
                    $('#'+id+'_more').append("<a>已经到最后了</a>");
                }
            },
            error:function(){
                alert('ajax error');
            }
        })
    }
</script>
</body>

</html>
