<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/gamesList.css" rel="stylesheet" type="text/css">
    <style>
        .pagination li.first,.pagination li.last{
            display: none;
        }
    </style>
</head>
<body>
<?php include Page::importFile('cheader.php')?>

<div class="main_body">
    <div class="news_ul">
        <ul>
            <?php
                if(isset($own_all) && !empty($own_all)){
                    foreach($own_all as $o){
            ?>

            <li>
                <div class="news_list clearfix">
                    <div class="news_left_left left"> <a href="<?php if($o['status']==1): echo $o['homepage_url'];else: echo $this->createUrl('game/gameDetail/id/').'/'.$o['id']; endif;?>"><img alt="" border="0" src="<?php echo $o['img_thumb']!=''?Yii::app()->params['img_domain'].$o['img_thumb']:Yii::app()->baseUrl.'/images/game_default.jpg'?>" width="210" height="98" /></a></div>
                    <div class="news_left_right right">
                        <div class="clearfix">
                            <p class="title_left"><a href="<?php echo Yii::app()->createUrl('game/GameDetail/id').'/'.$o['id']?>" ><span><?php echo $o['title']?></span></a></p>
                        </div>
                        <p class="news_content"><?php echo MyFunction::csubstr(strip_tags($o['brief']),0,50,'>>>')?></p>
                    </div>
                </div>
            </li>
        <?php
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
                'maxButtonCount'=>5
            )
        );
        ?>
    </div>
</div>

<?php include Page::importFile('cfooter.php')?>
</body>
</html>