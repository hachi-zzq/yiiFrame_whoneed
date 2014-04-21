<?php include 'cheader.php'?>
    <link rel="stylesheet" href="/css/footballer.css" type="text/css">
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
                    <div class="con_top_left"> <span>球员展示</span></div>

                    <div class="con_top_center_ny"><p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="#" class="current">球员展示</a></p></div>
                    <div class="con_top_right_ny"> </div>
                </div>
                <div class="con_center_ny">
                    <div class="content_ny m_h350">
                        <div class="box m_t12 pad15 m_h500">

                            <ul class="footballer">
                                <?php
                                    if($footballer){
                                        foreach($footballer as $footer){
                                    ?>
                                <li><img src="<?php echo Yii::app()->params['img_domain'].$footer->img_url?>" ></li>
                            <?php
                                        }
                                    }

                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="con_bottom clearfix">
                    <div class="con_bottom_left"></div>
                    <div class="con_bottom_center"></div>
                    <div class="con_bottom_right"></div>
                </div>
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
<?php include 'cfooter.php'?>
