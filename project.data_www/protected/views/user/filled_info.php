<?php include Page::importFile('meta_header.php')?>

<title><?php echo CHtml::encode($pageTitle)?>--<?php echo WEB_NAME?></title>
    <link href="<?php echo Yii::app()->request->baseUrl?>/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/customer.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl?>/css/personData.css" rel="stylesheet" type="text/css">
    <script src="<?php echo Yii::app()->baseUrl?>/js/jquery-1.10.2.min.js"></script>
    <link href="<?php echo Yii::app()->baseUrl?>/css/personRecharge.css" rel="stylesheet" type="text/css">
    <!--图片裁剪css-->
    <link href="/css/crop.css" rel="stylesheet" type="text/css">
    <script language="javascript" type="text/javascript">
        <!--
        function postChk(){
            document.getElementById('runSub').style.display='block';
            document.getElementById('pform').submit();
        }


        -->
    </script>

</head>
<body>
<?php include Page::importFile('cheader.php')?>

<div class="main_body">
    <?php include Page::importFile('user_page_top.php','/common/')?>
    <div class="customer_content">
        <div id="menubox" class="mag_top15">
            <ul>
                <li id="zzjs1" onclick="setTab('zzjs',1,2)" class="pngFix">修改密码</li>
                <li id="zzjs2" onclick="setTab('zzjs',2,2)" class="active pngFix">完善资料</li>
            </ul>
        </div>
        <div id="conten">
<!--   修改密码-->
            <?php include Page::importFile('change_pass.php','/common/')?>
            <div id="con_zzjs_2" class="clearfix">
                <div class="perfectData_left left">
                    <form action="<?php echo Yii::app()->createUrl('/user/filledinfo')?>" method="post" name="perfectData" enctype="multipart/form-data" id="perfectData">
                        <label> 账&nbsp;&nbsp;号:</label>
                        <label class="ls_1 mar_left16" style="margin-left: 18px" > <?php echo $loginedInfo['username']?></label>
                        <br />
                        <br />
                        <label> 头&nbsp;&nbsp;像:</label>
<!--                        <a class="btn-file pngFix">-->
<!--                            <input type="file" name="user_head">-->
<!--                        </a>-->
                        <?php
                            if($loginedInfo['head_img']){
                        ?>
                        <img src="<?php echo Yii::app()->params['img_domain'].$loginedInfo['head_img']?>" width="100" height="100" style="margin-left: 18px;margin-bottom: 10px"/>
                            <?php
                            }
                        ?>
                        <input type="file" name="user_head" style="margin-left: 18px;">
<!--                        <a class="btn-file pngFix" style="position: relative;display: inline-block;width: 96px;height: 96px;background: url(/images/file_up.png) no-repeat center top;text-align: center;overflow: hidden;padding-left: 28px;""><input type="file" name="user_head" style="margin-left: 18px;"></a>-->

                        <br />
                        <br />
                        <label> 姓&nbsp;&nbsp;名:</label>
                        <input class="inputText_pe" type="text" name="truename" id="inputName" value="<?php echo $loginedInfo['true_name']?>"/>
                        <br />
                        <br />
                        <label> 身份证:</label>
                        <input class="inputText_pe" type="text" name="identity" id="inputId" value="<?php echo $loginedInfo['identity']?>"/>
                        <br />
                        <br />
                        <label> 手&nbsp;&nbsp;机:</label>
                        <input class="inputText_pe"  style="*margin-left:-10px" type="text" name="phone" id="inputPhone" value="<?php echo $loginedInfo['phone']?>"/>
<!--                        <input class="click" type="button" value="获取激活码" />-->
<!--                        <br />-->
<!--                        <br />-->
<!--                        <input class="inputText_determine" type="text" name="determine" id="determine" /><input class="click" type="button" value="确定" />-->
                        <br />
                        <br />
                        <label> 邮&nbsp;&nbsp;箱:</label>
                        <input class="inputText_pe" type="text" name="email" id="avatar" value="<?php echo $loginedInfo['email']?>" />
                        <br />
                        <br />
                        <input type="hidden" name="user_id" value="<?php echo Yii::app()->user->id?>">
                        <input class="btnLogin_person mag_left68" type="submit" value="确认填写" name="perfect" id="perfect" />
                    </form>
                </div>
                <div class="perfectData_right right pad_top120">
                    <p>温馨提示：</p>
                    <p>1.激活手机和邮箱后，可以使用手机和邮箱找回登录密码。</p>
                    <p>2.激活手机后，登录时既可以使用手机也可以时候用平台账号，密码不变。</p>
                    <p>3.姓名、身份证、手机、邮箱一经填写，无法修改。</p>
                    <p>4.激活手机后，可享受平台VIP福利。前往VIP福利介绍。</p>
                </div>
            </div>
        </div>


    </div>

</div>
</div>

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
