<?php include 'cheader.php'?>
    <link rel="stylesheet" href="/css/customer.css" type="text/css">
    <script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
    <!--[if lte IE 6]>
    <style type="text/css">
        * html,* html body /* 修正IE6振动bug */{
            background-image:url(about:blank);background-attachment:fixed;
        }
        #nav /* IE6 头部固定 */{
            position:absolute;bottom:auto;top:expression(eval(document.documentElement.scrollTop));
        }
    </style>
    <script src="/js/DD_belatedPNG.js" type="text/javascript"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('div, ul, p, img, li, input , a , span');
    </script>
    <![endif]-->
</head>
<body>
<div id="main_body">
    <div id="main_footer_index">
     <?php include 'nav.php'?>
        <div id="main_ny">
            <div class="content" style="padding-bottom:100px;">
                <p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="/site/customer" class="current">客服中心</a></p>
                <div class="box m_t12 pad15 m_h500">
                    <h1>联系客服</h1>
                    <p class="border p_b10">&nbsp;</p>
                    <div class="cus" style="margin-bottom: 50px;">
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
