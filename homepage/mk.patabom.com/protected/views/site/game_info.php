<?php include 'cheader.php'?>
<link rel="stylesheet" href="/css/news.css" type="text/css">
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
                <p class="p_bt">您当前所在位置：<a href="<?php echo $fLink?>">首页</a> >> <a href="<?php echo $link?>" class="current"><?php echo $linkName?></a></p>
                <div class="box m_t12 pad15 m_h500">
                    <div class="news_t m_t12">

                    </div>
                    <div class="news_c p_t10">
                        <div class="news" style="display:block">
                            <ul class="news_list">
                                <?php
                                if($objArticle){
                                    foreach($objArticle as $article){
                                        $typeName = Pdw_homepage_type::model()->find("id='{$article['type']}'")->type_name;
                                        ?>
                                        <li><span class="icon">·&nbsp;</span><a href="/site/gameDetail?id=<?php echo $article['id']?>" title="<?php echo $article['title']?>"><?php echo $article['title']?></a><span class="time"><?php echo date('Y-m-d',strtotime($article['submit_date']))?></span></li>
                                    <?php
                                    }
                                }
                                ?>
                            </ul>
                            <!--//page-->              <div id="pagination" class="pagination">
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
    <?php include 'cfooter.php'?>
