<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseurl;?>/css/gamesDetail.css" />
</head>
<body>
<?php include Page::importFile('cheader.php')?>
    <div class="main_body clearfix gDetail_body">
        <div class="gd_content">
            <div class="gamesDetail_left">
            <div class="gLeft_title pngFix">游戏详情</div>
            <div class="gLeft_content clearfix">
                <div><img alt="" border="0" src="<?php echo !empty($oneDetail)&&!empty($oneDetail->img)?Yii::app()->params['img_domain'].'/'.$oneDetail->img:Yii::app()->baseUrl.'/images/game_default.png'?>" width="500" height="375" /></div>
                <div class="gamesDetail_download clearfix">
                    <div class="gamesDetail_download_left">
                        <div id="menubox">
                            <ul>
                                <li id="zzjs1" onmousemove="setTab('zzjs',2,2)" class="hover">IOS</li>
                                <li id="zzjs2"  onmousemove="setTab('zzjs',1,2)">Android</li>
                            </ul>
                        </div>
                        <div id="conten">
                            <?php
                                $alert = <<<EOT
onclick="alert('正在开发中，敬请期待');return false;"
EOT;
                            ?>
                            <div class="www_zzjs_net_show" id="con_zzjs_1"> <img width="80" height="80" alt="" border="0" src='<?php echo $android_code?>' /><a href="<?php echo $androidUrl?>" <?php if(empty($androidUrl)) echo $alert?> class="ct_btn">立即下载</a>
                            </div>
                            <div class="www_zzjs_net_show" id="con_zzjs_2"> <img width="80" height="80" alt="" border="0" src="<?php echo $ios_code?>" /><a href="<?php echo $iosUrl?>" <?php if(empty($iosUrl)) echo $alert?> class="ct_btn">立即下载</a></div>
                        </div>
                    </div>
                    <div class="gamesDetail_download_right"> <img alt="" border="0" src="<?php echo !empty($oneDetail)&&!empty($oneDetail->logo)?Yii::app()->params['img_domain'].$oneDetail->logo:Yii::app()->baseUrl.'/images/game_default_ico.png'?>" />
                        <p>用手机扫描左边二维码下载客户端</p>
                    </div>
                </div>
                <div class="gamesDetail_int">
                    <p class="gInt_title">游戏简介</p>
                    <div class="gInt_content">
                        <p><?php echo !empty($oneDetail)?$oneDetail->brief:''?></p>
                    </div>
                </div>
            </div>
        </div>

        <!---right-->
        <?php echo !empty($rightHtml)?$rightHtml:''?>
        </div>
    </div>
    <script>
        <!--
        function setTab(name,cursel,n){
            for(i=1;i<=n;i++){
                var menu=document.getElementById(name+i);/* zzjs1 */
                var con=document.getElementById("con_"+name+"_"+i);/* con_zzjs_1 */
                menu.className=i==cursel?"hover":"";/*三目运算 等号优先*/
                con.style.display=i==cursel?"block":"none";
            }
        }
        //-->
    </script>

<?php include Page::importFile('cfooter.php')?>
</body>
</html>