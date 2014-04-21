<?php include 'cheader.php'?>
    <link rel="stylesheet" href="/css/download.css" type="text/css">
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
                <p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="/site/download" class="current">下载中心</a> </p>
                <div class="box m_t12 pad15 m_h500">
                    <?php
                    $objAndroidQrcode = HP::get_qrcode_by_id('22');
                    $objIosQrcode = HP::get_qrcode_by_id('23');
                    ?>
                    <div class="title and_icon">Android下载</div>
                    <div class="content_d">
                        <img alt="" border="0" src="<?php echo Yii::app()->params['img_domain'].$objAndroidQrcode->qrcode_img?>" width="141" height="141" />
                        <p class="p_t10">版本号：正在研发，敬请期待</p>
                        <P>大小：<?php echo $objAndroidQrcode->size?>MB</P>
                        <a href="javascript:;" onclick="alert('正在研发，敬请期待！')">&nbsp;</a>
                    </div>
                    <div class="title ios_icon m_t20">IOS下载</div>
                    <div class="content_d m_b100">
                        <img alt="" border="0" src="<?php echo Yii::app()->params['img_domain'].$objIosQrcode->qrcode_img?>" width="141" height="141" />
                        <p class="p_t10">版本号：<?php echo $objIosQrcode->version?></p>
                        <P>大小：<?php echo $objIosQrcode->size?>MB</P>
                        <a href="<?php echo $objIosQrcode->download_url?>">&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
<?php include 'cfooter.php'?>
