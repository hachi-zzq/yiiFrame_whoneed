<div class="main_top clearfix">
    <div class="top_left"><a class="logo_top pngFix" href="<?php echo Yii::app()->createUrl('site');?>"></a></div>
    <div class="top_right">
        <div class="search_phone clearfix">
            <div class="search">
                <form action="index.html" onsubmit="return searchHeaderFunc();">
                    <input class="topSearchBtn pngFix" type="submit" value="">
                    <input id="head_searchText_id" name="world" type="text" class="topSearchTxt">
                </form>
            </div>
            <div class="phone pngFix">
                <p class="phone_right_top">ptb_cs</p>
                <p class="phone_right_bottom">微信客服</p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    <!--
    function searchHeaderFunc(){
        var world = $.trim($("#head_searchText_id").val());
        if(world == '' || world == null){
            alert("关键词不能为空！");
            return false;
        }

        return true;
    }

    //-->
</script>
<!--[if lte IE 6]>
<style type="text/css">
    html {
        /*这个可以让IE6下滚动时无抖动*/
        background: url(about:black) no-repeat fixed
    }
    .main_fotter{
        position: absolute;
    }
    .main_fotter , .reveal-modal-bg{
        /*这个解决body有padding时，IE6下100%不能铺满的问题*/
        width: expression(offsetParent.clientWidth);
    }
        /*下面三组规则用于IE6下top计算*/
    .main_fotter{
        top: expression(offsetParent.scrollTop + offsetParent.clientHeight-offsetHeight);
    }
</style>
<script src="<?php echo Yii::app()->baseUrl?>js/DD_belatedPNG.js" type="text/javascript"></script>

<script type="text/javascript">
    DD_belatedPNG.fix('div, ul, p, img, li, input , a');
</script>
<![endif]-->