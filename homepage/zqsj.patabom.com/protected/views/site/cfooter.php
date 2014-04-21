<div class="copy">
    <p class="p_t20"><a href="/site/aboutUs" >关于我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/site/job" >加入我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/site/coop" >合作洽谈</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/site/contact" >联系我们</a></p>
    <p class="p_t6">Copyright&nbsp;&nbsp;2011 - 2013&nbsp;&nbsp;Bojoy.&nbsp;All&nbsp;Rights&nbsp;Reserved.&nbsp;&nbsp;Patabom&nbsp;&nbsp;版权所有</p>
</div>
</div>
</div>
</div>
<script>
    <!--
    var speed=45;
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
</script>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        SlideShow(3000);<!--控制轮播速度-->
        $(".t_title a").bind('click',function(){
            var n=$(this).attr("tip");
            $(".t_title a").removeClass("current");
            $(this).addClass("current");
            $(".news_list").hide();
            $(".news_list").eq(n).show();
        });



    })

</script>


</html>