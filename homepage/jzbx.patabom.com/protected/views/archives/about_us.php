<?php include YII_ROOT.'/views/layout/header_t.php'?>

<link rel="stylesheet" href="/css/newsDetail.css" type="text/css">
<?php include YII_ROOT.'/views/layout/header_b.php'?>

<body>
<div id="main_body">
    <div id="main_top">
        <?php include YII_ROOT.'/views/includes/nav.php'?>
    </div>
    <div class="content box">
        <div class="box_title clearfix">
            <div class="con_top_left"> <span>新闻详情</span></div>
            <div class="con_top_center_ny"><p class="p_bt">您当前所在位置：<a href="/">首页</a> >> <a href="<?php echo $link?>"><?php echo $linkName?></a></p></div>
        </div>
        <div class="con_center_ny">
            <div class="content_ny">
                <div class="box m_t12 pad15 m_h500">
                    <div class="content_t">
                        <h1><?php echo $res['title']?></h1>
                    </div>
                    <div class="content_c">
                        <?php echo $res['intro']?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include YII_ROOT.'/views/layout/footer.php'?>
