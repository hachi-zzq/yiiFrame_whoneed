<?php include 'cheader.php'?>
    <link rel="stylesheet" href="/css/download.css" type="text/css">
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
                    <div class="con_top_left"> <span>下载中心</span></div>

                    <div class="con_top_center_ny"><p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="#" class="current">下载中心</a></p></div>
                    <div class="con_top_right_ny"> </div>
                </div>
                <div class="con_center_ny m_h350">
                    <div class="content_ny">
                        <div class="box m_t12 pad15 m_h500">
                            <div class="clearfix"></div>
                            <div class="title and_icon">Android下载</div>
                            <?php
                                $objQrcode = Pdw_homepage_qrcode::model()->find('id=39');
                            ?>
                            <div class="content_d">
                                <img alt="" border="0" src="<?php echo Yii::app()->params['img_domain'].$objQrcode->qrcode_img?>" width="141" height="141" />
                                <p class="p_t10">版本号：1.0.0</p>
                                <P>大小：<?php echo $objQrcode->size?>MB</P>
                                <a href="<?php echo $objQrcode->download_url?>">&nbsp;</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="con_bottom clearfix">
                    <div class="con_bottom_left"></div>
                    <div class="con_bottom_center"></div>
                    <div class="con_bottom_right"></div>
                </div>
            </div>
<?php include 'cfooter.php'?>
