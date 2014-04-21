<?php include Page::importFile('meta_header.php')?>
<title>客服服务中心-问题提交</title>
    <link type="text/css" href="/css/tmp_style.css" rel="stylesheet" />
</head>
<body>
<div class="main_body">


    <div class="header">
        <div class="clearfix">
            <div class="logo left"></div>
            <div class="lg right"><span>***</span>&nbsp;&nbsp;欢迎您！&nbsp;&nbsp;<a href="#">退出登录</a></div></div>

            <div id="header_top" class="clearfix">

                <div id="title"><h1>客户服务中心<span>|</span>FAQ</h1></div>

                <div id="nav">
                    <ul>
                        <li><a href="#">首页</a></li>
                        <li><a href="#">vip体系</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">充值</a></li>
                        <li><a href="#">个人中心</a></li>
                    </ul>
                </div>

            </div>
        </div>
    <div id="content" class="clearfix">
        <ul>
        <?php foreach($all as $obj): ?>
            <li><a href="/faq/faqShow/id/<?php echo $obj->id;?>" title="<?php echo $obj->name;?>"><img border="0" src="<?php echo Yii::app()->params['img_domain'].'/'.$obj->img; ?>" alt="<?php echo $obj->name; ?>"></img></a></li>
        <?php endforeach;?>
        </ul>
    </div>
</div>
</body>
</html>
