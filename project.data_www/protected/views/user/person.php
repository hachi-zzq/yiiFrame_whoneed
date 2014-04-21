<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/customer.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/person.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/personRecharge.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.4.4.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl?>/js/jquery.reveal.js"></script>

</head>
<body>
<!--引入头部-->
<?php include Page::importFile('cheader.php')?>

<div class="main_body">
<!--    load login register -->
<?php include Page::importFile('login.php','/common/')?>

<?php include Page::importFile('register.php','/common/')?>
<!--  载入用户登入头部    -->
<?php include Page::importFile('user_page_top.php','/common/')?>
    <div class="customer_ul">
        <ul class="clearfix">
            <li class="customer_li">
                <div class="customer_list"><a href="<?php echo Yii::app()->createUrl('user/logininfo')?>"><img alt="" border="0" src="<?php echo Yii::app()->baseUrl?>/images/person1.jpg" /><span>资料</span></a></div>
            </li>
<!--            <li class="customer_li">-->
<!--                <div class="customer_list"><a href="personVip.html"><img alt="" border="0" src="images/person2.jpg" /><span>VIP</span></a></div>-->
<!--            </li>-->
<!--            <li class="customer_li">-->
<!--                <div class="customer_list"><a href="personPoints.html"><img alt="" border="0" src="images/person3.jpg" /><span>积分</span></a></div>-->
<!--            </li>-->
            <li class="customer_li">
                <div class="customer_list"><a href="<?php echo Yii::app()->createUrl('innerletter')?>"><img alt="" border="0" src="<?php echo Yii::app()->baseUrl?>/images/person4.jpg" /><span>站内信</span></a></div>
            </li>
<!--            <li class="customer_li">-->
<!--                <div class="customer_list"><a href="personRecharge.html"><img alt="" border="0" src="images/person5.jpg" /><span>平台币</span></a></div>-->
<!--            </li>-->
            <li class="customer_li">
                <div class="customer_list"><a href="#"><img alt="" border="0" src="<?php echo Yii::app()->baseUrl?>/images/person6.jpg" /><span>推荐应用</span></a></div>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">

    function closeLogin(){
        document.getElementById("myModal").style.visibility="hidden";
    }
    function closeRegister(){
        document.getElementById("myModalRegister").style.visibility="hidden";
    }
</script>

<?php include Page::importFile('cfooter.php')?>

<script type="text/javascript">
    $(".bankbox > div:first").show();
    $(".choosebank li").each(function(index){
        $(this).click(function(){
            addrssid = $(this).attr("id");
            id = addrssid.replace('ban','');
            if($("#bank"+id).attr("checked")) {
                $(".choosebank li").removeClass('cur');
                $("#ban"+id).addClass('cur');
                $(".bankbox > div:visible").hide();
                $(".bankbox > div:eq(" + index + ")").show();
            }
        });
    });
</script>
</body>
</html>
