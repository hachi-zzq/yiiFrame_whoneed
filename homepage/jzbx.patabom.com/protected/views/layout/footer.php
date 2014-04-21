<script>
    function close0()  {
        $('apDiv').style.display='none';
    }
</script>

<a href="/game" target="_blank">
    <div id="game" style="right:30px; position:fixed; width:122px; height:237px; z-index:2; background-image:url(/images/game.gif);float:left; top:50px;">

    </div>
</a>

<div id="apDiv" style="right:20px; position:fixed; width:140px; height:200px; z-index:2; background-image:url(/images/qrcode_right.jpg);float:left; bottom: 90px;">
    <img src="/images/close.png" onClick="$('#apDiv').hide()" style="cursor: pointer;float: right;padding: 5px;"/>
</div>

<div class="copy">
    <p class="p_t20"><a href="/archives/aboutUs" target="_blank">关于我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/article/job" target="_blank">加入我们</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/archives/coo" target="_blank">合作洽谈</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/archives/conntract" target="_blank">联系我们</a></p>
    <p class="p_t6">Copyright&nbsp;&nbsp;<?php echo date('Y'); ?>&nbsp;&nbsp;Patabom.&nbsp;All&nbsp;Rights&nbsp;Reserved.&nbsp;&nbsp;版权所有&nbsp;&nbsp;闽ICP备12009280号-14</p>
</div>
</div>
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
<script type="text/javascript">
    $(function(){
        $(".floor-maskItem").mouseover(function(){
            $(this).addClass("qq").parent().addClass("hover");
        }).mouseout(function(){
                $(this).removeClass("qq").parent().removeClass("hover");
            });
    })
</script>
<!-- 客服关闭按钮-->
<script type="text/javascript">
    $(document).ready(function(){
        $('#close').on('click',function(){
            $('#r_bj').hide();
        })
    })
</script>
</body>
</html>