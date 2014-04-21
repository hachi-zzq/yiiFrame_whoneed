<?php include Page::importFile('meta_header.php')?>
    <title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo  Yii::app()->baseUrl?>/css/customer.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/person.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/personRecharge.css" rel="stylesheet" type="text/css">
    <script src="<?php echo  Yii::app()->baseUrl?>/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.4.4.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl?>/js/jquery.reveal.js"></script>

</head>
<body>
<?php include Page::importFile('cheader.php')?>

<?php include Page::importFile('login.php','/common/')?>

<?php include Page::importFile('register.php','/common/')?>
    <div class="main_body">
        <div class="customer_title clearfix">
            <div class="customer_nav">
                <a href="<?php echo Yii::app()->createUrl('customer')?>" class="visited">客服</a>
                <!--<a href="#">在线问题提交</a>-->
                <a href="<?php echo Yii::app()->createUrl('user/vipintroduce')?>">VIP体系介绍</a>
                <a href="<?php echo Yii::app()->createUrl('/faq/')?>">FAQ</a>
                <!--<a href="#">自助式帐号解绑</a>-->
            </div>
            <?php
              if(Yii::app()->user->isGuest){
            ?>

            <div class="customer_login">
                <a href="javascript:void(0);" data-reveal-id="myModal" >登录</a>
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
        <div class="customer_ul">
            <ul class="clearfix">
                <li class="customer_li"><div class="customer_list"><a href="<?php echo Yii::app()->createUrl('customer')?>"><img alt="" border="0" src="<?php echo  Yii::app()->baseUrl?>/images/customer1.jpg" /><span>在线问题提交</span></a></div></li>
                <li class="customer_li"><div class="customer_list"><a href="<?php echo Yii::app()->createUrl('user/vipintroduce')?>"><img alt="" border="0" src="<?php echo  Yii::app()->baseUrl?>/images/customer2.jpg" /><span>VIP体系介绍</span></a></div></li>
                <li class="customer_li"><div class="customer_list"><a href="<?php echo Yii::app()->createUrl('/faq')?>"><img alt="" border="0" src="<?php echo  Yii::app()->baseUrl?>/images/customer3.jpg" /><span>FAQ</span></a></div></li>
                <li class="customer_li"><div class="customer_list"><a href="#" ><img id="images" onmouseover="changeimg(1);"  onmouseout="changeimg(2);" alt="" border="0" src="<?php echo  Yii::app()->baseUrl?>/images/customer4.jpg" /></a></div></li>
                <li class="customer_li"><div class="customer_list"><a href="#"><img alt="" border="0" src="<?php echo  Yii::app()->baseUrl?>/images/customer5.jpg" /><span>电话客服</span></a></div></li>
                <li class="customer_li"><div class="customer_list"><a href="#"><img alt="" border="0" src="<?php echo  Yii::app()->baseUrl?>/images/customer6.jpg" /><span>自助式帐号解绑</span></a></div></li></ul>
        </div></div>
<script type="text/javascript">
    function closeLogin(){
        document.getElementById("myModal").style.visibility="hidden";
    }
    function closeRegister(){
        document.getElementById("myModalRegister").style.visibility="hidden";
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
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
    });
</script>
    <script>
        function changeimg(val){
            if(val==1){
                document.getElementById("images").src="images/micro-channel.jpg";
                document.getElementById("images").width="315";
                document.getElementById("images").height="196";
            }else{
                document.getElementById("images").src="images/customer4.jpg";
                document.getElementById("images").width="315";
                document.getElementById("images").height="196";
            }
        }
    </script>
<?php include Page::importFile('cfooter.php')?>
</body>
</html>