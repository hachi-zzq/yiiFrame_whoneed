<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include Page::importFile('cheader.php')?>
<div class="main_body">
    <p class="ct_dh"> <img alt="" border="0" src="<?php echo Yii::app()->baseUrl?>/images/mall.jpg" /></p>
</div>
<?php include Page::importFile('cfooter.php')?>
</body>
</html>