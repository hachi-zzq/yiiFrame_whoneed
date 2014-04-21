<div class="gamesDetail_right">
    <div class="gRight_title">应用中心</div>
    <div class="gRight_content">
        <div class="views-list"> <a href="javascript:void(0);" class="prev disabled-btn" rel="nofollow"></a>
            <div  class="view-wrap">
                <div class="items">
                    <ul class="J_pro_view">
                        <?php
                            if(isset($gameList) && !empty($gameList)){
                                foreach($gameList as $gm){
                        ?>
                        <li><a href="<?php echo Yii::app()->createUrl('game/gameDetail/id').'/'.$gm->id?>" ><img alt="" border="0" width="200" height="100" src="<?php echo Yii::app()->params['img_domain'].$gm->img_thumb?>" /></a></li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <a href="javascript:void(0);" class="next" rel="nofollow"></a> </div>
    </div>
</div>
<script src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var page=1;//初始为第一版
        var J_pro=$(".J_pro_view");//图片列表区域
        var view_wrap=$(".view-wrap").height();//图片显示固定范围
        var total=$(".J_pro_view li").length;//图片总数
        var num=6;//每页显示的条数
        var total_page=Math.round(total/num);//总页数
        //下一页
        if (page == total_page) {
            // 最后一版，动画跳回第一版
            $(".next").addClass("disabled-btn");
            return false;
            //J_pro.animate({"margin-left": "0px" }, 300);//如果是是最后一屏就回到第一屏
            //page = 1;
        }
        $(".next").click(function(){
            if (!J_pro.is(":animated")) {  // 如果正处于动画中的则不进行动画
                if (page == total_page) {
                    // 最后一版，动画跳回第一版
                    $(this).addClass("disabled-btn");
                    return false;
                    //J_pro.animate({"margin-left": "0px" }, 300);//如果是是最后一屏就回到第一屏
                    //page = 1;
                }
                else {
                    // 跳到下一版

                    $(".prev").removeClass("disabled-btn");
                    $(this).removeClass("disabled-btn");
                    J_pro.animate({ "margin-top": "-=" + view_wrap }, 672);
                    page++;
                    if (page == total_page) {
                        // 最后一版，动画跳回第一版
                        $(this).addClass("disabled-btn");
                        return false;
                        //J_pro.animate({"margin-left": "0px" }, 300);//如果是是最后一屏就回到第一屏
                        //page = 1;
                    }
                }
            }
        });
        //上一页
        $(".prev").click(function(){
            if (!J_pro.is(":animated")) {  // 如果正处于动画中的则不进行动画
                if (page == 1) {
                    // 第一个版面，动画跳到最后一版
                    $(this).addClass("disabled-btn");
                    return false;
                    //J_pro.animate({"margin-left": "-=" + view_wrap * (total_page - 1) }, 300);//如果是
                    //page = total_page;
                }
                else {
                    // 跳到下一版

                    $(".next").removeClass("disabled-btn");
                    $(this).removeClass("disabled-btn");
                    J_pro.animate({ "margin-top": "+=" + view_wrap }, 672);
                    page--;
                    if (page == 1) {
                        // 第一个版面，动画跳到最后一版
                        $(this).addClass("disabled-btn");
                        return false;
                        //J_pro.animate({"margin-left": "-=" + view_wrap * (total_page - 1) }, 300);//如果是
                        //page = total_page;
                    }
                }
            }
        });
    })
</script>