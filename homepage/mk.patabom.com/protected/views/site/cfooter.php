<div id="copy" style="margin-top:-80px;">
    <div class="content_copy">
        <p class="d1 p_t32"><a href="/site/aboutUs">关于我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/site/job">加入我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/site/coop">合作洽谈</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/site/contact">联系我们</a></p>
        <p class="d2">Copyright 2011 - 2013 Bojoy. AllRights Reserved. Patabom 版权所有</p>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        SlideShow(3000);<!--控制轮播速度-->

        $("#t_list li a").bind('click',function(){
            var n=$(this).attr("tip");
            $("#t_list li a").removeClass("current");
            $(this).addClass("current");
            $(".news").hide();
            $(".news").eq(n).show();
        });


        $('.down_change a').bind('mouseover',function(){
            var n=$(this).attr("tip");
            $(".down_change a").removeClass("hover");
            $(this).addClass("hover");
            $(".down_content").hide();
            $(".down_content").eq(n).show();
        });

    })

</script>

</body>
</html>