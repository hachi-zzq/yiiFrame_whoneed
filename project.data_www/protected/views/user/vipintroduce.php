<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl;?>/css/customer.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/person.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/personRecharge.css" rel="stylesheet" type="text/css">
    <script src="<?php echo  Yii::app()->baseUrl?>/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.4.4.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl?>/js/jquery.reveal.js"></script>
</head>
<body>
<?php include Page::importFile('cheader.php')?>

    <div class="main_body">
<?php include Page::importFile('login.php','/common/')?>

<?php include Page::importFile('register.php','/common/')?>
    <div class="customer_title clearfix">
        <div class="customer_nav">
            <a href="<?php echo Yii::app()->createUrl('customer')?>" >客服</a>
            <!--<a href="#">在线问题提交</a>-->
            <a href="<?php echo Yii::app()->createUrl('user/vipintroduce')?>" class="visited">VIP体系介绍</a>
            <a href="<?php echo Yii::app()->createUrl('/faq/')?>">FAQ</a>
            <!--<a href="#">自助式帐号解绑</a>-->
        </div>
        <??>
        <?php
        if(Yii::app()->user->isGuest){
            ?>
            <div class="customer_login">
                <a href="javascript:void(0);" data-reveal-id="myModal">登录</a>
                <span class="customer_span">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                <a href="javascript:void(0);" data-reveal-id="myModalRegister">注册</a>
            </div>

        <?php
        }else{
            ?>
            <div class="customer_login">
                <span class="customer_span_out"><?php echo Yii::app()->user->name?></span>
                <span class="customer_span_out">，欢迎您！</span>
                <a class="customer_a_out" href="<?php echo Yii::app()->createUrl('user/logout')?>">退出登录</a>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="customer_content">
        <p><img alt="" border="0" src="<?php echo Yii::app()->baseUrl;?>/images/vip_ct.jpg" /></p>
        <p class="cus_title">详情介绍：</p>
        <p>⑴ 账号绑定手机成功激活VIP后可以通过充值的方式来累加VIP经验。（使用手机注册默认激活VIP）</p>
        <p>⑵ 充值1RMB可以获得1点VIP经验</p>
        <p>⑶ 充值平台币返利：VIP1~VIP2：额外1%金币返还；VIP3~VIP4：2%金币返还；VIP5~VIP6：3%金币返还；VIP7~VIP8 : 4%金币返还；VIP9：5%金币返还。</p>
        <p>⑷ 赠送的平台币(金币)可用户直接充值游戏，平台币与人民币的比值为10：1。</p>
        <p>⑸ 直冲游戏可以享受到VIP经验和积分的加成，但无法享受充值后的返利。</p>
        <p>⑹ 每充值1元可以获得1点积分，积分可用于兑换平台商城内的物品或参与平台活动。</p>
        <p>⑺ 平台币充值游戏将不会获得VIP经验与积分。</p>
        <p>⑻ 当到达相应的VIP经验后，系统会自动提升您的VIP等级。（VIP经验详情请参见上图。）</p>
    </div>
</div>

<?php include Page::importFile('cfooter.php')?>
</body>
</html>