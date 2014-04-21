<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseurl;?>/css/gamesList.css" />
</head>
<body>
<?php include Page::importFile('cheader.php')?>

<div class="main_body">
    <div class="games_ul">
        <ul class="clearfix">
            <?php
                if(isset($game_list) && !empty($game_list)){
                    foreach($game_list as $g){
            ?>

            <li class="games_li">
                <div class="games_list"><a href="<?php if($g->status==1): echo $g->homepage_url;else: echo $this->createUrl('game/gameDetail/id/').'/'.$g->id; endif;?>"><img alt="" border="0" src="<?php echo Yii::app()->params['img_domain'].$g->img_thumb?>" /><span><?php echo $g->title;?></span></a></div>
            </li>
            <?php
                    }
                }
            ?>


            <li class="games_li">
                <div class="games_list"><a href="<?php echo $this->createUrl('game/index')?>"><img alt="" border="0" src="<?php echo Yii::app()->request->baseUrl.'/'?>images/game_more.jpg" /><span>更多</span></a></div>
            </li>
        </ul>
    </div>
</div>
<?php include Page::importFile('cfooter.php')?>
</body>
</html>