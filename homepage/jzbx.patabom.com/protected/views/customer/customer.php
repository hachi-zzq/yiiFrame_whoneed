<?php include YII_ROOT.'/views/layout/header_t.php'?>

<link rel="stylesheet" href="/css/customer.css" type="text/css">
<?php include YII_ROOT.'/views/layout/header_b.php'?>

<body>
<div id="main_body">
    <div id="main_top">
        <?php include YII_ROOT.'/views/includes/nav.php'?>
    </div>
    <div class="content box">
        <div class="box_title clearfix">
            <div class="con_top_left"> <span>客服中心</span></div>

            <div class="con_top_center_ny"><p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="#" class="current">客服中心</a></p></div>

        </div>
        <div class="con_center_ny">
            <div class="content_ny">
                <div class="box m_t12 p_b100 m_h500">

                    <div class="cus">
                        <?php
                        if($objCall){
                            echo $objCall->intro;
                        }
                        ?>
                    </div>
                    <h1 class="m_t40">常见问题</h1>
                    <p class="border">&nbsp;</p>
                    <p class="title">下载问题<span tip="0">&nbsp;</span></p>
                    <div class="question" style="display:none">
                        <?php
                        if($objDown){
                            foreach($objDown as $k=>$down){
                                $content = Pdw_homepage_article_content::model()->find("id='{$down['id']}'")->intro;
                                ?>
                                <p><?php echo $k+1,'、'.$down->title?></p>
                                <p><?php echo $content?></p>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <p class="border1">&nbsp;</p>
                    <p class="title">安装问题<span tip="1">&nbsp;</span></p>
                    <div class="question" style="display:none">
                        <?php
                        if($install){
                            foreach($install as $k=>$down){
                                $content = Pdw_homepage_article_content::model()->find("id='{$down['id']}'")->intro;
                                ?>
                                <p><?php echo $k+1,'、'.$down->title?></p>
                                <p><?php echo $content?></p>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <p class="border1">&nbsp;</p>
                    <p class="title">账号问题<span tip="2">&nbsp;</span></p>
                    <div class="question" style="display:none">
                        <?php
                        if($account){
                            foreach($account as $k=>$down){
                                $content = Pdw_homepage_article_content::model()->find("id='{$down['id']}'")->intro;
                                ?>
                                <p><?php echo $k+1,'、'.$down->title?></p>
                                <p><?php echo $content?></p>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <p class="border1">&nbsp;</p>
                    <p class="title">安全问题<span tip="3">&nbsp;</span></p>
                    <div class="question" style="display:none">
                        <?php
                        if($safe){
                            foreach($safe as $k=>$down){
                                $content = Pdw_homepage_article_content::model()->find("id='{$down['id']}'")->intro;
                                ?>
                                <p><?php echo $k+1,'、'.$down->title?></p>
                                <p><?php echo $content?></p>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <p class="border1">&nbsp;</p>
                    <p class="title">用户协议<span tip="4">&nbsp;</span></p>
                    <div class="question" style="display:none">
                        <?php
                        if($user){
                            foreach($user as $k=>$down){
                                $content = Pdw_homepage_article_content::model()->find("id='{$down['id']}'")->intro;
                                ?>
                                <p><?php echo $k+1,'、'.$down->title?></p>
                                <p><?php echo $content?></p>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <p class="border1">&nbsp;</p>
                    <p class="title">充值问题<span tip="5">&nbsp;</span></p>
                    <div class="question" style="display:none">
                        <?php
                        if($recharge){
                            foreach($recharge as $k=>$down){
                                $content = Pdw_homepage_article_content::model()->find("id='{$down['id']}'")->intro;
                                ?>
                                <p><?php echo $k+1,'、'.$down->title?></p>
                                <p><?php echo $content?></p>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <p class="border1">&nbsp;</p>
                    <p class="title">客户端问题<span tip="6">&nbsp;</span></p>
                    <div class="question" style="display:none">
                        <?php
                        if($ke){
                            foreach($ke as $k=>$down){
                                $content = Pdw_homepage_article_content::model()->find("id='{$down['id']}'")->intro;
                                ?>
                                <p><?php echo $k+1,'、'.$down->title?></p>
                                <p><?php echo $content?></p>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <p class="border1">&nbsp;</p>
                    <p class="title">登录运行问题<span tip="7">&nbsp;</span></p>
                    <div class="question" style="display:none">
                        <?php
                        if($run){
                            foreach($run as $k=>$down){
                                $content = Pdw_homepage_article_content::model()->find("id='{$down['id']}'")->intro;
                                ?>
                                <p><?php echo $k+1,'、'.$down->title?></p>
                                <p><?php echo $content?></p>
                            <?php
                            }
                        }
                        ?>
                    </div>
                    <p class="border1">&nbsp;</p>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    $(document).ready(function(){
        $('.title span').toggle(
            function(){
                var n=$(this).attr("tip");
                $('.title span').removeClass("current");
                $(this).addClass("current");
                $(".question").hide();
                $(".question").eq(n).slideDown("fast");
            },
            function(){
                var n=$(this).attr("tip");
                $(this).removeClass("current");
                $(".question").eq(n).hide("fast");
            });
    })
</script>
    <?php include YII_ROOT.'/views/layout/footer.php'?>
