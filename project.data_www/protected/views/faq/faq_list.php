<?php include Page::importFile('meta_header.php')?>
    <title>客服-FAQ-<?php echo $type_name;?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/customer.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->baseUrl?>/css/person.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/personRecharge.css" rel="stylesheet" type="text/css">
    <script src="<?php echo  Yii::app()->baseUrl?>/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.4.4.min.js"></script>
    <script src="<?php echo Yii::app()->baseUrl?>/js/jquery.reveal.js"></script>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/faqRecharge.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/faqGames.css" rel="stylesheet" type="text/css" />

<!--[if lte IE 6]>
<style type="text/css">
html {
    /*这个可以让IE6下滚动时无抖动*/
    background: url(about:black) no-repeat fixed
}
.main_fotter{
    position: absolute;
}
.main_fotter , .reveal-modal-bg{
    /*这个解决body有padding时，IE6下100%不能铺满的问题*/
    width: expression(offsetParent.clientWidth);
}
/*下面三组规则用于IE6下top计算*/
.main_fotter{
    top: expression(offsetParent.scrollTop + offsetParent.clientHeight-offsetHeight);
}
</style>
<script src="js/DD_belatedPNG.js" type="text/javascript"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('div, ul, p, img, li, input , a');
    </script>
<![endif]-->
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
            <a href="<?php echo Yii::app()->createUrl('user/vipintroduce')?>">VIP体系介绍</a>
            <a href="<?php echo Yii::app()->createUrl('/faq/')?>" class="visited">FAQ</a>
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
  <div id="menubox" class="mag_top15">
      <ul>
        <?php foreach($fid_list as $id=>$name):;?>
            <li <?php if($type_fobj->id==$id):echo 'class="active"';endif;?>><a href="<?php echo Yii::app()->createUrl('faq/index',array('id'=>$id))?>"><?php echo $name;?></a></li>
        <?php endforeach; ?>
      </ul>
  </div>
  <div class="clearfix">
  <div class="b_left">
    <ul>
      <?php foreach($son_list as $obj): ?>
        <li <?php if($obj->id==$type_id): echo 'class="current"';endif;?>><a href="<?php echo Yii::app()->createUrl('faq/index',array('id'=>$obj->id))?>"><img alt="<?php echo $obj->name;?>" border="0" src="<?php echo Yii::app()->params['img_domain'].'/'.$obj->img;?>" width="220" height="110" /></a></li>
      <?php endforeach;?>
    </ul>
  </div>
  <div class="box b_right">
      <?php foreach($all as $i=>$obj): ?>
        <p class="title"><?php echo $obj->question; ?><span tip="<?php echo $i;?>">&nbsp;</span></p>
        <div class="question" style="display:none">
          <p><?php echo $obj->answer; ?></p>      
        </div>
        <p class="border1">&nbsp;</p>
      <?php endforeach;?>
  </div>
  </div>
  </div>
  <!-- 分页 -->
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
                    'pages' => $pages,
                    'maxButtonCount'=>13
                )
            );
            ?>
   </div>
</div>

<?php include Page::importFile('cfooter.php')?>
<script type="text/javascript">
$(document).ready(function(){       
	  $('.title span').toggle(
	  function(){
		 var n=$(this).attr("tip");
		 $('.title span').removeClass("current");
		 $(this).addClass("current");
		 $(".question").hide();
		 $(".question").eq(n).slideDown("fast");
		  },
	  function(){
		 var n=$(this).attr("tip");		
		 $(this).removeClass("current");		
		 $(".question").eq(n).hide("fast");
		  });
})
	 
</script>
</body>
</html>
