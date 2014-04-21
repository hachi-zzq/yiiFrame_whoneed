<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/news.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/scroll.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl?>/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.reveal.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery.scroll.js"></script>
    <style>
        .pagination li.first,.pagination li.last{
            display: none;
        }
    </style>
</head>
<body>
<?php include Page::importFile('cheader.php')?>


<!--main--->
    <div class="main_body">

        <?php
        if(isset($newsList) && !empty($newsList)){
        $flag = 1;
        foreach($newsList as $k=>$n){
        ?>
        <div  id="myModal<?php echo $n->id?>"  class="reveal-modal">
            <div class="dumascroll">
                <div class="news_back_btn"><a class="close-reveal-modal"><img alt="" border="0" src="<?php echo Yii::app()->baseUrl?>/images/back.gif" /></a></div>
                <div class="news_model_title">
                    <p class="news_model_detail1"><?php echo $n->title?></p>
                    <p class="news_model_detail2"><span><?php echo 'admin'?></span>&nbsp;&nbsp;发表于&nbsp;&nbsp;<span><?php echo $n->create_time?></span>&nbsp;&nbsp;<span>0</span>&nbsp;&nbsp;评论</p>
                </div>
                <div class="news_model_content clearfix">
                    <p class="img_ct"><img alt="" border="0" src="<?php echo $n->img==''?Yii::app()->baseUrl.'/images/new_default.jpg':Yii::app()->params['img_domain'].'/'.$n->img?>" /></p>
                    <p><?php echo $n->content?></p>
                </div>
            </div>
        </div>
            <?php
            $flag++;
        }
        }
        ?>
        <div class="news_ul">
            <ul>
                <?php
                    if(isset($newsList) && !empty($newsList)){
                        $flag = 1;
                        foreach($newsList as $k=>$n){
                ?>

                <li class="news_li">
                    <div class="news_list clearfix">
                        <div class="news_left_left <?php echo $flag%2==0?'right':'left'?>"> <a href="javascript:void(0);" data-reveal-id="myModal<?php echo $n->id?>"><img alt="" border="0" src="<?php echo  $n->img==''?Yii::app()->baseUrl.'/images/new_default.jpg':Yii::app()->params['img_domain'].'/'.$n->img ?>" width="210" height="120" /></a></div>
                        <div class="news_left_right <?php echo $flag%2==0?'left':'right'?>">
                            <div class="clearfix">
                                <p class="title_left"><a href="javascript:void(0);" data-reveal-id="myModal<?php echo $n->id?>"><span><?php echo $n->title?></span></a></p>
                                <p class="title_right"><span><?php echo 'admin'?></span>&nbsp;&nbsp;发表于&nbsp;&nbsp;<span><?php echo $n->create_time?></span></p>
                            </div>
                            <p class="news_content"><?php echo $n->brief?></p>
                        </div>
                    </div>

                </li>
                <?php
                            $flag++;
                        }
                    }
                ?>

            </ul>
        </div>
        <div id="pagination" class="pagination" style="margin: auto;vertical-align:top;">
            <?php
            $pre = '<img alt="" border="0" style="vertical-align:top;" src='.Yii::app()->baseUrl.'/images/bt_left.png / >';
            $next = '<img alt="" border="0" src='.Yii::app()->baseUrl.'/images/bt_right.png / >';
            $this->widget('CLinkPager',array(
//                    'htmlOptions'=>'<a>',
                    'header'=>'',
                    'footer'=>'',
                    'firstPageLabel' => '',
                    'lastPageLabel' => '',
                    'prevPageLabel' => $pre,
                    'nextPageLabel' => $next,
                    'pages' => $page,
                    'maxButtonCount'=>13
                )
            );
            ?>
        </div>

    </div>

<?php include Page::importFile('cfooter.php')?>

</body>
</html>