<?php include 'cheader.php'?>
    <link rel="stylesheet" href="/css/index.css" type="text/css">
    <script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/js/slideshow.js"></script>
    <!--[if lt IE 10]>
    <script type="text/javascript" src="/js/PIE.js"></script>
    <![endif]-->
    <script language="javascript">
        $(function() {
            if (window.PIE) {
                $('.rounded').each(function() {
                    PIE.attach(this);
                });
            }
        });
    </script>
    <!--[if lte IE 6]>
    <script src="/js/DD_belatedPNG.js" type="text/javascript"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('div, ul, p, img, li, input , a , span');
    </script>
    <![endif]-->
</head>
<body>
<div id="main_top">
    <div id="main_footer">
        <div id="main_body">
            <?php include 'nav.php'?>
            <div class="main_content">
                <div class="clearfix m_t495">
                    <div class="content_l_a">
                        <div class="comiis_wrapad" id="slideContainer">
                            <div id="frameHlicAe">
                                <ul class="slideshow" id="slidesImgs">
                                    <li><a href="#" class="a1"></a></li>
                                    <li><a href="#" class="a2"></a></li>
                                    <li><a href="#" class="a3"></a></li>
                                </ul>
                                <div class="slidebar" id="slideBar">
                                    <ul>
                                        <li class="on">1</li>
                                        <li>2</li>
                                        <li>3</li>
                                    </ul>
                                </div>
                            </div>
                        </div></div>

                    <div class="content_r_a">
                        <div class="clearfix pos_rel">
                            <div class="con_top_left"></div>
                            <div class="con_top_center width115"></div>
                            <div class="con_top_right"><span><a href="/site/articleList">更多>></a></span></div>
                            <div class="t_title"><a href="javascript:void(0)" tip="0" class="current">新闻</a><a href="javascript:void(0)" tip="1">公告</a><a href="javascript:void(0)" tip="2">活动</a></div>
                        </div>
                        <div class="con_r_a">
                            <div class="content_r_a_c">
                                <ul class="news_list">
                                    <?php
                                        if($news){
                                            foreach($news as $new){
                                    ?>
                                    <li><a href="/site/newsDetail?id=<?php echo $new['id']?>" title="<?php echo $new['title']?>"><?php echo $new['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($new['submit_date']))?></span></li>
                                <?php
                                            }
                                        }
                                    ?>
                                </ul>

                                <ul class="news_list" style="display:none">
                                    <?php
                                    if($notices){
                                        foreach($notices as $notice){
                                            ?>
                                            <li><a href="/site/newsDetail?id=<?php echo $notice['id']?>" title="<?php echo $notice['title']?>"><?php echo $notice['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($notice['submit_date']))?></span></li>
                                        <?php
                                        }
                                    }
                                    ?>
                                </ul>

                                <ul class="news_list" style="display:none">
                                    <?php
                                    if($actives){
                                        foreach($actives as $active){
                                            ?>
                                            <li><a href="/site/newsDetail?id=<?php echo $active['id']?>" title="<?php echo $active['title']?>"><?php echo $active['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($active['submit_date']))?></span></li>
                                        <?php
                                        }
                                    }
                                    ?>
                                </ul>

                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="con_bottom_left"></div>
                            <div class="con_bottom_center width117"></div>
                            <div class="con_bottom_right"></div>
                        </div>
                    </div>
                </div>


                <div class="content1 m_t15">
                    <div class="con_top clearfix">
                        <div class="con_top_left"> <span>球员展示</span></div>
                        <div class="con_top_center width_635"></div>
                        <div class="con_top_right"> <span><a href="/site/footballer">更多>></a></span></div>
                    </div>
                    <div class="con_center_ny">
                        <div id="demo">
                            <div id="con_center_ny">
                                <div id="content_qyzs">
                                    <div class="content_qyzs">
                                        <ul>
                                            <?php
                                                if($footballer){
                                                    foreach($footballer as $user){
                                            ?>
                                            <li><img src="<?php echo Yii::app()->params['img_domain'].$user['img_url']?>" width="170" height="230"></li>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div id="demo2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="con_bottom clearfix">
                        <div class="con_bottom_left"></div>
                        <div class="con_bottom_center width_637"></div>
                        <div class="con_bottom_right"></div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="content1 m_t15">
                    <div class="con_top clearfix">
                        <div class="con_top_left"> <span>合作媒体</span></div>
                        <div class="con_top_center width_635"></div>
                        <div class="con_top_right"> <span><a href="#">更多>></a></span></div>
                    </div>
                    <div class="con_center_ny">
                        <div class="content_hzmt">
                            <ul>
                                <?php
                                    if($cooperation){
                                        foreach($cooperation as $c){
                                ?>
                                <li><a href="<?php echo $c['img_href']?>"><img src="<?php echo Yii::app()->params['img_domain'].$c['img_url']?>"></a></li>
                                <?php
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="con_bottom clearfix">
                        <div class="con_bottom_left"></div>
                        <div class="con_bottom_center width_637"></div>
                        <div class="con_bottom_right"></div>
                    </div>
                </div>




                <div class="clearfix m_t15">
                    <div class="content_l_b">
                        <div class="clearfix">
                            <div class="con_top_left"> <span>游戏截图</span></div>
                            <div class="con_top_center width255"></div>
                            <div class="con_top_right"> <span><a href="/site/gameThumb">更多>></a></span></div>
                        </div>
                        <div class="con_center_yxjt">
                            <div class="content_yxjt">
                                <ul>
                                    <?php
                                        if($gameThumb){
                                            foreach($gameThumb as $thumb){
                                    ?>
                                    <li><a href="<?php echo $thumb->img_href?>"><img src="<?php echo Yii::app()->params['img_domain'].$thumb->img_url?>" width="135" height="180"></a></li>
                                    <?php
                                            }
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="con_bottom_left"></div>
                            <div class="con_bottom_center width257"></div>
                            <div class="con_bottom_right"></div>
                        </div></div>


                    <div class="content_r_b">
                        <div class="clearfix">
                            <div class="con_top_left"> <span>客服中心</span></div>
                            <div class="con_top_center width13"></div>
                            <div class="con_top_right"> <span><a href="/site/customer">更多>></a></span></div>
                        </div>
                        <div class="con_center_kfzx">
                            <div class="content_kfzx">
                                <div class="customer">
                                    <p>客服微信：ptb_cs</p>
                                    <p>客服QQ：368550201</p>
                                    <p>客服邮箱：2403666251@qq.com</p>
                <span><img alt="" border="0" src="/images/ptb_cs.jpg" class="left p_r13 p_t10" />
                <p style="padding-top:30px;color:#666;">扫描二维码关注官方微信</p>       </span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="con_bottom_left"></div>
                            <div class="con_bottom_center width15"></div>
                            <div class="con_bottom_right"></div>
                        </div></div>
                </div>



            </div>


<?php include 'cfooter.php'?>


