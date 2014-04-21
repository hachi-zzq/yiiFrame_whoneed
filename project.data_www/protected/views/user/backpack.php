<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/customer.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/personData.css" rel="stylesheet" type="text/css">
    <script src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.10.2.min.js"></script>
    <link href="<?php echo Yii::app()->baseUrl?>/css/personRecharge.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include Page::importFile('cheader.php')?>

<div class="main_body">
    <?php include Page::importFile('user_page_top.php','/common/')?>
    <div class="customer_content">
        <div class="pad_top30 clearfix">
            <p class="left">您最近获得的物品数量： <span>1</span></p>
            <p class="right"><a href="#" class="bacjpak_rt pad_rt12">前往积分商城></a></p>
        </div>
        <div class="rec_search">
            <form name="form1" method="post" action="">
                <p>物品获取记录检索：<span class="pad_left40"></span> 开始时间
                    <input type="text" class="input_time" name="start_time" id="txtBeginDate"   />
                    <span class="pad_left33"></span>结束时间
                    <input type="text" class="input_time" name="end_time" id="txtEndDate"  />
                    <input type="button" name="time_search" id="time_search" value="搜索" class="click" />
                </p>
            </form>
        </div>
        <table class="tb_list">
            <tbody>
            <tr class="tb_title">
                <td width="190">物品</td>
                <td width="300">来源</td>
                <td width="250">时间</td>
                <td width="190">分额</td>
                <td>备注</td>
            </tr>
            <tr class="tb_content">
                <td>游戏币</td>
                <td>积分商城抽奖</td>
                <td>2013.10.17-14：10</td>
                <td>500</td>
                <td>已发放</td>
            </tr>
            <tr class="tb_content">
                <td>游戏币</td>
                <td>积分商城抽奖</td>
                <td>2013.10.17-14：10</td>
                <td>500</td>
                <td>已发放</td>
            </tr>
            <tr class="tb_content">
                <td>游戏币</td>
                <td>积分商城抽奖</td>
                <td>2013.10.17-14：10</td>
                <td>500</td>
                <td>已发放</td>
            </tr>
            <tr class="tb_content">
                <td>游戏币</td>
                <td>积分商城抽奖</td>
                <td>2013.10.17-14：10</td>
                <td>500</td>
                <td>已发放</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="pagination mar_top35 mar_btm35"> <a href="#" class="page"><img alt="" src="<?php echo Yii::app()->baseUrl?>/images/bt_left.png" /></a> <a href="#" class="page current">1</a> <a href="#" class="page">2</a> <a href="#" class="page">3</a> <a href="#" class="page">4</a> <a href="#" class="page">5</a> <a href="#" class="page">6</a> <a href="#" class="page"><img alt="" src="<?php echo Yii::app()->baseUrl?>/images/bt_right.png" /></a> </div>
</div>
<?php include Page::importFile('cfooter.php')?>
</body>
</html>
