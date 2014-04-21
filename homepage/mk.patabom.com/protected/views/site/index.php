<?php include 'cheader.php';?>
    <link rel="stylesheet" href="/css/index.css" type="text/css">
    <script type="text/javascript" src="/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/js/slideshow.js"></script>
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
            <div id="main_index">
                <div class="content clearfix" style="padding-bottom:100px;">
                    <div class="content_left">
                        <div class="comiis_wrapad box" id="slideContainer">
                            <div id="frameHlicAe">
                                <ul class="slideshow" id="slidesImgs">
                                    <li><a href="#"> <img src="/images/banner1.jpg" width="538" height="275" alt="" /></a></li>
                                    <li><a href="#"> <img src="/images/banner2.jpg" width="538" height="275" alt="" /></a></li>
                                    <li><a href="#"> <img src="/images/banner3.jpg" width="538" height="275" alt="" /></a></li>
                                    <li><a href="#"> <img src="/images/banner4.jpg" width="538" height="275" alt="" /></a></li>
                                    <li><a href="#"> <img src="/images/banner5.jpg" width="538" height="275" alt="" /></a></li>
                                </ul>
                                <div class="slidebar" id="slideBar">
                                    <ul>
                                        <li class="on">1</li>
                                        <li>2</li>
                                        <li>3</li>
                                        <li>4</li>
                                        <li>5</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="box m_t20">
                            <div class="box_title">
                                <ul id="t_list" class="t_list clearfix">
                                    <li><a href="javascript:void(0)" id="list1" class="current" tip="0"><span>最新</span></a></li>
                                    <li><a href="javascript:void(0)" id="list2" tip="1"><span>新闻</span></a></li>
                                    <li><a href="javascript:void(0)" id="list3" tip="2"><span>活动</span></a></li>
                                    <li><a href="javascript:void(0)" id="list4" tip="3"><span>公告</span></a></li>
                                </ul>
                                <span class="more">[<a href="/site/articleList">更多</a>]</span></div>
                            <div class="box_content">
                                <div class="news" style="display:block">
                                    <div class="news_title">
                                        <?php
                                        if($objNewArticle){
                                            $first =  $objNewArticle[0];
                                            $typeName = Pdw_homepage_type::model()->find("id='{$first['type']}'")->type_name;
                                            $objContent = Pdw_homepage_article_content::model()->find("id='{$first['id']}'");
                                         ?>

                                        <h1><span>【<?php echo $typeName?>】</span><a href="/site/newsDetail?id=<?php echo $first['id']?>" title="<?php echo $objNewArticle[0]['title']?>"><?php echo $objNewArticle[0]['title']?></a></h1>
                                        <p><?php echo MyFunction::csubstr(strip_tags($objContent['intro']),0,30,'...')?></p>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <ul class="news_list">
                                        <?php
                                            if($objNewArticle){
                                                foreach($objNewArticle as $k=>$newArticle){
                                                    if($k==0) continue;
                                        ?>
                                        <li><span class="icon">·&nbsp;</span><a href="/site/newsDetail?id=<?php echo $newArticle['id']?>" title="<?php echo $newArticle['title']?>"><?php echo $newArticle['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($newArticle['submit_date']))?></span></li>
                                    <?php
                                                }
                                            }

                                        ?>
                                    </ul>
                                </div>
                                <div class="news" style="display:none">
                                    <div class="news_title">
                                        <?php
                                            if($objNews){
                                                $firstNews = $objNews[0];
                                                $objNewsContent = Pdw_homepage_article_content::model()->find("id='{$firstNews['id']}'");
                                            }
                                        ?>
                                        <h1><span>【新闻】</span><a href="/site/newsDetail?id=<?php echo $firstNews['id']?>" title="<?php echo $firstNews['title']?>"><?php echo MyFunction::csubstr($firstNews['title'],0,20,'......')?></a></h1>
                                        <p><?php echo MyFunction::csubstr(strip_tags($objNewsContent['intro']),0,30,'...')?></p>
                                    </div>
                                    <ul class="news_list">
                                        <?php
                                            if($objNews){
                                                foreach($objNews as $k=>$news){
                                                    if($k==0) continue;
                                        ?>

                                        <li><span class="icon">·&nbsp;</span><a href="/site/newsDetail?id=<?php echo $news['id']?>" title="<?php echo $news['title']?>"><?php echo $news['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($news['submit_date']))?></span></li>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                                <div class="news" style="display:none">
                                    <div class="news_title">
                                        <?php
                                        if($objActive){
                                            $firstActive = $objActive[0];
                                            $objActiveContent = Pdw_homepage_article_content::model()->find("id='{$firstActive['id']}'");
                                        }
                                        ?>
                                        <h1><span>【活动】</span><a href="/site/newsDetail?id=<?php echo $firstActive['id']?>" title="<?php echo $firstActive['title']?>"><?php echo MyFunction::csubstr($firstActive['title'],0,20,'......')?></a></h1>
                                        <p><?php echo MyFunction::csubstr(strip_tags($objActiveContent['intro']),0,30,'...')?></p>
                                    </div>
                                    <ul class="news_list">
                                        <?php
                                            if($objActive){
                                                foreach($objActive as $k=>$active){
                                                    if($k==0) continue;
                                        ?>

                                        <li><span class="icon">·&nbsp;</span><a href="/site/newsDetail?id=<?php echo $active['id']?>" title="<?php echo $active['title']?>"><?php echo $active['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($active['submit_date']))?></span></li>
                                        <?php
                                           }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="news" style="display:none">
                                    <div class="news_title">
                                        <?php
                                        if($objNotice){
                                            $firstNotice = $objNotice[0];
                                            $objNoticeContent = Pdw_homepage_article_content::model()->find("id='{$firstNotice['id']}'");
                                        }
                                        ?>
                                        <h1><span>【公告】</span><a href="/site/newsDetail?id=<?php echo $firstNotice['id']?>" title="<?php $firstActive['title']?>"><?php echo MyFunction::csubstr($firstNotice['title'],0,20,'......')?></a></h1>
                                        <p><?php echo MyFunction::csubstr(strip_tags($objNoticeContent['intro']),0,30,'...')?></p>
                                    </div>
                                    <ul class="news_list">
                                        <?php
                                            if($objNotice){
                                                foreach($objNotice as $k=>$notice){
                                                if($k==0) continue;
                                        ?>
                                            <li><span class="icon">·&nbsp;</span><a href="/site/newsDetail?id=<?php echo $notice['id']?>" title="<?php echo $notice['title']?>"><?php echo $notice['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($notice['submit_date']))?></span></li>

                                                <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="box m_t20">
                            <!--<embed src="http://player.youku.com/player.php/sid/XNjM4MDMyNTA0/v.swf" allowFullScreen="true" quality="high" width="538" height="264" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>-->
                            <!--<img alt="" border="0" src="images/video.jpg" />-->
                            <div class="video">
                                <!--              <div id="CuPlayer"> <strong>提示：您的Flash Player版本过低</strong></div>
                                              <script type="text/javascript">
                                var so = new SWFObject("file:///E:/works/html/mkzj/images/CuPlayerMiniV20_Gray_S.swf","CuPlayer","538","264","9","#000000");
                                so.addParam("allowfullscreen","true");
                                so.addParam("allowscriptaccess","always");
                                so.addParam("wmode","opaque");
                                so.addParam("quality","high");
                                so.addParam("salign","lt");
                                so.addVariable("CuPlayerFile","file:///E:/works/html/mkzj/images/video.flv");
                                so.addVariable("CuPlayerImage","file:///E:/works/html/mkzj/images/video.jpg");
                                so.addVariable("CuPlayerShowImage","true");
                                so.addVariable("CuPlayerWidth","538");
                                so.addVariable("CuPlayerHeight","264");
                                so.addVariable("CuPlayerAutoPlay","true");
                                so.addVariable("CuPlayerAutoRepeat","false");
                                so.addVariable("CuPlayerShowControl","true");
                                so.addVariable("CuPlayerAutoHideControl","false");
                                so.addVariable("CuPlayerAutoHideTime","6");
                                so.addVariable("CuPlayerVolume","80");
                                so.write("CuPlayer");
                                </script>-->
                                <object width="538" height="264">
                                    <param name="allowFullScreen" value="true">
                                    <param name="movie" value="http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=124416465_3982129220_bh63GyNsW2LK+l1lHz2stqlF+6xCpv2xhGm9s1ClJwdbVwyYJMXNb9wF5C3XBstE9HoLHcwydPwi0xwrbKxd/s.swf">
                                    <embed src="http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=124416465_3982129220_bh63GyNsW2LK+l1lHz2stqlF+6xCpv2xhGm9s1ClJwdbVwyYJMXNb9wF5C3XBstE9HoLHcwydPwi0xwrbKxd/s.swf" width="538" height="264" allowfullscreen="true" type="application/x-shockwave-flash">
                                </object>
                            </div>
                        </div>
                    </div>
                    <div class="content_right">
                        <div class="box">
                            <div class="box_title"> <span class="box_bt down_bt">&nbsp;</span> <span class="more">[<a href="#">更多</a>]</span></div>
                            <div class="box_content">
                                <div class="download">
                                    <?php
                                        $objAndroidQrcode = HP::get_qrcode_by_id('22');
                                        $objIosQrcode = HP::get_qrcode_by_id('23');
                                    ?>
                                    <div class="down_change"><a href="javascript:void(0)" class="hover" tip="0">IPhone下载(越狱版)</a><a href="javascript:void(0)"  tip="1">Android下载</a></div>
                                    <div class="down_content" style="display:block;">
<!--                                        <div style="background: #ffffff;height: 130px;width: 130px;float: left;margin-right: 26px;">-->
<!--                                            <img style="width: 111px;height: 111px;padding: 10px;padding-right: 15px;" alt="" border="0" src="--><?php //echo Yii::app()->params['img_domain'].$objAndroidQrcode->qrcode_img?><!--"  class="left p_r13" />-->
<!--                                        </div>-->
<!--                                            <p>版本号：--><?php //echo $objAndroidQrcode->version?><!--</p>-->
<!--                                        <p>大小：--><?php //echo $objAndroidQrcode->size?><!--MB</p>-->
<!--                                        <p>适用固件：</p>-->
<!--                                        <p>android4.3.1及以上</p>-->

                                        <div style="background: #ffffff;height: 130px;width: 130px;float: left;margin-right: 26px;">
                                            <img style="width: 111px;height: 111px;padding: 10px;padding-right: 15px;" alt="" border="0" src="<?php echo Yii::app()->params['img_domain'].$objIosQrcode->qrcode_img?>" class="left p_r13" />
                                        </div>
                                        <p>版本号：<?php echo $objIosQrcode->version?></p>
                                        <p>大小：<?php echo $objIosQrcode->size?></p>
                                    </div>
                                    </div>
                                    <div class="down_content" style="display:none">
                                        正在开发中。。。
                                </div>
                            </div>
                        </div>
                        <div class="box m_t20">
                            <div class="box_title"> <span class="box_bt cus_bt">&nbsp;</span> <span class="more">[<a href="/site/customer">更多</a>]</span></div>
                            <div class="box_content">
                                <div class="customer">
                                    <p>客服电话：0592-5283038（周一至五9:00-18:00）</p>
                                    <p>客服QQ：2403666251</p>
                                    <p>客服邮箱：2403666251@qq.com</p>
                                    <img width="120" height="120" alt="" border="0" src="/images/wx.jpg" class="left p_r13 p_t10" />
                                    <p style="padding-top:17px;color:#ffffff;">扫描二维码关注《摩卡战纪》官方微信</p>               </div>
                            </div>
                        </div>
                        <div class="box m_t20">
                            <div class="box_title"> <span class="box_bt coop_bt">&nbsp;</span> <span class="more">[<a href="#">更多</a>]</span></div>
                            <div class="box_content">
                                <div class="cooperation">
                                    <a href="http://www.yoyou.com/" target="_blank"><img alt="" border="0" src="/images/coop1.png" width="95" height="53" /></a>
                                    <a href="http://www.ptbus.com/" target="_blank" class="m_l20"><img alt="" border="0" src="/images/coop2.png" width="95" height="53"/></a>
                                    <a href="http://www.5g.com/" target="_blank" class="m_t20"><img alt="" border="0" src="/images/coop3.png" width="95" height="53"/></a>
                                    <a href="http://sy.766.com/" target="_blank" class="m_l20"><img alt="" border="0" src="/images/766.png" width="95" height="53"/></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php include 'cfooter.php';?>