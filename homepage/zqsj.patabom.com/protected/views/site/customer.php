<?php include 'cheader.php'?>
    <link rel="stylesheet" href="/css/customer.css" type="text/css">
    <script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
    <!--[if lte IE 6]>
    <script src="/js/DD_belatedPNG.js" type="text/javascript"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('div, ul, p, img, li, input , a , span');
    </script>
    <![endif]-->
</head>
<body>
<div id="main_top">
    <div id="main_footer_ny">
        <div id="main_body">
            <?php include 'nav.php'?>
            <div class="content">
                <div class="con_top clearfix">
                    <div class="con_top_left"> <span>客服中心</span></div>

                    <div class="con_top_center_ny"><p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="/site/customer" class="current">客服中心</a></p></div>
                    <div class="con_top_right_ny"> </div>
                </div>
                <div class="con_center_ny">
                    <div class="content_ny">
                        <div class="box m_t12 pad15 m_h500">

                            <div class="cus">
                                <?php
                                if($objCall){
                                    echo $objCall->intro;
                                }
                                ?>
                            </div>
                            <h1 class="m_t12">常见问题</h1>
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
                            <p class="border1 m_b100">&nbsp;</p>
                        </div>
                    </div>
                </div>
                <div class="con_bottom clearfix">
                    <div class="con_bottom_left"></div>
                    <div class="con_bottom_center"></div>
                    <div class="con_bottom_right"></div>
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
<?php include 'cfooter.php'?>
