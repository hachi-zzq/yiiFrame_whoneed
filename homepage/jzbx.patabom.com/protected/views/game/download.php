<?php include YII_ROOT.'/views/layout/header_t.php'?>
    <link rel="stylesheet" href="/css/download.css" type="text/css">
<?php include YII_ROOT.'/views/layout/header_b.php'?>
<body>
<div id="main_body">
    <div id="main_top">
        <?php include YII_ROOT.'/views/includes/nav.php'?>

    </div>
    <div class="content box">
        <div class="box_title clearfix">
            <div class="con_top_left"> <span>游戏下载</span></div>

            <div class="con_top_center_ny"><p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="<?php echo $link?>" class="current"><?php echo $linkName?></a></p></div>

        </div>
        <div class="con_center_ny">
            <div class="content_ny">
                <div class="box m_t12 pad15 m_h500">
                    <div class="clearfix"></div>
                    <div class="title and_icon">Android下载</div>
                    <?php
                    $objAndroidQrcode = HP::get_qrcode_by_id('84');
                    $objIosQrcode = HP::get_qrcode_by_id('85');
                    $objIosWallQrcode = HP::get_qrcode_by_id('86');
                    ?>
                    <div class="content_d">
                        <div style="background: #ffffff;height: 130px;width: 130px;float: left;margin-right: 26px;">
                        <img alt="" border="0" src="<?php echo Yii::app()->params['img_domain'].$objAndroidQrcode->qrcode_img?>" style="width: 111px;height: 111px;padding: 10px;padding-right: 15px;" />
                        </div>
                            <p class="p_t10">版本号：<?php echo $objAndroidQrcode->version?></p>
                    <P>大小：<?php echo $objAndroidQrcode->size?>MB</P>
                        <a href="<?php echo $objAndroidQrcode->download_url?>">&nbsp;</a>
                    </div>
<!--                    <div class="title ios_icon m_t20">iPhone下载</div>-->
<!--                    <div class="content_d m_b100">-->
<!--                        <div style="background: #ffffff;height: 130px;width: 130px;float: left;margin-right: 26px;">-->
<!--<!--                            <img alt="" border="0" src="--><?php ////echo Yii::app()->params['img_domain'].$objIosQrcode->qrcode_img?><!--<!--" style="width: 111px;height: 111px;padding: 10px;padding-right: 15px;" />-->
<!--                        </div>-->
<!--                        <p class="p_t10">版本号：--><?php //echo $objIosQrcode->version?><!--</p>-->
<!--                        <P>大小：--><?php //echo $objIosQrcode->size?><!--MB</P>-->
<!--                        <a href="--><?php //echo $objIosQrcode->download_url?><!--">&nbsp;</a>-->
<!--                    </div>-->
<!--                    <div class="title ios_icon m_t20">iPhone下载（越狱版）</div>-->
<!--                    <div class="content_d m_b100">-->
<!--                        <div style="background: #ffffff;height: 130px;width: 130px;float: left;margin-right: 26px;">-->
<!--<!--                            <img alt="" border="0" src="--><?php ////echo Yii::app()->params['img_domain'].$objIosWallQrcode->qrcode_img?><!--<!--" style="width: 111px;height: 111px;padding: 10px;padding-right: 15px;" />-->
<!--                        </div>-->
<!--                        <p class="p_t10">版本号：--><?php //echo $objIosWallQrcode->version?><!--</p>-->
<!--                        <P>大小：--><?php //echo $objIosWallQrcode->size?><!--MB</P>-->
<!--                        <a href="--><?php //echo $objIosWallQrcode->download_url?><!--">&nbsp;</a>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
    <?php include YII_ROOT.'/views/layout/footer.php'?>


