<?php include YII_ROOT.'/views/layout/header_t.php'?>

<link rel="stylesheet" href="/css/screenshot.css" type="text/css">
<?php include YII_ROOT.'/views/layout/header_b.php'?>

<body>
<div id="main_body">
    <div id="main_top">
        <?php include YII_ROOT.'/views/includes/nav.php'?>
    </div>
    <div class="content box">
        <div class="box_title clearfix">
            <div class="con_top_left"> <span>游戏截图</span></div>
            <div class="con_top_center_ny"><p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="/game/gameThumb" class="current">游戏截图</a></p></div>
        </div>
        <div class="con_center_ny">
            <div class="content_ny">
                <div class="box m_t12 p_b50 m_h500">

                    <ul class="screenshot">
                       <?php
                            if($gameThumb){
                                foreach($gameThumb as $thumb){
                        ?>
                            <li><img src="<?php echo Yii::app()->params['img_domain'].$thumb['img_url']?>" width="290" height="430"></li>

                        <?php
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
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
    <?php include YII_ROOT.'/views/layout/footer.php'?>

