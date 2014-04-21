<?php include YII_ROOT.'/views/layout/header_t.php'?>
<link type="text/css" rel="stylesheet" href="/css/index.css"/>
<?php include YII_ROOT.'/views/layout/header_b.php'?>
<body>
<div id="main_body">

    <?php include YII_ROOT.'/views/includes/nav.php'?>

    <div class="main_content">
        <div id="download">
            <dl>
                <dt>
                <ul>
                    <?php
                    $objAndroidQrcode = HP::get_qrcode_by_id('84');
                    $objIosQrcode = HP::get_qrcode_by_id('85');
                    $objIosWallQrcode = HP::get_qrcode_by_id('86');
                    ?>
                    <li class="code1" >
                        <img alt="" style="background: white;padding: 8px;margin: 2px;position: relative;top:-4px;left: -4px;" src="<?php echo Yii::app()->params['img_domain'].$objAndroidQrcode->qrcode_img?>" width="120" height="120" />
<!--                            <img src="/images/qrcode.jpg" />-->
                    </li>
                    <li class="code2">
<!--                        <img alt=""style="background: white;padding: 14px;margin: 5px;position: relative;top:-4px;left: -4px;" src="--><?php //echo Yii::app()->params['img_domain'].$objIosQrcode->qrcode_img?><!--" width="100" height="100"  />-->
                        <img src="/images/qrcode.jpg" />
                    </li>
                    <li class="code3">
<!--                        <img alt="" style="background: white;padding: 14px;margin: 5px;position: relative;top:-4px;left: -4px;" src="--><?php //echo Yii::app()->params['img_domain'].$objIosWallQrcode->qrcode_img?><!--" width="100" height="100"  />-->
                        <img src="/images/qrcode.jpg"  />
                    </li>
                </ul>
                </dt>
                <dd>
                    <ul>
                        <li class="noPad"><a href="<?php echo $objAndroidQrcode->download_url?>" class="d_1"></a></li>
                        <li><a href="<?php echo $objIosQrcode->download_url?>" onclick="alert('正在研发中，敬请期待');return false" class="d_2"></a></li>
                        <li><a href="<?php echo $objIosWallQrcode->download_url?>" onclick="alert('正在研发中，敬请期待');return false" class="d_3"></a></li>
                    </ul>
                </dd>
            </dl>
        </div>
        <div class="clearfix">
            <div class="content_l_a">
                <div class="comiis_wrapad" id="slideContainer">
                    <div id="frameHlicAe">
                        <ul class="slideshow" id="slidesImgs">
                            <li><a href="/article/newsDetail?id=166"><img alt="" src="/images/banner1.jpg" /></a></li>
                            <li><a href="/article/newsDetail?id=165"><img alt="" src="/images/banner4.jpg" /></a></li>
                            <li><a href="/article/newsDetail?id=162"><img alt="" src="/images/banner2.jpg" /></a></li>
                            <li><a href="/article/newsDetail?id=164"><img alt="" src="/images/banner3.jpg" /></a></li>
                        </ul>
                        <div class="slidebar" id="slideBar">
                            <ul>
                                <li class="on">1</li>
                                <li>2</li>
                                <li>3</li>
                                <li>4</li>
                            </ul>
                        </div>
                    </div>
                </div></div>

            <div class="content_r_a box">
                <div class="box_title pos_rel">
                    <div class="con_top_right"><span><a href="/article/articleList">更多>></a></span></div>
                    <div class="t_title"><a href="javascript:void(0)" tip="0" class="current">新闻</a><a href="javascript:void(0)" tip="1">公告</a><a href="javascript:void(0)" tip="2">活动</a></div>
                </div>
                <div class="con_r_a">
                    <div class="content_r_a_c">
                        <ul class="news_list">
                            <?php
                                if(isset($news) && !empty($news)){
                                    foreach($news as $new){
                            ?>
                        <li><a href="/article/newsDetail?id=<?php echo $new['id']?>" title="<?php echo $new['title']?>"><?php echo MyFunction::csubstr($new['title'],0,20,'...')?></a><span class="time"><?php echo date('Y-m-d',strtotime($new['submit_date']))?></span></li>
                            <?php
                                    }
                                }
                            ?>
                            </ul>

                        <ul class="news_list" style="display:none">
                            <?php
                            if(isset($notices) && !empty($notices)){
                                foreach($notices as $notice){
                                    ?>
                                    <li><a href="/article/newsDetail?id=<?php echo $notice['id']?>" title="<?php echo $notice['title']?>"><?php echo MyFunction::csubstr($notice['title'],0,20,'...')?></a><span class="time"><?php echo date('Y-m-d',strtotime($notice['submit_date']))?></span></li>
                                <?php
                                }
                            }
                            ?>
                        </ul>

                        <ul class="news_list" style="display:none">
                            <?php
                            if(isset($actives) && !empty($actives)){
                                foreach($actives as $active){
                                    ?>
                                    <li><a href="/article/newsDetail?id=<?php echo $active['id']?>" title="<?php echo $active['title']?>"><?php echo MyFunction::csubstr($active['title'],0,20,'...')?></a><span class="time"><?php echo date('Y-m-d',strtotime($active['submit_date']))?></span></li>
                                <?php
                                }
                            }
                            ?>
                        </ul>

                    </div>
                </div>

            </div>
        </div>




        <div class="content1 m_t20 box">
            <div class="box_title clearfix">
                <div class="con_top_left"> <span>合作媒体</span></div>
                <div class="con_top_right"> <span><a href="#">更多>></a></span></div>
            </div>
            <div class="content_hzmt">
                <ul>
                    <?php
                        if($coo && !empty($coo)){
                            foreach($coo as $c){
                        ?>

                    <li><a href="<?php echo $c['img_href']?>" target="_blank"><img src="<?php echo Yii::app()->params['img_domain'].$c['img_url']?>" ></a></li>

                    <?php
                            }
                        }
                    ?>

                </ul>
            </div>


        </div>




        <div class="clearfix m_t20">
            <div class="content_l_b box">
                <div class=" box_title clearfix">
                    <div class="con_top_left"> <span>游戏截图</span></div>
                    <div class="con_top_right"> <span><a href="/game/gameThumb">更多>></a></span></div>
                </div>

                <div class="content_yxjt">
                    <ul>
                        <?php
                            if(isset($thumb) && !empty($thumb)){
                                foreach($thumb as $t){
                        ?>
                        <li><a href="<?php echo $t['img_href']?>"><img src="<?php echo Yii::app()->params['img_domain'].$t['img_url']?>" width="132" height="196"></a></li>
                    <?php
                                }
                            }
                        ?>
                    </ul>
                </div>

            </div>


            <div class="content_r_b box">
                <div class=" box_title clearfix">
                    <div class="con_top_left"> <span>客服中心</span></div>
                    <div class="con_top_right"> <span><a href="/customer/index">更多>></a></span></div>
                </div>

                <div class="content_kfzx">
                    <div class="customer">
                        <p>客服微信：ptb_cs</p>
                        <p>Q Q群号 ：246169107</p>
                        <p>微信邮箱：service@friendou.com</p>
                <span><img alt="" border="0" src="/images/wx.jpg" class="left p_r13 p_t10" />
                <p style="padding-top:17px; text-indent:5px; color:#fff;">扫描二维码关注官方微信</p></span>
                    </div>
                </div>

            </div>
        </div>



    </div>
    <?php include YII_ROOT.'/views/layout/footer.php'?>