<?php include YII_ROOT.'/views/layout/header_t.php'?>
<link rel="stylesheet" href="/css/news.css" type="text/css">
    <?php include YII_ROOT.'/views/layout/header_b.php'?>
<body>
<div id="main_body">
   <?php
        include YII_ROOT.'/views/includes/nav.php';
    ?>
    <div class="content box">
        <div class="box_title clearfix">
            <div class="con_top_left"> <span>新闻中心</span></div>

            <div class="con_top_center_ny"><p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="<?php echo $link?>" class="current"><?php echo $linkName?></a></p></div>

        </div>
        <div class="con_center_ny">
            <div class="content_ny">
                <div class="box m_t12 pad15 m_h500">
            <?php
                    if($none_news_nav !=1){
                        include YII_ROOT.'/views/includes/news_nav.php';
                    }
                    ?>
                    <div class="news_c p_t10">
                        <div class="news" style="display:block">
                            <ul class="news_list">
                                <?php
                                    if(isset($news) && $news){
                                        foreach($news as $new){
                                ?>

                            <li><span class="icon"><img src="/images/news_ico01.png" width="5" height="6">&nbsp;</span><a href="<?php echo $detailLink?>?id=<?php echo $new['id']?>" title="<?php echo $new['title']?>"><?php echo  MyFunction::csubstr($new['title'],0,40,'...')?></a><span class="time"><?php echo date('Y-m-d',strtotime($new['submit_date']))?></span></li>
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
    </div>

    <?php include YII_ROOT.'/views/layout/footer.php'?>
