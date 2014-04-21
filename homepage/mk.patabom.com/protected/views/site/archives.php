<?php include 'cheader.php'?>
<link rel="stylesheet" href="/css/newsDetail.css" type="text/css">
<!--[if lte IE 6]>
<style type="text/css">
    * html,* html body /* 修正IE6振动bug */{
        background-image:url(about:blank);background-attachment:fixed;
    }
    #nav /* IE6 头部固定 */{
        position:absolute;bottom:auto;top:expression(eval(document.documentElement.scrollTop));
    }
</style>
<script src="js/DD_belatedPNG.js" type="text/javascript"></script>
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
                <p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="<?php echo $fLink?>"><?php echo $fLinkName?></a></a></p>
                <div class="box m_t12 pad15 m_h500">
                    <div class="content_t">
                        <h1><?php echo $game_info->title?></h1>
                    </div>
                    <div class="content_c">
                        <?php
                        echo $game_info->intro;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'cfooter.php'?>
