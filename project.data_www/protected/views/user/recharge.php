<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/customer.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/personRecharge.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include Page::importFile('cheader.php')?>

<div class="main_body">
    <?php include Page::importFile('user_page_top.php','/common/')?>

    <div class="customer_content">
        <p class="pad_top30">您的总充值金额为： <span>4000</span>元</p>
        <div class="rec_search">
            <form name="form1" method="post" action="">
                <p>充值记录检索：<span class="pad_left40"></span> 开始时间
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
                <td>订单号 </td>
                <td>充值游戏</td>
                <td>充值大区</td>
                <td>充值金额</td>
                <td>充值方式</td>
                <td>充值时间</td>
            </tr>
            <?php
                if(isset($all) && !empty($all)){
                    foreach($all as $v){
            ?>
            <tr  class="tb_content">
                <td><?php echo $v['order_number']?></td>
                <td><?php echo $v['games']?></td>
                <td><?php echo $v['region']?></td>
                <td><?php echo $v['money']?></td>
                <td><?php echo $v['name']?></td>
                <td><?php echo $v['recharge_time']?></td>
            </tr>
           <?php
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
<!--    <div class="pagination mar_top35 mar_btm35"> <a href="#" class="page"><img alt="" src="--><?php //echo Yii::app()->baseurl?><!--/images/bt_left.png" /></a> <a href="#" class="page current">1</a> <a href="#" class="page">2</a> <a href="#" class="page">3</a> <a href="#" class="page">4</a> <a href="#" class="page">5</a> <a href="#" class="page">6</a> <a href="#" class="page"><img alt="" src="--><?php //echo Yii::app()->baseurl?><!--/images/bt_right.png" /></a> </div>-->
</div>
<?php include Page::importFile('cfooter.php')?>
</body>
</html>
