<?php include 'cheader.php'?>
<link rel="stylesheet" href="/css/news.css" type="text/css">
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
                    <div class="con_top_left"> <span>新闻公告</span></div>

                    <div class="con_top_center_ny"><p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="<?php echo $link?>" class="current"><?php echo $linkName?></a></p></div>
                    <div class="con_top_right_ny"> </div>
                </div>
                <div class="con_center_ny">
                    <div class="content_ny m_h350" >
                        <div class="box m_t12 pad15 m_h500">
                            <div class="news_t m_t12">
                                <ul id="t_list" class="t_list clearfix">
                                    <li><a href="/site/articleList" id="list1" tip="0"><span>最新</span></a></li>
                                    <li><a href="/site/news" id="list2" tip="1"><span>新闻</span></a></li>
                                    <li><a href="/site/active" id="list3" tip="2" class="current" ><span>活动</span></a></li>
                                    <li><a href="/site/notice" id="list4" tip="3"><span>公告</span></a></li>
                                </ul>
                            </div>
                            <div class="news_c p_t10">
                                <div class="news" style="display:block">
                                    <ul class="news_list">
                                        <?php
                                            if($objArticle){
                                                foreach($objArticle as $article){
                                                    $typeName = Pdw_homepage_type::model()->find("id='{$article['type']}'")->type_name;
                                        ?>

                                        <li><span class="icon"><img src="/images/news_ico01.jpg" width="6" height="7">&nbsp;</span><span class="type">[<?php echo $typeName?>]</span><a href="/site/newsDetail?id=<?php echo $article['id']?>" title="<?php echo $article['title']?>"><?php echo $article['title']?></a><span class="time"><?php echo $article['submit_date']?></span></li>
                                     <?php
                                                }
                                            }
                                        ?>
                                    </ul>
                                    <div id="pagination" class="pagination">
                                        <?php
                                        $this->widget('CLinkPager',array(
//                    'htmlOptions'=>'<a>',
                                                'header'=>'',
                                                'footer'=>'',
                                                'firstPageLabel' => '首页',
                                                'lastPageLabel' => '末页',
                                                'prevPageLabel' => '上一页',
                                                'nextPageLabel' => '下一页',
                                                'pages' => $pager,
                                                'maxButtonCount'=>13
                                            )
                                        );
                                        ?>
                                    </div>
                                </div>
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
