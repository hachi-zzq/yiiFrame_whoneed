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
        <div id="menubox" class="mag_top15">
            <ul>
                <li id="zzjs1" onclick="setTab('zzjs',1,2)" class="pngFix">修改密码</li>
                <li id="zzjs2" onclick="setTab('zzjs',2,2)" class="active pngFix">个人资料</li>
            </ul>
        </div>
<!--      修改密码-->
       <?php include Page::importFile('change_pass.php','/common/')?>
       <div id="con_zzjs_2" class="clearfix">
                <div class="perfectData_left left">
                    <form action="" method="post" name="perfectData" id="perfectData">
                        <label> 头&nbsp;&nbsp;像:</label>
                        <label class="ls_1 pad_left16"><img alt="" border="0" width="100" height="100" src="<?php echo $loginedInfo['head_img']==''? Yii::app()->baseurl.'/images/no_head.jpg':Yii::app()->params['img_domain'].$loginedInfo['head_img']?>" /></label>
                        <br />
                        <br />
                        <label> 账&nbsp;&nbsp;号:</label>
                        <label class="ls_1 pad_left16"><?php echo $loginedInfo['username']?></label>
                        <br />
                        <br />
                        <label> 姓&nbsp;&nbsp;名:</label>
                        <label class="ls_1 pad_left16"><?php echo $loginedInfo['true_name']?></label>
                        <br />
                        <br />
                        <label> 身份证:</label>
                        <label class="ls_1 pad_left16"><?php echo MyFunction::setPhoneEmail($loginedInfo['identity'],2,-2,5)?></label>
<!--                        <input class="click" type="button" value="已激活" readonly />-->
                        <br />
                        <br />
                        <label> 手&nbsp;&nbsp;机:</label>
                        <label class="ls_1 pad_left16"><?php echo MyFunction::setPhoneEmail($loginedInfo['phone'],2,-2,5)?></label>
<!--                        <input class="click" type="button" value="已验证" readonly />-->
                        <br />
                        <br />
                        <label> 邮&nbsp;&nbsp;箱:</label>
                        <label class="ls_1 pad_left16"><?php echo MyFunction::setPhoneEmail($loginedInfo['email'],3,-5,5)?></label>
                        <br />
                        <br />
                        <input class="btnLogin_person" type="button" value="修改资料" onclick="javascript:window.location.href='<?php echo Yii::app()->createUrl('/user/filledinfo')?>'" name="changeData" id="changeData" />
                    </form>
                </div>
                <div class="perfectData_right right pad_top120">
                    <p>温馨提示：</p>
                    <p>1.激活手机和邮箱后，可以使用手机和邮箱找回登录密码。</p>
                    <p>2.激活手机后，登录时既可以使用手机也可以时候用平台账号，密码不变。</p>
                    <p>3.姓名、身份证、手机、邮箱一经填写，无法修改。</p>
                    <p>4.激活手机后，可享受平台VIP福利。前往VIP福利介绍。</p>
                </div>
<!--            </div>-->
        </div>

    </div>
</div>
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
    <!--
    function setTab(name,cursel,n){
        for(i=1;i<=n;i++){
            var menu=document.getElementById(name+i);/* zzjs1 */
            var con=document.getElementById("con_"+name+"_"+i);/* con_zzjs_1 */
            menu.className=i==cursel?"active":"";/*三目运算 等号优先*/
            con.style.display=i==cursel?"block":"none";
        }
    }

    function changeCheck(){
        if($('#originalPassword').val() == ''){
                alert('原密码不能为空');
            return false;
        }

        if($('#newPassword').val() == ''){
            alert('新密码不能为空');
            return false;
        }

        if($('#newPassword').val() !== $('#againNewPassword').val()){
            alert('两次密码不一致');
            return false;
        }
    }
    //-->
</script>
<?php include Page::importFile('cfooter.php')?>
</body>
</html>
